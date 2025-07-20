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
use App\Exports\PaymentOnlyEnd;
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

class ReportdateController extends Controller
{
    public function index(Request $request)
    {
        $title = "Laporan Students End Date";

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
            $students = $students->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
            $students = $students->orWhere('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
        } elseif ($request->start_date != "" && $request->end_date != "") {
            $students = $students->where(function ($query) use ($request) {
                $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
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
                        $students = $students->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
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

                    return Excel::download(new StudentsAllCrmExport($data), 'Class End Date.xlsx');
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
                        $students = $students->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
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
 
                    return Excel::download(new StudentsCRMExport($data), 'Product End Date.xlsx');
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
                        $students = $students->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
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

                    return Excel::download(new StudentsADSExport($data), 'Ads Students End Date.xlsx');
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
                        $students = $students->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
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
                        $students = $students->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                    } elseif ($request->start_date != "" && $request->end_date != "") {
                        $students = $students->where(function ($query) use ($request) {
                            $query->where('users.expired_package_at', '>=', $request->start_date . ' 00:00:00');
                            $query->where('users.expired_package_at', '<=', $request->end_date . ' 23:59:59');
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
                    return Excel::download(new StudentsAllExport($data), 'Active Students End Date.xlsx');
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

                    return Excel::download(new StudentsAllExport($data), 'Jatuh Tempo Students End Date.xlsx');
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

                    return Excel::download(new StudentsAllExport($data), 'Expired Students End Date.xlsx');
                    break;
            }
        }
        $students = $students->with('user_afiliasi')->paginate(20);
        return view('admin.datereport.index', compact('title', 'students'));
    }

    public function reportPaymentOnly(Request $request)
    {
        $title = "Laporan Payment Tanggal Berakhir";
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
                    $payment = UserPayment::whereBetween('user_payments.expired_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->orderBy('user_payments.id')
                    ->get();
                }
                

                if ($request->q) {
                    $payment = UserPayment::whereBetween('user_payments.expired_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('users.name', 'like', "%{$request->q}%")
                    ->orWhere('users.email', 'like', "%{$request->q}%")
                    ->orWhere('users.phone', 'like', "%{$request->q}%")
                    ->orderBy('user_payments.id')
                    ->get();
                }

                if ($request->status != "") {
                    $payment = UserPayment::whereBetween('user_payments.expired_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('user_payments.status', $request->status)
                    ->orderBy('user_payments.id')
                    ->get();
                }

                if ($request->city != "") {
                    $payment = UserPayment::whereBetween('user_payments.expired_at', [$request->start_date, $request->end_date])
                    ->join('users', 'user_payments.user_id', 'users.id')
                    ->where('users.city', $request->city)
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
                            'tanggal_berakhir' => $vP->expired_at,
                            'product' => $vP->user->product,
                            'status_payment' => $vP->status
                            // 'user_enrolls' => $dataEnroll
                        ];
                    }

            

            return Excel::download(new PaymentOnlyEnd($data), 'Payment Only End Date.xlsx');
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
            $students = $students->where('user_payments.expired_at', '>=', $request->start_date);
        }
        if ($request->end_date != "") {
            $students = $students->where('user_payments.expired_at', '<=', $request->end_date);
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


        return view('admin.datereport.payment_only', compact('title', 'students', 'province'));
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

}
