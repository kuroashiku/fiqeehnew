<?php

namespace App\Http\Controllers;

use App\FollowUp;
use App\Payment;
use App\User;
use App\UserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminStaffController extends Controller
{

    public function index(Request $request)
    {
        $ids = $request->bulk_ids;

        //Update
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            User::find($request->user_id)->update([
                'active_status' => $request->status
            ]);
        }

        $title = "Staff";

        $staff = User::whereIn('user_type', ['admin', 'instructor']);

        if ($request->status != "") {
            $staff = $staff->where('status', $request->status);
        }
        if ($request->start_date != "") {
            $staff = $staff->where('created_at', '>=', $request->start_date);
        }
        if ($request->end_date != "") {
            $staff = $staff->where('created_at', '<=', $request->end_date);
        }
        $staff = $staff->orderBy('id', 'desc')->paginate(20);

        return view('admin.staff.index', compact('title', 'staff'));
    }

    public function view($id)
    {
        $title = "Staff Detail";
        $staff = User::find($id);
        return view('admin.staff.view', compact('title', 'staff'));
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

    public function store(Request $request)
    {
        $post = $request->except("_token");

        $post['password'] = Hash::make($post['password']);
        $post['active_status'] = 1;
        
        User::create($post);
        return back()->with('success', __a('success'));
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
            User::find($id)->update([
                'active_status' => $request->status
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
