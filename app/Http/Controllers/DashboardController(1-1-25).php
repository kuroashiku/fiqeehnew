<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Complete;
use App\Post;
use App\Exports\StudentsActiveDetailExport;
use App\Exports\NoPaymentLeads;
use App\Exports\StudentsAllCrmExport;
use App\Exports\StudentsRetentionExport;
use App\Exports\StudentsRetentionDetailExport;
use App\Exports\Article;
// use App\LogAccessCourse;
use App\LogActiveUser;
use Excel;
use App\Course; 
use App\CourseUser;
use App\Enroll;
use App\Exports\ClassDetailsExport;
use App\Exports\ClassesExport;
use App\Exports\ProgramExport;
use App\Exports\PurchasesExport;
use App\Exports\StudentDetailsExport;
use App\Exports\StudentsExport;
use App\Exports\StudentLeadsExport;
use App\Exports\StudentsAllExport;
use App\Exports\StudentsCRMExport;
// use App\Classes\StudentsADSExport;
use App\Exports\NewExpiredExport;
use App\Payment;
use App\SurveyAnswer;
use App\SurveyQuestion;
use App\User;
use App\UserPayment;
use DateTime;
use DateInterval;
use DatePeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Province;
use App\PaymentAds; 
use Illuminate\Validation\Rule;



class DashboardController extends Controller
{
    public function index()  
    {
        $title = __t('dashboard');

        $user = Auth::user();

        $chartData = null;
        if ($user->user_type == 'student') {
            return redirect()->route('beranda');
        } elseif ($user->user_type == 'afiliasi') {
            return redirect()->route('afiliasi');
        }
        if ($user->isInstructor) {
            /**
             * Format Date Name
             */
            $start_date = date("Y-m-01");
            $end_date = date("Y-m-t");

            $begin = new \DateTime($start_date);
            $end = new \DateTime($end_date . ' + 1 day');
            $interval = \DateInterval::createFromDateString('1 day');
            $period = new \DatePeriod($begin, $interval, $end);

            $datesPeriod = array();
            foreach ($period as $dt) {
                $datesPeriod[$dt->format("Y-m-d")] = 0;
            }

            /**
             * Query This Month
             */

            $sql = "SELECT SUM(instructor_amount) as total_earning,
              DATE(created_at) as date_format
              from earnings
              WHERE instructor_id = {$user->id} AND payment_status = 'success'
              AND (created_at BETWEEN '{$start_date}' AND '{$end_date}')
              GROUP BY date_format
              ORDER BY created_at ASC ;";
            $getEarnings = DB::select(DB::raw($sql));

            $total_earning = array_pluck($getEarnings, 'total_earning');
            $queried_date = array_pluck($getEarnings, 'date_format');


            $dateWiseSales = array_combine($queried_date, $total_earning);

            $chartData = array_merge($datesPeriod, $dateWiseSales);
            foreach ($chartData as $key => $salesCount) {
                unset($chartData[$key]);
                //$formatDate = date('d M', strtotime($key));
                $formatDate = date('d', strtotime($key));
                $chartData[$formatDate] = $salesCount;
            }
        }

        return view(theme('dashboard.dashboard'), compact('title', 'chartData'));
    }
    public function adminDashboard(Request $request)
    {
        $ids = (array) $request->bulk_ids;

        if (is_array($ids) && in_array(1, $ids)) {
            return back()->with('error', __a('admin_non_removable'));
        }

        //Update
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            User::whereIn('id', $ids)->update(['active_status' => $request->status]);
            return back()->with('success', __a('bulk_action_success'));
        }

        if ($request->bulk_action_btn === 'delete' && is_array($ids) && count($ids)) {
            if (config('app.is_demo')) return back()->with('error', __a('demo_restriction'));

            User::whereIn('id', $ids)->delete();
            return back()->with('success', __a('bulk_action_success'));
        }

        $users = User::query();
        if ($request->q) {
            $users = $users->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                    ->orWhere('email', 'like', "%{$request->q}%")
                    ->orWhere('phone', 'like', "%{$request->q}%");
            });
        }

        $users = $users->where('user_type', 'student');
        if ($request->filter_status) {
            $users = $users->where('active_status', $request->filter_status);
        }

        $students = User::select(
            'id',
            'created_at',
            'expired_package_at'
        )->where('user_type', 'student');
        $students = $students->where('expired_package_at', '<=', date('Y-m-d'));

        $students = $students->get()->toArray();
        $dataLeads = [];
        foreach ($students as $key => $value) {
            $date1 = new DateTime($value['created_at']);
            $date2 = new DateTime($value['expired_package_at']);
            $interval = $date1->diff($date2);
            if ($interval->days > 5) {
                unset($dataLeads[$key]);
                continue;
            }

            $activePayment = UserPayment::where('user_id', $value['id'])->where('status', 1)->orderBy('created_at', 'DESC')->count();
            if ($activePayment > 0) {
                unset($dataLeads[$key]);
                continue;
            }
            $dataLeads[] = $value['id'];
        }
        if ($request->status != "") {
            switch ($request->status) {
                case 'Leads':
                    $users = $users->whereIn('id', $dataLeads);
                    break;
                case 'Active':
                    $users = $users->where('expired_package_at', '>=', date('Y-m-d'));
                    break;
                case 'Expired':
                    $users = $users->whereNotIn('id', $dataLeads);
                    $users = $users->where('expired_package_at', '<=', date('Y-m-d'));
                    break;
            }
        }


        $title = __a('users');
        $users = $users->orderBy('id', 'desc')->paginate(20);
        $course = Course::publish()->get();
        $product = UserPayment::select('product')->whereNotNull('product')->whereNotIn('product', ['Koreksi Expired'])->distinct()->get();

        $province = Province::get('provinsi')->whereNotNull('provinsi');
        
        return view('admin.dashboard', compact('title', 'users', 'course', 'dataLeads', 'product', 'province'));
    }

    public function profileSettings()
    {
        $title = __t('profile_settings');
        if (Auth::user()->user_type == 'afiliasi') {
            return view(theme('afiliasi.profile'), compact('title'));
        } else {
            return view(theme('dashboard.settings.profile'), compact('title'));
        }
    }

    public function profileSettingsPost(Request $request)
    {
        $rules = [
            'name'      => 'required',
            'job_title' => 'max:220',
        ];
        $this->validate($request, $rules);

        $input = array_except($request->input(), ['_token', 'social']);
        $user = Auth::user();
        $user->update($input);
        $user->update_option('social', $request->social);

        return back()->with('success', __t('success'));
    }

    public function resetPassword()
    {
        $title = __t('reset_password');
        return view(theme('dashboard.settings.reset_password'), compact('title'));
    }

    public function resetPasswordPost(Request $request)
    {
        if (config('app.is_demo')) {
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }
        $rules = [
            'old_password'  => 'required',
            'new_password'  => 'required|confirmed',
            'new_password_confirmation'  => 'required',
        ];
        $this->validate($request, $rules);

        $old_password = clean_html($request->old_password);
        $new_password = clean_html($request->new_password);

        if (Auth::check()) {
            $logged_user = Auth::user();

            if (Hash::check($old_password, $logged_user->password)) {
                $logged_user->password = Hash::make($new_password);
                $logged_user->save();
                return redirect()->back()->with('success', __t('password_changed_msg'));
            }
            return redirect()->back()->with('error', __t('wrong_old_password'));
        }
    }

    public function enrolledCourses()
    {
        $title = __t('enrolled_courses');
        return view(theme('dashboard.enrolled_courses'), compact('title'));
    }

    public function myReviews()
    {
        $title = __t('my_reviews');
        return view(theme('dashboard.my_reviews'), compact('title'));
    }

    public function wishlist()
    {
        $title = __t('wishlist');
        return view(theme('dashboard.wishlist'), compact('title'));
    }

    public function purchaseHistory()
    {
        $title = __t('purchase_history');
        return view(theme('dashboard.purchase_history'), compact('title'));
    }

    public function purchaseView($id)
    {
        $title = __a('purchase_view');
        $payment = UserPayment::find($id);
        return view(theme('dashboard.purchase_view'), compact('title', 'payment'));
    }

    public function surveyAnswer(Request $request)
    {
        foreach ($request->except('_token') as $key => $value) {
            SurveyAnswer::insert([
                'user_id'               => Auth::user()->id,
                'survey_question_id'    => $key,
                'answer'                => $value
            ]);
        }
        User::where('id', Auth::user()->id)->update([
            'is_survey' => 1
        ]);
        return redirect()->back()->with('success', 'Terima kasih telah mengisi survey dari kami');
    }

    public function reportStudent(Request $request)
    {
        $title = "Laporan Students";

        if ($request->filter == 'export_retention') {
            if ($request->start_date == "" && $request->end_date == "") {
                return back()->with('error', 'Harus menentukan tanggal penarikan data!');
            }

            $begin = new DateTime($request->start_date);
            $end = new DateTime($request->end_date);

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            $data = [];
            foreach ($period as $dt) {
                $dateDB = $dt->format("Y-m-d");
                $dateView = $dt->format("d/m/Y");

                $payment = UserPayment::where('status', 1)->whereNull('product_ads')
                    ->whereDate('tanggal_jatuh_tempo', $dateDB)
                    ->groupBy('tanggal_jatuh_tempo')
                    ->get();
                
                $totalJatuhTempo = User::whereDate('expired_package_at', $dateDB)->count();
                $totalPerpanjang = 0;
                $totalUserBaru = 0;
                foreach ($payment as $kP => $vP) {
                    $expDate = explode(' ', $vP->tanggal_jatuh_tempo);
                    if ($expDate[1] == '00:00:00') {
                        $totalJatuhTempo++;
                        $totalPerpanjang++;
                    } else {
                        $totalUserBaru++;
                    }
                }
                
                $data[] = [
                    'date' => $dateView,
                    'total_jatuh_tempo' => $totalJatuhTempo,
                    'total_perpanjang' => $totalPerpanjang
                ];
            }

            return Excel::download(new StudentsRetentionExport($data), 'Summary Retention Report.xlsx');
        }
        elseif ($request->filter == 'export_retention_detail') {
            if ($request->start_date == "" && $request->end_date == "") {
                return back()->with('error', 'Harus menentukan tanggal penarikan data!');
            }

            $begin = new DateTime($request->start_date);
            $end = new DateTime($request->end_date);

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            $data = [];
            foreach ($period as $dt) {
                $dateDB = $dt->format("Y-m-d");
                $dateView = $dt->format("d/m/Y");

                $payment = UserPayment::with('user')->where('status', 1)->whereNull('product_ads')
                    ->whereDate('tanggal_jatuh_tempo', $dateDB)
                    ->orderBy('id')
                    ->get();

                foreach ($payment as $vP) {
                    $expDate = explode(' ', $vP->tanggal_jatuh_tempo);
                    if ($expDate[1] == '00:00:00') {
                        $dataEnroll = [];
                        $enroll = Enroll::where('user_id', $vP->user->id)->orderBy('enrolled_at', 'DESC')->get()->toArray();
                        if ($enroll) {
                            $dataEnroll = $enroll;
                            $finded = 0;
                            foreach ($enroll as $keyE => $valueE) {
                                if ($finded == 1) {
                                    unset($dataEnroll[$keyE]);
                                } else {
                                    $course = Course::with('category')->where('id', $valueE['course_id'])->where('status', 1)->first();
                                    if ($course) {
                                        $finded = 1;
                                        $dataEnroll[$keyE]['course'] = $course->toArray();
                                    }
                                }

                            }
                        }

                        $data[] = [
                            'date' => $dateView,
                            'nama' => $vP->user->name,
                            'no_telp' => $vP->user->phone,
                            'email' => $vP->user->email,
                            'usia' => $vP->user->age,
                            'provinsi' => $vP->user->city,
                            'profesi' => $vP->user->job_title,
                            'detail_profesi' => $vP->user->about_me,
                            'jumlah_karyawan' => $vP->user->total_employee,
                            'product_perpanjang' => $vP->product,
                            'tanggal_perpanjang' => date('d/m/Y', strtotime($vP->started_at)),
                            'amount_perpanjang' => $vP->amount,
                            'tanggal_daftar' => $vP->user->created_at,
                            'product' => $vP->user->product,
                            'user_enrolls' => $dataEnroll
                        ];
                    }
                }

                $userJatuhTempo = User::where('user_type', 'student')->whereDate('expired_package_at', $dateDB)->get();

                foreach ($userJatuhTempo as $kP => $vP) {
                    $dataEnroll = [];
                    $enroll = Enroll::where('user_id', $vP['id'])->orderBy('enrolled_at', 'DESC')->get()->toArray();
                    if ($enroll) {
                        $dataEnroll = $enroll;
                        $finded = 0;
                        foreach ($enroll as $keyE => $valueE) {
                            if ($finded == 1) {
                                unset($dataEnroll[$keyE]);
                            } else {
                                $course = Course::with('category')->where('id', $valueE['course_id'])->where('status', 1)->first();
                                if ($course) {
                                    $finded = 1;
                                    $dataEnroll[$keyE]['course'] = $course->toArray();
                                }
                            }

                        }
                    }

                    $data[] = [
                        'date' => $dateView,
                        'nama' => $vP->name,
                        'no_telp' => $vP->phone,
                        'email' => $vP->email,
                        'usia' => $vP->age,
                        'provinsi' => $vP->city,
                        'profesi' => $vP->job_title,
                        'detail_profesi' => $vP->about_me,
                        'jumlah_karyawan' => $vP->total_employee,
                        'product_perpanjang' => '',
                        'tanggal_perpanjang' => null,
                        'amount_perpanjang' => 0,
                        'tanggal_daftar' => $vP->created_at,
                        'product' => $vP->product,
                        'user_enrolls' => $dataEnroll
                    ];

                }
            }

            return Excel::download(new StudentsRetentionDetailExport($data), 'Detail Retention Report.xlsx');
        }
        // elseif ($request->filter == 'export_access') {
        //     if ($request->start_date == "" && $request->end_date == "") {
        //         return back()->with('error', 'Harus menentukan tanggal penarikan data!');
        //     }

        //     $data = LogActiveUser::whereBetween('date', [
        //         date('Y-m-d', strtotime($request->start_date)),
        //         date('Y-m-d', strtotime($request->end_date))])
        //         ->get();
        //     foreach ($data as $key => $value) {
        //         $data[$key]->access_user = LogAccessCourse::whereDate('access_date', date('Y-m-d', strtotime($value->date)))->count();
        //     }

        //     return Excel::download(new StudentsActiveExport($data), 'Summary Access Report.xlsx');
        // }
        // elseif ($request->filter == 'export_access_detail') {
        //     $data = LogAccessCourse::with('user', 'course')
        //         ->whereBetween('access_date', [
        //         date('Y-m-d', strtotime($request->start_date)),
        //         date('Y-m-d', strtotime($request->end_date))])
        //         ->orderBy('access_date', 'ASC')
        //         ->get();

        //     return Excel::download(new StudentsActiveDetailExport($data), 'Detail Access Report.xlsx');
        // }

        $students = User::select(
            'id',
            'name',
            'email',
            'phone',
            'created_at',
            'expired_package_at',
            'afiliasi_id',
            'product',
            'age',
            'job_title',
            'total_employee',
            'about_me',
            'last_payment'
        )->where('user_type', 'student');

        if ($request->start_date != "" && $request->end_date == "") {
            $students = $students->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
            $students = $students->orWhere('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->start_date != "" && $request->end_date != "") {
            $students = $students->where(function ($query) use ($request) {
                $query->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                $query->where('users.created_at', '<=', $request->end_date . ' 23:59:59');
            });
            $students = $students->orWhere(function ($query) use ($request) {
                $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
            });
        }
        if ($request->q) {
            $students = $students->where('name', 'LIKE', "%{$request->q}%");
        }

        if ($request->filter) {
            $students = User::select(
                'id',
                'name',
                'email',
                'phone',
                'city',
                'created_at',
                'expired_package_at',
                'afiliasi_id',
                'product',
                'age',
                'job_title',
                'total_employee',
                'about_me',
                'product_ads'
            )->where('user_type', 'student')->where('is_delete',0);

            if ($request->q) {
                $students = $students->where('name', 'LIKE', "%{$request->q}%");
            }
            switch ($request->filter) {
                case 'export':
                    $leads = User::where('user_type', 'student')->where('expired_package_at', '<=', date('Y-m-d'));

                    if ($request->q) {
                        $leads = $leads->where('name', 'LIKE', "%{$request->q}%");
                    }

                    $leads = $leads->get();

                    $notIn = [];
                    foreach ($leads as $key => $value) {
                        $date1 = new DateTime($value['created_at']);
                        $date2 = new DateTime($value['expired_package_at']);
                        $interval = $date1->diff($date2);

                        if ($interval->days > 5) {
                            continue;
                        }

                        $activePayment = UserPayment::where('user_id', $value['id'])->where('status', 1)->orderBy('created_at', 'DESC')->count();
                        if ($activePayment > 0) {
                            continue;
                        }

                        $notIn[] = $value->id; 
                    }

                    if (count($notIn) > 0) {
                        $students = $students->whereNotIn('id', $notIn);
                    }

                    if ($request->start_date != "" && $request->end_date == "") {
                        $students = $students->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.created_at', '<=', $request->end_date . ' 23:59:59');
                        });
                    }

                    $data['students'] = $students->get()->toArray();
                    foreach ($data['students'] as $key => $value) {
                        $date1 = new DateTime($value['created_at']);
                        $date2 = new DateTime($value['expired_package_at']);
                        $interval = $date1->diff($date2);
                        if ($interval->days < 5) {
                            unset($data['students'][$key]);
                            continue;
                        }

                        $totalPayment = 0;
                        $payments = UserPayment::where('user_id', $value['id'])->orderBy('created_at', 'DESC')->get()->toArray();
                        if (count($payments) > 0 && $payments[0]['status'] == 1) {
                            $totalPayment += count($payments);
                            $data['students'][$key]['total_payment'] = 0;
                            foreach ($payments as $kP => $vP) {
                                $data['students'][$key]['total_payment'] += $vP['amount'];
                            }
                            $data['students'][$key]['payment'] = $payments;
                            $data['students'][$key]['phone'] = $value['phone'];
                        }

                        $payment_ads = PaymentAds::where('user_id', $value['id'])->orderBy('created_at', 'DESC')->get()->toArray();
                        if (count($payment_ads) > 0 && $payment_ads[0]['status'] == 1) {
                            $totalPayment += count($payment_ads);
                            $data['students'][$key]['total_payment'] = 0;
                            foreach ($payment_ads as $kP => $vP) {
                                $data['students'][$key]['total_payment'] += $vP['amount'];
                            }
                            $data['students'][$key]['payment'] = array_merge($data['students'][$key]['payment'], $payment_ads);
                            $data['students'][$key]['phone'] = $value['phone'];
                        }

                        $enroll = Enroll::with('course.category')->where('user_id', $value['id'])->orderBy('enrolled_at', 'DESC')->get();
                        if ($enroll) {
                            $dataKelas = $enroll->toArray();
                            $data['students'][$key]['user_enrolls'] = $dataKelas;
                        } else {
                            $dataKelas = [];
                            $data['students'][$key]['user_enrolls'] = [];
                        }
                        $data['students'][$key]['total_row'] = count($dataKelas);
                        if ($totalPayment > count($dataKelas)) {
                            $data['students'][$key]['total_row'] = $totalPayment;
                        }
                        if ($data['students'][$key]['total_row'] == 0) {
                            unset($data['students'][$key]);
                        }
                    }

                    return Excel::download(new StudentsAllCrmExport($data), 'CRM Class.xlsx');
                    break;
                case 'export_crm':
                    $leads = User::where('user_type', 'student')->where('expired_package_at', '<=', date('Y-m-d'));

                    if ($request->q) {
                        $leads = $leads->where('name', 'LIKE', "%{$request->q}%");
                    }

                    $leads = $leads->get();

                    $notIn = [];
                    foreach ($leads as $key => $value) {
                        $date1 = new DateTime($value['created_at']);
                        $date2 = new DateTime($value['expired_package_at']);
                        $interval = $date1->diff($date2);

                        if ($interval->days > 5) {
                            continue;
                        }

                        

                        $notIn[] = $value->id;
                    } 

                    if (count($notIn) > 0) {
                        $students = $students->whereNotIn('id', $notIn);
                    }

                    if ($request->start_date != "" && $request->end_date == "") {
                        $students = $students->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.created_at', '<=', $request->end_date . ' 23:59:59');
                        });
                    }
                    
                    $data['students'] = $students->get()->toArray();

                    $data['max_payment'] = 0; 
                    foreach ($data['students'] as $key => $value) {
                        $date1 = new DateTime($value['created_at']);
                        $date2 = new DateTime($value['expired_package_at']);
                        $interval = $date1->diff($date2);
                        if ($interval->days < 5) {
                            unset($data['students'][$key]);
                            continue;
                        }

                        $payments = UserPayment::where('user_id', $value['id'])->orderBy('id', 'ASC')->get();
                        if (count($payments) > 0 && $payments[0]->status == 1) {
                            if (count($payments) > $data['max_payment']) {
                                $data['max_payment'] = count($payments);
                            }
                            $data['students'][$key]['total_payment'] = 0;
                            foreach ($payments as $kP => $vP) {
                                $data['students'][$key]['total_payment'] += $vP['amount'];
                            }
                            $data['students'][$key]['payment'] = $payments;
                            $data['students'][$key]['phone'] = $value['phone'];
                        } else {
                            unset($data['students'][$key]);
                        }
                    } 
 
                    return Excel::download(new StudentsCRMExport($data), 'CRM Product.xlsx');
                    break;
                case 'export_ads':
                    $leads = User::where('user_type', 'student')->where('expired_package_at', '<=', date('Y-m-d'));

                    if ($request->q) {
                        $leads = $leads->where('name', 'LIKE', "%{$request->q}%");
                    }

                    $leads = $leads->get();

                    $notIn = [];
                    foreach ($leads as $key => $value) {
                        $date1 = new DateTime($value['created_at']);
                        $date2 = new DateTime($value['expired_package_at']);
                        $interval = $date1->diff($date2);

                        if ($interval->days > 5) {
                            continue;
                        }

                        $activePayment = UserPayment::where('user_id', $value['id'])->where('status', 1)->orderBy('created_at', 'DESC')->count();
                        if ($activePayment > 0) {
                            continue;
                        }

                        $notIn[] = $value->id;
                    }

                    if (count($notIn) > 0) {
                        $students = $students->whereNotIn('id', $notIn);
                    }

                    if ($request->start_date != "" && $request->end_date == "") {
                        $students = $students->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.created_at', '<=', $request->end_date . ' 23:59:59');
                        });
                    }
                    
                    $data['students'] = $students->get()->toArray();

                    $data['max_payment'] = 0;
                    foreach ($data['students'] as $key => $value) {
                        $date1 = new DateTime($value['created_at']);
                        $date2 = new DateTime($value['expired_package_at']);
                        $interval = $date1->diff($date2);
                        if ($interval->days < 5) {
                            unset($data['students'][$key]);
                            continue;
                        }

                        $payments = UserPayment::where('user_id', $value['id'])->orderBy('id', 'ASC')->get();
                        if (count($payments) > 0 && $payments[0]->status == 1) {
                            if (count($payments) > $data['max_payment']) {
                                $data['max_payment'] = count($payments);
                            }
                            $data['students'][$key]['total_payment'] = 0;
                            foreach ($payments as $kP => $vP) {
                                $data['students'][$key]['total_payment'] += $vP['amount'];
                            }
                            $data['students'][$key]['payment'] = $payments;
                            $data['students'][$key]['phone'] = $value['phone'];
                        } else {
                            unset($data['students'][$key]); 
                        }
                    }
                    $data['ads_payment'] = 0;
                    foreach ($data['students'] as $key => $value) {
                        $date1 = new DateTime($value['created_at']);
                        $date2 = new DateTime($value['expired_package_at']);
                        $interval = $date1->diff($date2);
                        if ($interval->days < 5) {
                            unset($data['students'][$key]);
                            continue;
                        }

                        $payments_ads = PaymentAds::where('user_id', $value['id'])->orderBy('id', 'ASC')->get();
                        if (count($payments_ads) > 0 && $payments_ads[0]->status == 1) {
                            if (count($payments_ads) > $data['ads_payment']) {
                                $data['ads_payment'] = count($payments_ads);
                            }
                            $data['students'][$key]['total_payment'] = 0;
                            foreach ($payments_ads as $kP => $vP) {
                                $data['students'][$key]['total_payment'] += $vP['amount'];
                            }
                            $data['students'][$key]['payment_ads'] = $payments_ads;
                            $data['students'][$key]['phone'] = $value['phone'];
                        } else {
                            unset($data['students'][$key]);
                        }
                    }

                    return Excel::download(new StudentsADSExport($data), 'Laporan Ads Students.xlsx');
                    break;
                case 'leads':
                    $leads = User::where('user_type', 'student')->where('expired_package_at', '<=', date('Y-m-d'));

                    if ($request->q) {
                        $leads = $leads->where('name', 'LIKE', "%{$request->q}%");
                    }

                    $leads = $leads->get();

                    $notIn = [];
                    foreach ($leads as $key => $value) {
                        $date1 = new DateTime($value['created_at']);
                        $date2 = new DateTime($value['expired_package_at']);
                        $interval = $date1->diff($date2);

                        if ($interval->days > 5) {
                            continue;
                        }

                        $activePayment = UserPayment::where('user_id', $value['id'])->where('status', 1)->orderBy('created_at', 'DESC')->count();
                        if ($activePayment > 0) {
                            continue;
                        }

                        $notIn[] = $value->id;
                    }

                    if (count($notIn) > 0) {
                        $students = $students->whereNotIn('id', $notIn);
                    }

                    if ($request->start_date != "" && $request->end_date == "") {
                        $students = $students->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.created_at', '<=', $request->end_date . ' 23:59:59');
                        });
                    }
                    
                    $data['students'] = $students->get()->toArray();

                    $data['max_payment'] = 0;
                    foreach ($data['students'] as $key => $value) {
                        $date1 = new DateTime($value['created_at']);
                        $date2 = new DateTime($value['expired_package_at']);
                        $interval = $date1->diff($date2);
                        if ($interval->days < 5) {
                            unset($data['students'][$key]);
                            continue;
                        }

                        $payments = UserPayment::where('user_id', $value['id'])->orderBy('id', 'ASC')->get();
                        if (count($payments) > 0 && $payments[0]->status == 1) {
                            if (count($payments) > $data['max_payment']) {
                                $data['max_payment'] = count($payments);
                            }
                            $data['students'][$key]['total_payment'] = 0;
                            foreach ($payments as $kP => $vP) {
                                $data['students'][$key]['total_payment'] += $vP['amount'];
                            }
                            $data['students'][$key]['payment'] = $payments;
                            $data['students'][$key]['phone'] = $value['phone'];
                        } else {
                            unset($data['students'][$key]);
                        }
                    }
                return Excel::download(new StudentLeadsExport($data), 'Laporan Leads Students.xlsx');
                    break;
                case 'export_student_all': 
                    if ($request->start_date != "" && $request->end_date == "") {
                        $students = $students->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.created_at', '<=', $request->end_date . ' 23:59:59');
                        });
                    }

                    $data['students'] = $students->where('expired_package_at', '>=', date('Y-m-d'))
                        ->get()->toArray();
                    $lastStudent = 0;
                    foreach ($data['students'] as $key => $value) {
                        $data['students'][$key]['payment'] = UserPayment::where('user_id', $value['id'])->where('status', 1)->orderBy('created_at', 'DESC')->first();

                        $dataEnroll = [];
                        $enroll = Enroll::where('user_id', $value['id'])->orderBy('enrolled_at', 'DESC')->get()->toArray();
                        if ($enroll) {
                            $dataEnroll = $enroll;
                            $finded = 0;
                            foreach ($enroll as $keyE => $valueE) {
                                if ($finded == 1) {
                                    unset($dataEnroll[$keyE]);
                                } else {
                                    $course = Course::with('category')->where('id', $valueE['course_id'])->where('status', 1)->first();
                                    if ($course) {
                                        $finded = 1;
                                        $dataEnroll[$keyE]['course'] = $course->toArray();
                                    }
                                }

                            }
                        }
                        $data['students'][$key]['user_enrolls'] = $dataEnroll;
                    }
                    return Excel::download(new StudentsAllExport($data), 'Laporan Active Students.xlsx');
                    break;
                // case 'export_student_detail_all':
                //     if ($request->start_date != "" && $request->end_date == "") {
                //         $students = $students->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                //     } elseif ($request->start_date != "" && $request->end_date != "") {
                //         $students = $students->where(function ($query) use ($request) {
                //             $query->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                //             $query->where('users.created_at', '<=', $request->end_date . ' 23:59:59');
                //         });
                //     }

                //     $data['students'] = $students->where('expired_package_at', '>=', date('Y-m-d'))
                //         ->get()->toArray();
                //     foreach ($data['students'] as $key => $value) {
                //         $data['students'][$key]['payment'] = UserPayment::where('user_id', $value['id'])->orderBy('created_at', 'DESC')->first();
                        
                //         $dataEnroll = [];
                //         $enroll = Enroll::where('user_id', $value['id'])->orderBy('enrolled_at', 'DESC')->get()->toArray();
                //         foreach ($enroll as $keyE => $valueE) {
                //             $course = Course::with('category')->where('id', $valueE['course_id'])->where('status', 1)->first();
                //             if ($course) {
                //                 $dataEnroll[$keyE]['course'] = $course->toArray();
                //             }
                //         }
                //         $data['students'][$key]['user_enrolls'] = $dataEnroll;
                //     }

                //     return Excel::download(new StudentsAllExport($data), 'Laporan Active Students.xlsx');
                //     break;
                case 'export_students_jatuh_tempo':
                    if ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
                        });
                    }

                    $students = $students->orderBy('users.expired_package_at', 'ASC');
                    $data['students'] = $students->with('user_enrolls.course.category')
                        ->get()->toArray();
                    foreach ($data['students'] as $key => $value) {
                        $date1 = new DateTime($value['created_at']);
                        $date2 = new DateTime($value['expired_package_at']);
                        $interval = $date1->diff($date2);

                        if ($interval->days > 5) {
                            $data['students'][$key]['payment'] = UserPayment::where('user_id', $value['id'])->orderBy('created_at', 'DESC')->first();
                        } else {
                            unset($data['students'][$key]);
                        }
                    }

                    return Excel::download(new StudentsAllExport($data), 'Laporan Jatuh Tempo Students.xlsx');
                    break;
                case 'export_students_expired_all':
                    if ($request->start_date != "" && $request->end_date == "") {
                        $students = $students->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
                        });
                    }
                    $data['students'] = $students->with('user_enrolls.course.category')
                        ->get()->toArray();
                    foreach ($data['students'] as $key => $value) {
                        $data['students'][$key]['payment'] = UserPayment::where('user_id', $value['id'])->orderBy('created_at', 'DESC')->first();
                    }

                    return Excel::download(new StudentsAllExport($data), 'Laporan Expired Students.xlsx');
                    break;
            }
        }
        $students = $students->with('user_afiliasi')->paginate(20);
        return view('admin.reports.students', compact('title', 'students'));
    }

    public function reportStudentDetail($id)
    {
        $student = User::where('id', $id)->first();
        $title = "Laporan Student " . $student->name;
        $courses = Enroll::select(
            'enrolls.course_id',
            'category_courses.category_id',
            'enrolls.enrolled_at',
            'courses.title',
            'categories.category_name'
        )->join('courses', 'courses.id', 'enrolls.course_id')
            ->join('category_courses', 'courses.id', 'category_courses.course_id')
            ->join('categories', 'categories.id', 'category_courses.category_id')
            ->where('enrolls.user_id', $id)
            ->where('enrolls.status', 'success')
            ->where('courses.status', 1)->paginate(10);
        $surveys = SurveyAnswer::select(
            'survey_questions.question',
            'survey_answers.answer'
        )->join('survey_questions', 'survey_questions.id', 'survey_answers.survey_question_id')
            ->where('survey_questions.publish', 1)
            ->where('survey_answers.user_id', $id)->get();

        return view('admin.reports.student_detail', compact('title', 'student', 'courses', 'surveys'));
    }

    public function reportNewStudent(Request $request)
    {
        $title = "Laporan New Student";
        $students = User::select(
            'id',
            'name',
            'email',
            'phone',
            'created_at',
            'expired_package_at',
            'afiliasi_id',
            'product',
            'age',
            'job_title',
            'total_employee',
            'about_me',
            'last_payment'
        )->where('user_type', 'student');

        if ($request->start_date != "" && $request->end_date == "") {
            $students = $students->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
            $students = $students->orWhere('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->start_date != "" && $request->end_date != "") {
            $students = $students->where(function ($query) use ($request) {
                $query->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                $query->where('users.created_at', '<=', $request->end_date . ' 23:59:59');
            });
            $students = $students->orWhere(function ($query) use ($request) {
                $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
            });
        }
        if ($request->q) {
            $students = $students->where('name', 'LIKE', "%{$request->q}%");
        }

        if ($request->filter) {
            $students = User::select(
                'id',
                'name',
                'email',
                'phone',
                'city',
                'created_at',
                'expired_package_at',
                'afiliasi_id',
                'product',
                'age',
                'job_title',
                'total_employee',
                'about_me'
            )->where('user_type', 'student');

            if ($request->q) {
                $students = $students->where('name', 'LIKE', "%{$request->q}%");
            }
            switch ($request->filter) {
                case 'export_students_expired_all_new':
                    if ($request->start_date != "" && $request->end_date == "") {
                        $students = $students->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
                        });
                    }
                    $data['students'] = $students->with('user_enrolls.course.category')
                        ->get()->toArray();
                    foreach ($data['students'] as $key => $value) {
                        $data['students'][$key]['payment'] = UserPayment::where('user_id', $value['id'])->orderBy('created_at', 'DESC')->first();
                    }

                    return Excel::download(new NewExpiredExport($data), 'Laporan New Expired.xlsx');
                    break;
            }
        }
        $students = $students->paginate(20);
        // return $classes;
        return view('admin.reports.new_student', compact('title', 'students'));
    }
    public function reportNoPayment(Request $request)
    {
        $title = "Laporan No Payment";
        $students = User::select(
            'id',
            'name',
            'email',
            'phone',
            'created_at',
            'expired_package_at',
            'afiliasi_id',
            'product',
            'age',
            'job_title',
            'total_employee',
            'about_me',
            'last_payment'
        )->where('user_type', 'student');

        if ($request->start_date != "" && $request->end_date == "") {
            $students = $students->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
            $students = $students->orWhere('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->start_date != "" && $request->end_date != "") {
            $students = $students->where(function ($query) use ($request) {
                $query->where('users.created_at', '>=', $request->start_date . ' 00:00:00');
                $query->where('users.created_at', '<=', $request->end_date . ' 23:59:59');
            });
            $students = $students->orWhere(function ($query) use ($request) {
                $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
            });
        }
        if ($request->q) {
            $students = $students->where('name', 'LIKE', "%{$request->q}%");
        }

        if ($request->filter) {
            $students = User::select(
                'id',
                'name',
                'email',
                'phone',
                'city',
                'created_at',
                'expired_package_at',
                'afiliasi_id',
                'product',
                'age',
                'job_title',
                'total_employee',
                'about_me'
            )->where('user_type', 'student');

            if ($request->q) {
                $students = $students->where('name', 'LIKE', "%{$request->q}%");
            }
            switch ($request->filter) {
                case 'export_students_expired_all_new':
                    if ($request->start_date != "" && $request->end_date == "") {
                        $students = $students->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
                        });
                    }
                    $data['students'] = $students->with('user_enrolls.course.category')
                        ->get()->toArray();
                    foreach ($data['students'] as $key => $value) {
                        $data['students'][$key]['payment'] = UserPayment::where('user_id', $value['id'])->orderBy('created_at', 'DESC')->first();
                    }

                    return Excel::download(new NewExpiredExport($data), 'Laporan New Expired.xlsx');
                    break;
            }
        }
        $students = $students->paginate(20);
        // return $classes;
        return view('admin.reports.no_payment', compact('title', 'students'));
    }

    public function exportNoLeads(Request $request)
    {
        

            $students = \App\User::whereUserType('student');

                    $totalLeads = $students->get();
                        foreach ($totalLeads as $key => $value) {
                            $date1 = new DateTime($value['created_at']);
                            $date2 = new DateTime($value['expired_package_at']);
                            $interval = $date1->diff($date2);
                            if ($interval->days > 5) {
                                unset($totalLeads[$key]);
                                continue;
                            }

                            $activePayment = \App\UserPayment::where('user_id', $value['id'])
                                ->where('status', 1)
                                ->orderBy('created_at', 'DESC')
                                ->count();
                            if ($activePayment > 0) {
                                unset($totalLeads[$key]);
                                continue;
                            }
                        }
                        // $students = $students->whereNotIn('id', $totalLeads);
                    $data['students'] = $totalLeads;

                    $data['max_payment'] = 0;
                    foreach ($totalLeads as $key => $value) {

                        $payments = UserPayment::where('user_id', $value['id'])->orderBy('id', 'ASC')->get();
                        if (count($payments) > 0 && $payments[0]->status == 1) {
                            if (count($payments) > $data['max_payment']) {
                                $data['max_payment'] = count($payments);
                            }
                            $data['students'][$key]['total_payment'] = 0;
                            foreach ($payments as $kP => $vP) {
                                $data['students'][$key]['total_payment'] += $vP['amount'];
                            }
                            $data['students'][$key]['payment'] = $payments;
                            $data['students'][$key]['phone'] = $value['phone'];
                        }
                    }
                return Excel::download(new NoPaymentLeads($data), 'Laporan Leads No Payment.xlsx');
    }

    public function exportNewExpiredStudent(Request $request)
    {
        

        if ($request->filter) {
            $students = User::select(
                'id',
                'name',
                'email',
                'phone',
                'city',
                'created_at',
                'expired_package_at',
                'afiliasi_id',
                'product',
                'age',
                'job_title',
                'total_employee',
                'about_me'
            )->where('user_type', 'student');

            if ($request->q) {
                $students = $students->where('name', 'LIKE', "%{$request->q}%");
            }
                    if ($request->start_date != "" && $request->end_date == "") {
                        $students = $students->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
                        });
                    }
                    $data['students'] = $students->with('user_enrolls.course.category')
                        ->get()->toArray();
                    foreach ($data['students'] as $key => $value) {
                        $data['students'][$key]['payment'] = UserPayment::where('user_id', $value['id'])->orderBy('created_at', 'DESC')->first();
                    }

                    return Excel::download(new NewExpiredExport($data), 'Laporan New Expired.xlsx');
        }
    }
    public function reportClass(Request $request)
    {
        $title = "Laporan Classes";
        $classes = Course::select(
            'id',
            'slug',
            'title',
            'level',
            'last_updated_at',
            'published_at',
            'status',
            'author',
            'video_src'
        )->where('status', 1)->with('reviews', 'sections', 'sections.items', 'sections.items.attachments', 'media');
        if ($request->q) {
            $classes = $classes->where('title', 'LIKE', "%{$request->q}%");
        }
        $classes = $classes->paginate(20);
        // return $classes;
        return view('admin.reports.classes', compact('title', 'classes'));
    }
    public function reportArticle(Request $request)
    {
        $title = "Laporan Article";
        $classes = Post::select(
            'id',
            'slug',
            'title',
            'status',
            'author',
        )->where('status', 1);
        if ($request->q) {
            $classes = $classes->where('title', 'LIKE', "%{$request->q}%");
        }
        $classes = $classes->paginate(20);
        // return $classes;
        return view('admin.reports.article', compact('title', 'classes'));
    }

    public function reportClassDetail($id)
    {
        $class = Course::with('sections.items')->where('id', $id)->first();
        $title = "Laporan Class " . $class->name;
        $enrolls = Enroll::with('user')->where('course_id', $id)->paginate(20);

        return view('admin.reports.class_detail', compact('title', 'class', 'enrolls'));
    }

    public function reportPurchases(Request $request)
    {
        $title = "Laporan Purchases";
        $payments = UserPayment::with('user');

        if ($request->q) {
            $payments = $payments->where('title', 'LIKE', "%{$request->q}%");
        }
        $payments = $payments->paginate(20);
        // return $payments;
        return view('admin.reports.payments', compact('title', 'payments'));
    }

    public function exportStudentDetail($id)
    {
        $student = User::select('id', 'name')->where('id', $id)->first()->toArray();

        $data['courses'] = Enroll::select(
            'enrolls.course_id',
            'category_courses.category_id',
            'enrolls.enrolled_at',
            'courses.title',
            'categories.category_name'
        )->join('courses', 'courses.id', 'enrolls.course_id')
            ->join('category_courses', 'courses.id', 'category_courses.course_id')
            ->join('categories', 'categories.id', 'category_courses.category_id')
            ->where('enrolls.user_id', $id)
            ->where('enrolls.status', 'success')
            ->where('courses.status', 1)->get()->toArray();

        return Excel::download(new StudentDetailsExport($data), 'Laporan Students ' . $student['name'] . '.xlsx');
    }

    public function exportClass()
    {
        $data['classes'] = Course::select(
            'id',
            'slug',
            'title',
            'level',
            'last_updated_at',
            'published_at',
            'status',
            'author',
            'video_src'
        )->where('status', 1)->with('category_class.category', 'sections.items')->get();

        return Excel::download(new ClassesExport($data), 'Laporan Classes.xlsx');
    }

    public function exportArticle()
    {
        $data['article'] = Post::select(
            'id',
            'slug',
            'title',
            'created_at',
            'post_content',
            'meta_description',
            'author',
        )->where('status', 1)->get();

        return Excel::download(new Article($data), 'Laporan Article.xlsx');
    }

    public function exportProgram()
    {
        $data['classes'] = Course::select(
            'id',
            'slug',
            'title',
            'level',
            'last_updated_at',
            'published_at',
            'status',
            'author'
        )->where('status', 1)->with('category_class.category', 'sections.items')->get();

        return Excel::download(new ProgramExport($data), 'Laporan Program.xlsx');
    }


    public function exportClassDetail($id)
    {
        $data['class'] = Course::with('sections.items')->where('id', $id)->first();

        $data['enrolls'] = Enroll::with('user')->where('course_id', $id)->get();

        return Excel::download(new ClassDetailsExport($data), 'Laporan Class ' . $data['class']->title . '.xlsx');
    }

    public function exportPurchases()
    {
        $data['payments'] = UserPayment::with('user')->get();

        return Excel::download(new PurchasesExport($data), 'Laporan Purchases.xlsx');
    }
}
