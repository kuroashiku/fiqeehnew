<?php

namespace App\Http\Controllers;

use App\FollowUp;
use App\Payment;
use App\User;
use App\UserPayment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function index(Request $request)
    {
        $ids = $request->bulk_ids;

        //Update
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            foreach ($ids as $id) {
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
        )->join('users', 'user_payments.user_id', 'users.id');
        if ($request->q) {
            $payments = $payments->where(function ($q) use ($request) {
                $q->where('users.name', 'like', "%{$request->q}%")
                    ->orWhere('users.email', 'like', "%{$request->q}%");
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

        return view('admin.payments.payments', compact('title', 'payments', 'followUp'));
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
            $payment->delete();
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

    public function updateStatus(Request $request, $id)
    {
        $payment = UserPayment::find($id);
        if ($payment) {
            $payment->status = $request->status;
            $payment->update();
        }
        if ($request->status == 1) {
            User::find($payment->user_id)->update([
                'expired_package_at' => date('Y-m-d H:i:s', strtotime('+1 month')),
                'afiliasi_paid' => 3
            ]);
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
}
