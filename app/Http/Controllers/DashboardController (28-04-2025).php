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
use App\Exports\PaymentOnly;
use App\Exports\AdsOnly;
use App\Exports\LeaOnly;
use App\Exports\StudentOnly;
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
use App\FollowUp;




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

            return Excel::download(new StudentsRetentionExport($data), 'Summary Retention.xlsx');
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

            return Excel::download(new StudentsRetentionDetailExport($data), 'Detail Retention.xlsx');
        }

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

                    return Excel::download(new StudentsAllCrmExport($data), 'Class.xlsx');
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

                    return Excel::download(new StudentsADSExport($data), 'Ads Students.xlsx');
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
                return Excel::download(new StudentLeadsExport($data), 'Leads Students.xlsx');
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
                    return Excel::download(new StudentsAllExport($data), 'Active Students.xlsx');
                    break;
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

                    return Excel::download(new StudentsAllExport($data), 'Jatuh Tempo Students.xlsx');
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

                    return Excel::download(new StudentsAllExport($data), 'Expired Students.xlsx');
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

                    return Excel::download(new NewExpiredExport($data), 'New Expired.xlsx');
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

                    return Excel::download(new NewExpiredExport($data), 'New Expired.xlsx');
                    break;
            }
        }
        $students = $students->paginate(20);
        // return $classes;
        return view('admin.reports.no_payment', compact('title', 'students'));
    }

    public function reportPaymentOnly(Request $request)
    {
        $title = "Laporan Payment Tanggal Daftar";
        if ($request->filter == 'export_payment_only') {
            if ($request->start_date == "" && $request->end_date == "") {
                return back()->with('error', 'Harus menentukan tanggal penarikan data!');
            }

            $begin = new DateTime($request->start_date);
            $end = new DateTime($request->end_date);

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            $data = [];
                if ($request->start_date != "") {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->orderBy('user_payments.id')
                    ->get();
                }
                

                if ($request->q) {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('users.name', 'like', "%{$request->q}%")
                    ->orWhere('users.email', 'like', "%{$request->q}%")
                    ->orWhere('users.phone', 'like', "%{$request->q}%")
                    ->orderBy('user_payments.id')
                    ->get();
                }

                if ($request->status != "") {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('user_payments.status', $request->status)
                    ->orderBy('user_payments.id')
                    ->get();
                }

                if ($request->city != "") {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('users.city', $request->city)
                    ->orderBy('user_payments.id')
                    ->get();
                }

                if ($request->age != "") {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('users.age', $request->age)
                    ->orderBy('user_payments.id')
                    ->get();
                }
                if ($request->job_title != "") {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('users.job_title', $request->job_title)
                    ->orderBy('user_payments.id')
                    ->get();
                }
                if ($request->product != "") {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('users.product', $request->product)
                    ->where('user_payments.is_delete', '!=', 1)
                    ->orderBy('user_payments.id')
                    ->get();
                }

                foreach ($payment as $vP) {
                        $data[] = [
                            // 'date' => $dateView,
                            'nama' => $vP->user->name,
                            'no_telp' => $vP->user->phone,
                            'email' => $vP->user->email,
                            'usia' => $vP->user->age,
                            'provinsi' => $vP->user->city,
                            'profesi' => $vP->user->job_title,
                            'detail_profesi' => $vP->user->about_me,    
                            'jumlah_karyawan' => $vP->user->total_employee,
                            'product_perpanjang' => $vP->product,
                            'tanggal_perpanjang' => date('d/m/Y', strtotime($vP->created_at)),
                            'amount_perpanjang' => $vP->amount,
                            'tanggal_daftar' => $vP->user->created_at,
                            'product' => $vP->user->product,
                            'status_payment' => $vP->status
                            // 'user_enrolls' => $dataEnroll
                        ];
                    }

            

            return Excel::download(new PaymentOnly($data), 'Payment Only.xlsx');
        }

        $students = UserPayment::select(
            'user_payments.*',
            'users.name',
            'users.email'
        )->join('users', 'user_payments.user_id', 'users.id')->where('user_payments.is_delete','!=' ,1);

        $dataLeads = [];
        foreach ($students as $key => $value) {
            $date1 = new DateTime($value['user_payments.created_at']);
            $date2 = new DateTime($value['user_payments.expired_package_at']);
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

        if ($request->q) {
            $students = $students->where(function ($q) use ($request) {
                $q->where('users.name', 'like', "%{$request->q}%")
                    ->orWhere('users.email', 'like', "%{$request->q}%")
                    ->orWhere('users.phone', 'like', "%{$request->q}%");
            });
        }
        if ($request->start_date != "") {
            $students = $students->where('user_payments.created_at', '>=', $request->start_date);
        }
        if ($request->end_date != "") {
            $students = $students->where('user_payments.created_at', '<=', $request->end_date);
        }
        if ($request->status != "") {
            $students = $students->where('user_payments.status', '=', $request->status);
        }
        if ($request->city != "") {
            $students = $students->where('users.city', '=', $request->city);
        }
        if ($request->age != "") {
            $students = $students->where('users.age', '=', $request->age);
        }
        if ($request->job_title != "") {
            $students = $students->where('users.job_title', '=', $request->job_title);
        }
        if ($request->product != "") {
            $students = $students->where('users.product', '=', $request->product);
        }


        $students = $students->orderBy('user_payments.id', 'desc')->with('user')->paginate(20);

        $followUp = FollowUp::get();
        foreach ($followUp as $kf => $vf) {
            $followUp[$kf]['text'] = urldecode($vf['text']);
        }
        foreach ($students as $key => $value) {
            $students[$key]->file_payment = null;
            if ($value->detail_payment != null) {
                $detail = json_decode($value->detail_payment);
                if ($detail->payment_type == "manual") {
                    $value->file_payment = asset("").$detail->file;
                }
            }
        }

        

        $province = Province::get('provinsi')->whereNotNull('provinsi');
        $cours = Course::where('category_id', '!=', 1205)->where('category_id', '!=', 1203)->orderBy('title','asc')->get();


        return view('admin.reports.payment_only', compact('title', 'students', 'province','cours'));
    }


    public function reportAdsOnly(Request $request)
    {
        $title = "Laporan Ads";
        if ($request->filter == 'export_ads_only') {
            if ($request->start_date == "" && $request->end_date == "") {
                return back()->with('error', 'Harus menentukan tanggal penarikan data!');
            }

            $begin = new DateTime($request->start_date);
            $end = new DateTime($request->end_date);

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            $data = [];
                if ($request->start_date != "") {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('user_payments.product_ads', '!=' , null)
                    ->orderBy('user_payments.id')
                    ->get();
                }
                

                if ($request->q) {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('user_payments.product_ads', '!=' , null)
                    ->where('users.name', 'like', "%{$request->q}%")
                    ->orWhere('users.email', 'like', "%{$request->q}%")
                    ->orWhere('users.phone', 'like', "%{$request->q}%")
                    ->orderBy('user_payments.id')
                    ->get();
                }

                if ($request->status != "") {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('user_payments.status', $request->status)
                    ->where('user_payments.product_ads', '!=' , null)
                    ->orderBy('user_payments.id')
                    ->get();
                }

                if ($request->city != "") {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('users.city', $request->city)
                    ->where('user_payments.product_ads', '!=' , null)
                    ->orderBy('user_payments.id')
                    ->get();
                }

                foreach ($payment as $vP) {
                        $data[] = [
                            // 'date' => $dateView,
                            'nama' => $vP->user->name,
                            'no_telp' => $vP->user->phone,
                            'email' => $vP->user->email,
                            'usia' => $vP->user->age,
                            'provinsi' => $vP->user->city,
                            'profesi' => $vP->user->job_title,
                            'detail_profesi' => $vP->user->about_me,    
                            'jumlah_karyawan' => $vP->user->total_employee,
                            'product_perpanjang' => $vP->product,
                            'product_ads' => $vP->product_ads,
                            'tanggal_perpanjang' => date('d/m/Y', strtotime($vP->created_at)),
                            'amount_perpanjang' => $vP->amount,
                            'tanggal_daftar' => $vP->user->created_at,
                            'product' => $vP->user->product,
                            'status_payment' => $vP->status
                        ];
                    }

            

            return Excel::download(new AdsOnly($data), 'Ads Only.xlsx');
        }

        $students = UserPayment::select(
            'user_payments.*',
            'users.name',
            'users.email'
        )->join('users', 'user_payments.user_id', 'users.id')->where('user_payments.is_delete','!=' ,1)->where('user_payments.product_ads', '!=' ,null);
        
        
        $dataLeads = [];
        foreach ($students as $key => $value) {
            $date1 = new DateTime($value['user_payments.created_at']);
            $date2 = new DateTime($value['user_payments.expired_package_at']);
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

        if ($request->q) {
            $students = $students->where(function ($q) use ($request) {
                $q->where('users.name', 'like', "%{$request->q}%")
                    ->orWhere('users.email', 'like', "%{$request->q}%")
                    ->orWhere('users.phone', 'like', "%{$request->q}%");
            });
        }
        if ($request->start_date != "") {
            $students = $students->where('user_payments.created_at', '>=', $request->start_date);
        }
        if ($request->end_date != "") {
            $students = $students->where('user_payments.created_at', '<=', $request->end_date);
        }
        if ($request->status != "") {
            $students = $students->where('user_payments.status', '=', $request->status);
        }
        if ($request->city != "") {
            $students = $students->where('users.city', '=', $request->city);
        }


        $students = $students->orderBy('user_payments.id', 'desc')->with('user')->paginate(20);

        $followUp = FollowUp::get();
        foreach ($followUp as $kf => $vf) {
            $followUp[$kf]['text'] = urldecode($vf['text']);
        }
        foreach ($students as $key => $value) {
            $students[$key]->file_payment = null;
            if ($value->detail_payment != null) {
                $detail = json_decode($value->detail_payment);
                if ($detail->payment_type == "manual") {
                    $value->file_payment = asset("").$detail->file;
                }
            }
        }

        

        $province = Province::get('provinsi')->whereNotNull('provinsi');


        return view('admin.reports.report_ads', compact('title', 'students', 'province'));
    }

    public function reportLEAOnly(Request $request)
    {
        $students_leads_lea = User::select(
            'id',
            'created_at',
            'expired_package_at'
        )->where('user_type', 'student');
        $students_leads_lea = $students_leads_lea->where('expired_package_at', '<=', date('Y-m-d'));

        $students_leads_lea = $students_leads_lea->get()->toArray();
        $dataLeads = [];
        foreach ($students_leads_lea as $key => $value) {
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

        $title = "Laporan User";
        if ($request->filter == 'export_lea') {
            if ($request->start_date == "" && $request->end_date == "") {
                return back()->with('error', 'Harus menentukan tanggal penarikan data!');
            }
            

            $begin = new DateTime($request->start_date);
            $end = new DateTime($request->end_date);

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            $data = [];
                if ($request->start_date != "") {
                    $payment = User::whereBetween('created_at', [$request->start_date, $request->end_date])
                    ->orderBy('last_payment')
                    ->get();
                }
                

                if ($request->q) {
                    $payment = User::whereBetween('created_at', [$request->start_date, $request->end_date])
                    ->where('name', 'like', "%{$request->q}%")
                    ->orWhere('email', 'like', "%{$request->q}%")
                    ->orWhere('phone', 'like', "%{$request->q}%")
                    ->orderBy('last_payment')
                    ->get();
                }

                if ($request->status == "Leads") {
                        $payment = User::whereBetween('created_at', [$request->start_date, $request->end_date])
                        ->whereIn('id', $dataLeads)
                        ->orderBy('last_payment')
                        ->get();
                    }

                if ($request->status == "Active") {
                    $payment = User::whereBetween('created_at', [$request->start_date, $request->end_date])
                    ->where('expired_package_at', '>=', date('Y-m-d'))
                    ->orderBy('last_payment')
                    ->get();
                }

                if ($request->status == "Expired") {
                    $payment = User::whereBetween('created_at', [$request->start_date, $request->end_date])
                    ->whereNotIn('id', $dataLeads)
                    ->where('expired_package_at', '<=', date('Y-m-d'))
                    ->orderBy('last_payment')
                    ->get();
                }

                if ($request->city != "") {
                    $payment = User::whereBetween('created_at', [$request->start_date, $request->end_date])
                    ->where('city', $request->city)
                    ->orderBy('last_payment')
                    ->get();
                }

                foreach ($payment as $vP) {
                        $data[] = [
                            // 'date' => $dateView,
                            'nama' => $vP->name,
                            'no_telp' => $vP->phone,
                            'email' => $vP->email,
                            'usia' => $vP->age,
                            'provinsi' => $vP->city,
                            'profesi' => $vP->job_title,
                            'detail_profesi' => $vP->about_me,    
                            'jumlah_karyawan' => $vP->total_employee,
                            'tanggal_daftar' => $vP->created_at,
                            'product' => $vP->product,
                            'expired' => $vP->expired_package_at,
                        ];
                    }

            

            return Excel::download(new LeaOnly($data), 'User Product Ads.xlsx');
        }

        $students = User::select(
            '*',
        )->where('user_type', 'student')->where('is_delete', 0)->where('product_ads', null);


        if ($request->q) {
            $students = $students->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                    ->orWhere('email', 'like', "%{$request->q}%")
                    ->orWhere('phone', 'like', "%{$request->q}%");
            });
        }
        if ($request->start_date != "") {
            $students = $students->where('created_at', '>=', $request->start_date);
        }
        if ($request->end_date != "") {
            $students = $students->where('created_at', '<=', $request->end_date);
        }

        if ($request->status != "") {
            switch ($request->status) {
                case 'Leads':
                    $students = $students->whereIn('id', $dataLeads);
                    break;
                case 'Active':
                    $students = $students->where('expired_package_at', '>=', date('Y-m-d'));
                    break;
                case 'Expired':
                    $students = $students->whereNotIn('id', $dataLeads);
                    $students = $students->where('expired_package_at', '<=', date('Y-m-d'));
                    break;
            } 
        }
        if ($request->city != "") {
            $students = $students->where('city', '=', $request->city);
        }


        $students = $students->orderBy('id', 'desc')->paginate(20);

        $followUp = FollowUp::get();
        foreach ($followUp as $kf => $vf) {
            $followUp[$kf]['text'] = urldecode($vf['text']);
        }
        foreach ($students as $key => $value) {
            $students[$key]->file_payment = null;
            if ($value->detail_payment != null) {
                $detail = json_decode($value->detail_payment);
                if ($detail->payment_type == "manual") {
                    $value->file_payment = asset("").$detail->file;
                }
            }
        }

        

        $province = Province::get('provinsi')->whereNotNull('provinsi');


        return view('admin.reports.lea', compact('title', 'students', 'province', 'dataLeads'));
    }


    public function reportStudentAja(Request $request)
    {

        $students_leads_lea = User::select(
            'id',
            'created_at',
            'expired_package_at'
        )->where('user_type', 'student');
        $students_leads_lea = $students_leads_lea->where('expired_package_at', '<=', date('Y-m-d'));

        $students_leads_lea = $students_leads_lea->get()->toArray();
        $dataLeads = [];
        foreach ($students_leads_lea as $key => $value) {
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

        $title = "Laporan Student Only";
        if ($request->filter == 'export_student_only') {
            if ($request->start_date == "" && $request->end_date == "") {
                return back()->with('error', 'Harus menentukan tanggal penarikan data!');
            }

            $begin = new DateTime($request->start_date);
            $end = new DateTime($request->end_date);

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            $data = [];
                if ($request->start_date != "") {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('user_payments.product_ads', '!=' , null)
                    ->orderBy('user_payments.id')
                    ->get();
                }
                

                if ($request->q) {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('user_payments.product_ads', '!=' , null)
                    ->where('users.name', 'like', "%{$request->q}%")
                    ->orWhere('users.email', 'like', "%{$request->q}%")
                    ->orWhere('users.phone', 'like', "%{$request->q}%")
                    ->orderBy('user_payments.id')
                    ->get();
                }

                if ($request->status != "Leads") {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->whereIn('user_payments.user_id', $dataLeads)
                    ->orderBy('user_payments.id')
                    ->get();
                }

                if ($request->city != "") {
                    $payment = UserPayment::whereBetween('user_payments.created_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('users.city', $request->city)
                    ->where('user_payments.product_ads', '!=' , null)
                    ->orderBy('user_payments.id')
                    ->get();
                }

                foreach ($payment as $vP) {
                        $data[] = [
                            // 'date' => $dateView,
                            'nama' => $vP->user->name,
                            'no_telp' => $vP->user->phone,
                            'email' => $vP->user->email,
                            'usia' => $vP->user->age,
                            'provinsi' => $vP->user->city,
                            'profesi' => $vP->user->job_title,
                            'detail_profesi' => $vP->user->about_me,    
                            'jumlah_karyawan' => $vP->user->total_employee,
                            'product_perpanjang' => $vP->product,
                            'product_ads' => $vP->product_ads,
                            'tanggal_perpanjang' => date('d/m/Y', strtotime($vP->created_at)),
                            'amount_perpanjang' => $vP->amount,
                            'tanggal_daftar' => $vP->user->created_at,
                            'product' => $vP->user->product,
                            'status_payment' => $vP->status
                        ];
                    }

            

            return Excel::download(new StudentOnly($data), 'Student Only.xlsx');
        }

        $students = User::select(
            '*',
        )->where('user_type', 'student')->where('is_delete', 0);


        if ($request->q) {
            $students = $students->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->q}%")
                    ->orWhere('email', 'like', "%{$request->q}%")
                    ->orWhere('phone', 'like', "%{$request->q}%");
            });
        }
        if ($request->start_date != "") {
            $students = $students->where('created_at', '>=', $request->start_date);
        }
        if ($request->end_date != "") {
            $students = $students->where('created_at', '<=', $request->end_date);
        }

        if ($request->status != "") {
            switch ($request->status) {
                case 'Leads':
                    $students = $students->whereIn('id', $dataLeads);
                    break;
                case 'Active':
                    $students = $students->where('expired_package_at', '>=', date('Y-m-d'));
                    break;
                case 'Expired':
                    $students = $students->whereNotIn('id', $dataLeads);
                    $students = $students->where('expired_package_at', '<=', date('Y-m-d'));
                    break;
            } 
        }
        if ($request->city != "") {
            $students = $students->where('city', '=', $request->city);
        }


        $students = $students->orderBy('id', 'desc')->paginate(20);

        $followUp = FollowUp::get();
        foreach ($followUp as $kf => $vf) {
            $followUp[$kf]['text'] = urldecode($vf['text']);
        }
        foreach ($students as $key => $value) {
            $students[$key]->file_payment = null;
            if ($value->detail_payment != null) {
                $detail = json_decode($value->detail_payment);
                if ($detail->payment_type == "manual") {
                    $value->file_payment = asset("").$detail->file;
                }
            }
        }

        

        $province = Province::get('provinsi')->whereNotNull('provinsi');


        return view('admin.reports.report_users', compact('title', 'students', 'province', 'dataLeads'));
    }

    public function exportPaymentOnly(Request $request)
    {
            $payments = UserPayment::select(
                'user_payments.*',
                'users.name',
                'users.email'
            )->join('users', 'user_payments.user_id', 'users.id')->where('user_payments.is_delete','!=' ,1);

            if ($request->q) {
                $payments = $payments->where(function ($q) use ($request) {
                    $q->where('users.name', 'like', "%{$request->q}%")
                        ->orWhere('users.email', 'like', "%{$request->q}%")
                        ->orWhere('users.phone', 'like', "%{$request->q}%");
                });
            }
            if ($request->start_date != "") {
                $payments = $payments->where('user_payments.created_at', '>=', $request->start_date);
            }
            if ($request->end_date != "") {
                $payments = $payments->where('user_payments.created_at', '<=', $request->end_date);
            }
            $payments = $payments->orderBy('user_payments.id', 'desc')->with('user');

            $data['payments'] = $payments;

            return Excel::download(new PaymentOnly($data), 'Laporan Payment Only.xlsx');
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
                return Excel::download(new NoPaymentLeads($data), 'Leads No Payment.xlsx');
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

                    return Excel::download(new NewExpiredExport($data), 'New Expired.xlsx');
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
            'video_src',
            'short_description'
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
            'video_src',
            'short_description'
        )->where('status', 1)->with('category_class.category', 'sections.items')->get();

        return Excel::download(new ClassesExport($data), 'Classes.xlsx');
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

        return Excel::download(new Article($data), 'Article.xlsx');
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
            'author',
            'short_description'
        )->where('status', 1)->with('category_class.category', 'sections.items')->get();

        return Excel::download(new ProgramExport($data), 'Program.xlsx');
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
