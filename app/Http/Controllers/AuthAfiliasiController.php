<?php

namespace App\Http\Controllers;

use App\Mail\SendPasswordResetLink;
use App\User;
use App\UserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use Session;

class AuthAfiliasiController extends Controller
{

    public function login()
    {
        $title = __t('login');
        $unique_code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 1, 7);

        return view_template('afiliasi.auth', compact('title', 'unique_code'));
    }

    public function loginPost(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required'
        ];

        $this->validate($request, $rules);

        $credential = [
            'email'     => $request->email,
            'password'  => $request->password,
            'user_type' => 'afiliasi'
        ];

        if (Auth::attempt($credential, $request->remember_me)) {
            $auth = Auth::user();
            if ($auth->active_status == 0) {
                Auth::logout();
                return redirect(route('afiliasi-login'))->with('success', 'Akun anda sedang di proses verifikasi, harap tunggu konfirmasi melalui email 2 X 24jam');
            } else {
                return redirect()->route('afiliasi');
            }
        }

        return redirect()->back()->with('error', __t('login_failed'))->withInput($request->input());
    }

    public function registerPost(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required',
        ];

        $this->validate($request, $rules);

        $userAffi = User::where('email', $request->email)->where('user_type', 'afiliasi')->first();
        if ($userAffi) {
            return back()->with('error', 'Email anda sudah terdaftar sebagai afiliasi')->withInput($request->input());
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_type' => $request->user_as,
            'phone' => $request->phone,
            'afiliasi_kode' => $request->afiliasi_kode,
            'active_status' => 0
        ]);

        if ($user) {
            return redirect(route('afiliasi-login'))->with('success', 'Pendaftaran sedang di proses, harap tunggu konfirmasi melalui email 2 X 24jam');
        }
        return back()->with('error', __t('failed_try_again'))->withInput($request->input());
    }

    public function logoutPost()
    {
        Auth::logout();
        return redirect('login');
    }

    public function forgotPassword()
    {
        $title = __t('forgot_password');
        return view(theme('auth.forgot_password'), compact('title'));
    }
}
