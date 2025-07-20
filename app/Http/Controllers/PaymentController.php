<?php

namespace App\Http\Controllers;

use App\FollowUp;
use App\Payment;
use App\User;
use App\UserPayment;
use App\Province;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Stripe\Product;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        $ids = $request->bulk_ids;

        //Update
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            foreach ($ids as $id) {
                dd('1');
                $payment = UserPayment::find($id)->first();

                UserPayment::find($id)->update([
                    'status'        => $request->status,
                    'verified_at'   => date('Y-m-d H:i:s')
                ]);

                User::find($payment->user_id)->update([
                    'expired_package_at' => date('Y-m-d H:i:s', strtotime('+1 month')),
                    'afiliasi_paid' => 3
                ]);
            }

            return back()->with('success', __a('bulk_action_success'));
        }

        $title = __a('payments');
        $provinsi = Province::where('provinsi','=',NULL);
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
        if ($request->status != "") { 
            $payments = $payments->where('user_payments.status', $request->status);
        }
        if ($request->filter_data == "category_product") {
            $payments = $payments->where('user_payments.category_product', NULL);
        }
        if ($request->filter_data == "monthly") {
            $payments = $payments->where('user_payments.monthly', NULL);
        }
        if ($request->filter_data == "expired") {
            $payments = $payments->where('user_payments.expired_at', NULL);
        }
        if ($request->start_date != "") {
            $payments = $payments->where('user_payments.created_at', '>=', $request->start_date);
        }
        if ($request->end_date != "") {
            $payments = $payments->where('user_payments.created_at', '<=', $request->end_date);
        }
        $payments = $payments->orderBy('user_payments.id', 'desc')->with('user')->paginate(20);

        $followUp = FollowUp::get();
        foreach ($followUp as $kf => $vf) {
            $followUp[$kf]['text'] = urldecode($vf['text']);
        }
        foreach ($payments as $key => $value) {
            $payments[$key]->file_payment = null;
            if ($value->detail_payment != null) {
                $detail = json_decode($value->detail_payment);
                if ($detail->payment_type == "manual") {
                    $value->file_payment = asset("").$detail->file;
                }
            }
        }
        
        return view('admin.payments.payments', compact('title', 'payments', 'followUp'));
    }
    public function indexDeleted(Request $request)
    {
        $ids = $request->bulk_ids;

        //Update
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            foreach ($ids as $id) {
                dd('1');
                $payment = UserPayment::find($id)->first();

                UserPayment::find($id)->update([
                    'status'        => $request->status,
                    'verified_at'   => date('Y-m-d H:i:s')
                ]);

                User::find($payment->user_id)->update([
                    'expired_package_at' => date('Y-m-d H:i:s', strtotime('+1 month')),
                    'afiliasi_paid' => 3
                ]);
            }

            return back()->with('success', __a('bulk_action_success'));
        }

        $title = __a('payments');

        $payments = UserPayment::select(
            'user_payments.*',
            'users.name',
            'users.email'
        )->join('users', 'user_payments.user_id', 'users.id')->where('user_payments.is_delete','=' ,1);
        if ($request->d) {
            $payments = $payments->where(function ($d) use ($request) {
                $d->where('users.name', 'like', "%{$request->d}%")
                    ->orWhere('users.email', 'like', "%{$request->d}%")
                    ->orWhere('users.phone', 'like', "%{$request->d}%");
            });
        }
        if ($request->status != "") {
            $payments = $payments->where('user_payments.status', $request->status);
        }
        if ($request->start_date != "") {
            $payments = $payments->where('user_payments.created_at', '>=', $request->start_date);
        }
        if ($request->end_date != "") {
            $payments = $payments->where('user_payments.created_at', '<=', $request->end_date);
        }
        $payments = $payments->orderBy('user_payments.id', 'desc')->with('user')->paginate(20);

        $followUp = FollowUp::get();
        foreach ($followUp as $kf => $vf) {
            $followUp[$kf]['text'] = urldecode($vf['text']);
        }
        foreach ($payments as $key => $value) {
            $payments[$key]->file_payment = null;
            if ($value->detail_payment != null) {
                $detail = json_decode($value->detail_payment);
                if ($detail->payment_type == "manual") {
                    $value->file_payment = asset("").$detail->file;
                }
            }
        }
        
        return view('admin.payments.deleted_payments', compact('title', 'payments', 'followUp','provinsi'));
    }

    public function view($id)
    {
        $title = __a('payment_details');
        $payment = UserPayment::find($id);
        return view('admin.payments.payment_view', compact('title', 'payment'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * Delete the Payment
     */ 
    public function delete($id)
    { 
        if (config('app.is_demo')) return back()->with('error', __a('demo_restriction'));

        $payment = UserPayment::find($id);
        if ($payment) {
            if($payment->is_delete){
                $payment->is_delete = 0;
            }else{
                $payment->is_delete = 1;
            }
        $payment->save();
        }
        return back();
    }
    public function deletes($id)
    {
        if (config('app.is_demo')) return back()->with('error', __a('demo_restriction'));

        $payment = UserPayment::find($id);
        if ($payment) {
            if($payment->is_delete){
                $payment->is_delete = 0;
            }else{
                $payment->is_delete = 0;
            }
        $payment->save();
        }
        return back();
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * Update the payment status, and it's related data
     */

    public function updateStatuss(Request $request, $id)
    {
        $payment = UserPayment::find($id);
        if ($payment) {
            $payment->status = $request->status;
            $payment->update();
        }
        if ($request->status == 1) {
            $user = User::find($payment->user_id);
            if (date('Y-m-d H:i:s') > $user->expired_package_at) {
                $user->update([
                    'expired_package_at' => date('Y-m-d H:i:s', strtotime('+'.$payment->monthly.' month')),
                    'afiliasi_paid' => 3
                ]);
            } else {
                $user->update([
                    'expired_package_at' => date('Y-m-d H:i:s', strtotime($user->expired_package_at.'+'.$payment->monthly.' month')),
                    'afiliasi_paid' => 3
                ]); 
            }
        }

        return back()->with('success', __a('success'));
    }
    public function updateStatus(Request $request, $id)
    {
        $payment = UserPayment::find($id);
        if ($payment) {
            $payment->status = $request->status;
            $payment->update();
        }
        if ($request->status == 1) {
            $user = User::find($payment->user_id);
            if (date('Y-m-d H:i:s') > $user->expired_package_at) {
                $user->update([
                    'expired_package_at' => date('Y-m-d H:i:s', strtotime('+'.$payment->monthly.' month')),
                    'afiliasi_paid' => 3
                ]);
            } else {
                $user->update([
                    'expired_package_at' => date('Y-m-d H:i:s', strtotime($user->expired_package_at.'+'.$payment->monthly.' month')),
                    'afiliasi_paid' => 3
                ]);
            }
        }

        return back()->with('success', __a('success'));
    }

    public function PaymentGateways()
    {
        $title = __a('payment_settings');
        return view('admin.payments.gateways.payment_gateways', compact('title'));
    }

    public function PaymentSettings()
    {
        $title = __a('payment_settings');
        return view('admin.payments.gateways.payment_settings', compact('title'));
    }

    public function thankYou()
    {
        $title = __t('payment_thank_you');
        return view(theme('payment-thank-you'), compact('title'));
    }

    public function followUp(Request $request)
    {
        return $request;
        $payment = UserPayment::with('user')->where('id', $request->id_payment)->first();

        $data = [
            'phone' => $payment->user->phone,
            'text' => str_replace(['username', 'usernominal'], [$payment->user->name, price_format($payment->amount)], urldecode(FollowUp::where('title', $request->folow_up)->first()->text))
        ];

        return $data;
    }

    public function followUpFormat(Request $request)
    {
        $payment = UserPayment::with('user')->where('id', $request->id_payment)->first();

        $text = str_replace(['username', 'usernominal'], [$payment->user->name, price_format($payment->amount)], urldecode(FollowUp::where('title', $request->folow_up)->first()->text));
        $data = [
            'phone' => $payment->user->phone,
            'text' => $text,
            'message' => urlencode($text)
        ];

        return $data;
    }

    public function followUpText(Request $request)
    {
        $post = $request->except("_token");

        foreach ($post as $key => $value) {
            FollowUp::where('id', $key)->update([
                'text' => $value['text'],
                'days' => (!empty($value['days'])) ? $value['days'] : null
            ]);
        }
        return back()->with('success', __a('success'));
    }

    private static function callQontak($url, $method ,$header, $body)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $method,
        CURLOPT_POSTFIELDS => json_encode($body),
        CURLOPT_HTTPHEADER => $header,
        ]);

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            dd($err);
        }

        return $response;
    }

    public function testFollowUp()
    {
        $auth = [
            "username" => "admin@fiqeeh.com",
            "password" => "Admin123!",
            "grant_type" => "password",
            "client_id" => "RRrn6uIxalR_QaHFlcKOqbjHMG63elEdPTair9B9YdY",
            "client_secret" => "Sa8IGIh_HpVK1ZLAF0iFf7jU760osaUNV659pBIZR00"
        ];

        $authToken = $this->callQontak("https://service-chat.qontak.com/oauth/token", "POST", [
            "Content-Type: application/json"
        ], $auth);

        $getWAChannel = $this->callQontak("https://service-chat.qontak.com/api/open/v1/integrations?target_channel=wa&limit=1", "GET", [
            "Authorization: Bearer ".$authToken['access_token'],
            "Content-Type: application/json"
        ], [])['data'][0]['id'];

        $message = [
            "to_number" => "6285803953891",
            "to_name" => "Yogie Setya Nugraha",
            "message_template_id" => "29c62369-7c5f-42b8-b319-6b7b602aaecc",
            "channel_integration_id" => $getWAChannel,
            "language" => [
                "code" => "id"
            ],
            "parameters" => [
                "body" => []
            ],
        ];
        $sendMessage = $this->callQontak("https://service-chat.qontak.com/api/open/v1/broadcasts/whatsapp/direct", "POST", [
            "Authorization: Bearer ".$authToken['access_token'],
            "Content-Type: application/json"
        ], $message);
        dd($sendMessage);
    }
    public function editPayment(Request $request, $id)
    {
        $post = $request->except("_token");

        DB::beginTransaction();
        try {
            $user = UserPayment::find($id);

            $user->update($post);

            DB::commit();
            return redirect()->back()->with('success', "User data updated!");
        } catch (\Exception $th) {
            DB::rollback();
            return redirect()->back()->with('error', "Failed update user data!");
        }
    }

    public function send(Request $request) 
    { 
        $users = UserPayment::select(
            'user_payments.*',
            'users.name',
            'users.email'
        )->join('users', 'user_payments.user_id', 'users.id')->where('user_payments.is_delete','=' ,1)->get();
                $textSend = urlencode($request->text_blast);
                $textSend2 = urlencode($request->text_blast2);
                $textSend3 = urlencode($request->text_blast3);
    
                $curl = curl_init();
 
                curl_setopt($curl, CURLOPT_URL, env('WOONOTIF_URL_API').'/api/send.php?type=text&message='.$textSend.'%0A%0A'.$textSend2.'%0A%0A'.$textSend3.'&number='.$request->text_phone.'&instance_id='.$request->text_instance.'&access_token=648a82c5d656c');
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
        return redirect()->back()->with('success', 'Blasting Telah Berhasil Di Kirim!');
    } 
    // public function delete(Request $request, $id)
    // {
    //     $post = $request->is_delete;

    //     DB::beginTransaction();
    //     try {
    //         $user = UserPayment::find($id);

    //         $user->update($post);

    //         DB::commit();
    //         return redirect()->back()->with('success', "User data updated!");
    //     } catch (\Exception $th) {
    //         DB::rollback();
    //         return redirect()->back()->with('error', "Failed update user data!");
    //     }
    // }
   
}
