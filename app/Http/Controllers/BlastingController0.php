<?php
 
namespace App\Http\Controllers;
 
use App\BlastingSettings;
use App\FollowUp;
use App\Payment;
use App\User;
use App\UserAutoBlasting;
use App\UserPayment;
use Illuminate\Http\Request;
use App\Province;
use DateTime;
use App\Blasting;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlastingController extends Controller
{
    public function index(Request $request)
    {
        if ($request->blasting == 'auto_blasting' && !empty($request->title)) {
            $filter = $request->except('blasting', '_token', 'title', 'repeat_days', 'message');

            $repeatDays = 1;
            if ($request->repeat_days) {
                $repeatDays = $request->repeat_days;
            }

            UserAutoBlasting::insert([
                'title'         => $request->title,
                'filter'        => json_encode($filter),
                'repeat_days'   => $repeatDays,
                'message'       => $request->message,
                'next_call_date'=> date('Y-m-d')
            ]);

            return redirect()->back()->with('success', 'Auto Blasting Telah Ditambahkan!');
        }
        $title = "Blasting Expired";
        DB::enableQueryLog();
        $users = User::select('users.*', DB::raw('MAX(user_payments.started_at) AS payment_date'))
            ->leftJoin('user_payments', 'users.id', '=', 'user_payments.user_id')
            ->where('users.user_type', 'student')->where('users.expired_package_at', '<', date('Y-m-d'));

//        if ($request->intervalOption != "" && $request->intervalValue != "" && $request->intervalType != "") {
//            $filterPayment = UserPayment::select('user_payments.*');
//
//            $intervalFilterDate = date('Y-m-d', strtotime(now() . $request->intervalOption." ".$request->intervalValue." ". $request->intervalType));
//            $filterPayment = $filterPayment->whereDate(DB::raw('started_at'), $intervalFilterDate);
//
//            $filterPayment = $filterPayment->groupBy('user_id')->get()->toArray();
//        }

        if ($request->last_product != "") {
            $users = $users->where('users.product', $request->last_product);
        }
        if ($request->age != "") {
            $users = $users->where('users.age', $request->age);
        }
        if ($request->city != "") {
            $users = $users->where('users.city', $request->city);
        }
        if ($request->job_title != "") {
            $users = $users->where('users.job_title', $request->job_title);
        }
        if ($request->total_employee != "") {
            $users = $users->where('users.total_employee', $request->total_employee);
        }
        if ($request->expiredOption != "" && $request->expiredValue != "" && $request->expiredType != "") {
            if ($request->expiredOption == ">") {
                $option = "+";
            } elseif ($request->expiredOption == "<") {
                $option = "-";
            } else {
                $option = $request->expiredOption;
            }
            $expiredFilterDate = date('Y-m-d', strtotime(now() . $option." ".$request->expiredValue." ". $request->expiredType));

            if (in_array($request->expiredOption, ["-", "+"])) {
                $users = $users->whereDate('users.expired_package_at', $expiredFilterDate);
            } else {
                $users = $users->whereDate('users.expired_package_at', $request->expiredOption, $expiredFilterDate);
                $users = $users->orderBy('users.expired_package_at', ($request->expiredOption == '>') ? 'asc' : 'desc');
            }
        }
        if ($request->status != "") {
            switch ($request->status) {
                case 'Active':
                    $users = $users->whereDate('users.expired_package_at', '>', date('Y-m-d'));
                    break;
                case 'Expired':
                    $users = $users->whereDate('users.expired_package_at', '<', date('Y-m-d'));
                    break;
                case 'Leads':
                    $users = $users->where('users.expired_package_at', 'users.created_at');
                    break;
            }
        }

        if (!empty($request->all())) {
            $users = $users->orderBy('users.id', 'desc')->groupBy('users.id')->paginate(20);
        } else {
            $users = [];
        }

        $dataLeads = [];

        $product = UserPayment::select('product')->whereNotNull('product')->whereNotIn('product', ['Koreksi Expired'])->distinct()->get();

        $province = Province::get('provinsi')->whereNotNull('provinsi');

        $listAutoBlasting = UserAutoBlasting::get();

        return view('admin.blasting.index', compact('title', 'users', 'product', 'province', 'dataLeads', 'listAutoBlasting'));
    }


    public function indexActive(Request $request)
    {
        if ($request->blasting == 'auto_blasting' && !empty($request->title)) {
            $filter = $request->except('blasting', '_token', 'title', 'repeat_days', 'message');

            $repeatDays = 1;
            if ($request->repeat_days) {
                $repeatDays = $request->repeat_days;
            }

            UserAutoBlasting::insert([
                'title'         => $request->title,
                'filter'        => json_encode($filter),
                'repeat_days'   => $repeatDays,
                'message'       => $request->message,
                'next_call_date'=> date('Y-m-d')
            ]);

            return redirect()->back()->with('success', 'Auto Blasting Telah Ditambahkan!');
        }
        $title = "Blasting Active";
        DB::enableQueryLog();
        $users = User::select('users.*', DB::raw('MAX(user_payments.started_at) AS payment_date'))
            ->leftJoin('user_payments', 'users.id', '=', 'user_payments.user_id')
            ->where('users.user_type', 'student')->where('users.expired_package_at', '>', date('Y-m-d'));

//        if ($request->intervalOption != "" && $request->intervalValue != "" && $request->intervalType != "") {
//            $filterPayment = UserPayment::select('user_payments.*');
//
//            $intervalFilterDate = date('Y-m-d', strtotime(now() . $request->intervalOption." ".$request->intervalValue." ". $request->intervalType));
//            $filterPayment = $filterPayment->whereDate(DB::raw('started_at'), $intervalFilterDate);
//
//            $filterPayment = $filterPayment->groupBy('user_id')->get()->toArray();
//        }

        if ($request->last_product != "") {
            $users = $users->where('users.product', $request->last_product);
        }
        if ($request->age != "") {
            $users = $users->where('users.age', $request->age);
        }
        if ($request->city != "") {
            $users = $users->where('users.city', $request->city);
        }
        if ($request->job_title != "") {
            $users = $users->where('users.job_title', $request->job_title);
        }
        if ($request->total_employee != "") {
            $users = $users->where('users.total_employee', $request->total_employee);
        }
        if ($request->expiredOption != "" && $request->expiredValue != "" && $request->expiredType != "") {
            if ($request->expiredOption == ">") {
                $option = "+";
            } elseif ($request->expiredOption == "<") {
                $option = "-";
            } else {
                $option = $request->expiredOption;
            }
            $expiredFilterDate = date('Y-m-d', strtotime(now() . $option." ".$request->expiredValue." ". $request->expiredType));

            if (in_array($request->expiredOption, ["-", "+"])) {
                $users = $users->whereDate('users.expired_package_at', $expiredFilterDate);
            } else {
                $users = $users->whereDate('users.expired_package_at', $request->expiredOption, $expiredFilterDate);
                $users = $users->orderBy('users.expired_package_at', ($request->expiredOption == '>') ? 'asc' : 'desc');
            }
        }
        if ($request->status != "") {
            switch ($request->status) {
                case 'Active':
                    $users = $users->whereDate('users.expired_package_at', '>', date('Y-m-d'));
                    break;
                case 'Expired':
                    $users = $users->whereDate('users.expired_package_at', '<', date('Y-m-d'));
                    break;
                case 'Leads':
                    $users = $users->where('users.expired_package_at', 'users.created_at');
                    break;
            }
        }

        if (!empty($request->all())) {
            $users = $users->orderBy('users.id', 'desc')->groupBy('users.id')->paginate(20);
        } else {
            $users = [];
        }

        $dataLeads = [];

        $product = UserPayment::select('product')->whereNotNull('product')->whereNotIn('product', ['Koreksi Expired'])->distinct()->get();

        $province = Province::get('provinsi')->whereNotNull('provinsi');

        $listAutoBlasting = UserAutoBlasting::get();

        return view('admin.blasting.index_active', compact('title', 'users', 'product', 'province', 'dataLeads', 'listAutoBlasting'));
    }

    public function send(Request $request)
    {
        $users = User::where('user_type', 'student');

        if ($request->last_product != "") {
            $users = $users->where('product', $request->last_product);
        }
        if ($request->age != "") {
            $users = $users->where('age', $request->age);
        }
        if ($request->city != "") {
            $users = $users->where('city', $request->city);
        }
        if ($request->job_title != "") {
            $users = $users->where('job_title', $request->job_title); 
        }
        if ($request->total_employee != "") {
            $users = $users->where('total_employee', $request->total_employee);
        }
        if ($request->expiredOption != "" && $request->expiredValue != "" && $request->expiredType != "") {
            if ($request->expiredOption == ">") {
                $option = "+";
            } elseif ($request->expiredOption == "<") {
                $option = "-";
            } else {
                $option = $request->expiredOption;
            }
            $expiredFilterDate = date('Y-m-d', strtotime(now() . $option." ".$request->expiredValue." ". $request->expiredType));

            if (in_array($request->expiredOption, ["-", "+"])) {
                $users = $users->whereDate('users.expired_package_at', $expiredFilterDate);
            } else {
                $users = $users->whereDate('users.expired_package_at', $request->expiredOption, $expiredFilterDate);
                $users = $users->orderBy('users.expired_package_at', ($request->expiredOption == '>') ? 'asc' : 'desc');
            }
        }
        // if ($request->status != "") {
        //     switch ($request->status) {
        //         case 'Active':
        //             $users = $users->whereDate('users.expired_package_at', '>', date('Y-m-d'));
        //             break;
        //         case 'Expired':
        //             $users = $users->whereDate('users.expired_package_at', '<', date('Y-m-d'));
        //             break;
        //         case 'Leads':
        //             $users = $users->where('users.expired_package_at', 'users.created_at');
        //             break;
        //     }
        // }

        $users = $users->orderBy('id', 'desc')->get();      
        $auth = Auth::user();
        if($request->link_img != ""){
            foreach ($users as $value) {
                $textSend = urlencode(str_replace(['{name}', '{product}', '{profesi}', '{province}'], [$value->name, $value->product, $value->job_title, $value->city], $request->text_blast));
     
                $curl = curl_init();
    
                curl_setopt($curl, CURLOPT_URL, 'https://x3.woonotif.com/api/send.php?type=text&message='.$value->phone.'&type=media&message='.$textSend.'&media_url='.$request->link_img.'&filename=file_test.png&instance_id='.$request->text_acces.'&access_token='.env('WOONOTIF_ACCESS_TOKEN'));
                // /send.php?number=.$value->phone.&type=media&message=.$textSend.&media_url=.$request->link_img.&filename=file_test.png&instance_id=.$request->text_acces.&access_token=. env('WOONOTIF_ACCESS_TOKEN')
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($curl, CURLOPT_TIMEOUT, 10);
    
                $result = curl_exec($curl);
                if (curl_errno($curl)) {
                    echo 'Error:' . curl_error($curl);
                }
                curl_close($curl);
                // Blasting::insert([
                //         'id_user' => $value->id,
                //         'acces_id' => $request->text_acces,
                //         'message' => $request->text_blast,
                //         'target_phone' => $value->phone,
                //         'status' => 'succes',
                //         'blast_created' => date('Y-m-d'),
                //         'created_by' => $auth->session_id
                // ]);
                
            }
        }else{

            foreach ($users as $value) {
                $textSend = urlencode(str_replace(['{name}', '{product}', '{profesi}', '{province}'], [$value->name, $value->product, $value->job_title, $value->city], $request->text_blast));
    
                $curl = curl_init(); 

                curl_setopt($curl, CURLOPT_URL, 'https://x3.woonotif.com/api/send.php?type=text&message='.$textSend.'&number='.$value->phone.'&instance_id='.$request->text_instance.'&access_token=648a82c5d656c');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($curl, CURLOPT_TIMEOUT, 10);

                $result = curl_exec($curl);
                if (curl_errno($curl)) {
                    echo 'Error:' . curl_error($curl);
                }
                curl_close($curl);

                // Blasting::insert([
                //     'id_user' => $value->id,
                //     'acces_id' => $request->text_acces,
                //     'message' => $request->text_blast,
                //     'target_phone' => $value->phone,
                //     'status' => 'succes',
                //     'blast_created' => date('Y-m-d'),
                //     'created_by' => $auth->session_id
                // ]);
            }
        }
        return redirect()->back()->with('success', 'Blasting Telah Berhasil Di Kirim!');
    }

    // public function sendAutoBlasting()
    // {
    //     $timeLimit = ini_get('max_execution_time');
    //     set_time_limit(0);

    //     $getAutoBlasting = UserAutoBlasting::where('next_call_date', '<=', date('Y-m-d'))->get()->toArray();

    //     foreach ($getAutoBlasting as $k => $v) {
    //         $filter = (array) json_decode($v['filter']);

    //         $users = User::select('users.*', DB::raw('MAX(user_payments.started_at) AS payment_date'))
    //             ->leftJoin('user_payments', 'users.id', '=', 'user_payments.user_id')
    //             ->where('users.user_type', 'student');

    //         if ($filter['last_product'] != "") {
    //             $users = $users->where('users.product', $filter['last_product']);
    //         }
    //         if ($filter['age'] != "") {
    //             $users = $users->where('users.age', $filter['age']);
    //         }
    //         if ($filter['city'] != "") {
    //             $users = $users->where('users.city', $filter['city']);
    //         }
    //         if ($filter['job_title'] != "") {
    //             $users = $users->where('users.job_title', $filter['job_title']);
    //         }
    //         if ($filter['total_employee'] != "") {
    //             $users = $users->where('users.total_employee', $filter['total_employee']);
    //         }
    //         if ($filter['expiredOption'] != "" && $filter['expiredValue'] != "" && $filter['expiredType'] != "") {
    //             if ($filter['expiredOption'] == ">") {
    //                 $option = "+";
    //             } elseif ($filter['expiredOption'] == "<") {
    //                 $option = "-";
    //             } else {
    //                 $option = $filter['expiredOption'];
    //             }
    //             $expiredFilterDate = date('Y-m-d', strtotime(now() . $option." ".$filter['expiredValue']." ". $filter['expiredType']));

    //             if (in_array($filter['expiredOption'], ["-", "+"])) {
    //                 $users = $users->whereDate('users.expired_package_at', $expiredFilterDate);
    //             } else {
    //                 $users = $users->whereDate('users.expired_package_at', $filter['expiredOption'], $expiredFilterDate);
    //                 $users = $users->orderBy('users.expired_package_at', ($filter['expiredOption'] == '>') ? 'asc' : 'desc');
    //             }
    //         }
    //         if ($filter['status'] != "") {
    //             switch ($filter['status']) {
    //                 case 'Active':
    //                     $users = $users->whereDate('users.expired_package_at', '>', date('Y-m-d'));
    //                     break;
    //                 case 'Expired':
    //                     $users = $users->whereDate('users.expired_package_at', '<', date('Y-m-d'));
    //                     break;
    //                 case 'Leads':
    //                     $users = $users->where('users.expired_package_at', 'users.created_at');
    //                     break;
    //             }
    //         }

    //         $users = $users->orderBy('users.id', 'desc')->groupBy('users.id')->get();
    //         $blastingConfig = BlastingSettings::where('id', 1)->first();

    //         foreach ($users as $value) {
    //             $textSend = urlencode(str_replace(['{name}', '{product}', '{profesi}', '{province}'], [$value->name, $value->product, $value->job_title, $value->city], $v['message']));

    //             $curl = curl_init();

    //             curl_setopt($curl, CURLOPT_URL, 'https://x3.woonotif.com/api/send.php?type=text&message=' . $textSend . '&number=' . $value->phone . '&instance_id=' . $blastingConfig->instance_id . '&access_token=' . env('WOONOTIF_ACCESS_TOKEN'));
    //             curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    //             curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
    //             curl_setopt($curl, CURLOPT_TIMEOUT, 10);

    //             $result = curl_exec($curl);
    //             if (curl_errno($curl)) {
    //                 echo 'Error:' . curl_error($curl);
    //             }
    //             curl_close($curl);

    //             Blasting::insert([
    //                 'id_user' => $value->id,
    //                 'acces_id' => $blastingConfig->instance_id,
    //                 'message' => $textSend,
    //                 'target_phone' => $value->phone,
    //                 'status' => 'succes',
    //                 'blast_created' => date('Y-m-d'),
    //                 'created_by' => 1
    //             ]);
    //         }
    //         UserAutoBlasting::where('id', $v['id'])->update([
    //             'last_execution_date' => date('Y-m-d'),
    //             'next_call_date'=> date('Y-m-d',strtotime(now() . "+" . $v['repeat_days'] . " days"))
    //         ]);
    //     }

    //     set_time_limit($timeLimit);
    // }

    public function editText(Request $request) {
        for ($i=0; $i < count($request->id); $i++) { 
            $autoBlasting = UserAutoBlasting::find($request->id[$i]);
            $autoBlasting->message = $request->text[$i];
            $autoBlasting->save();
        }
        return redirect()->back()->with('success', 'Text Auto Blasting Telah Berhasil Di Ubah!');
    }

    public function deleteAutoBlasing($id)
    {
        UserAutoBlasting::where('id', $id)->delete();

        return redirect()->back()->with('success', 'Auto Blasting Telah Berhasil Di Hapus!');
    }
}
