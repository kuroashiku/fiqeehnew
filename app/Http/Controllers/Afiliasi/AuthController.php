<?php

namespace App\Http\Controllers\Afiliasi;

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

class AuthController extends Controller
{

    public function login()
    {
        $title = __t('login');
        return view_template('login', compact('title'));
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
            'password'     => $request->password
        ];

        if (Auth::attempt($credential, $request->remember_me)) {
            $auth = Auth::user();

            if ($request->_redirect_back_to) {
                return redirect($request->_redirect_back_to);
            }

            if ($auth->isAdmin()) {
                return redirect()->intended(route('admin'));
            } else {
                return redirect()->intended(route('dashboard'));
            }
        }

        return redirect()->back()->with('error', __t('login_failed'))->withInput($request->input());
    }


    public function register()
    {
        $title = __t('signup');
        $unique_price = substr(str_shuffle('0123456789'), 1, 3);
        return view_template('register', compact('title', 'unique_price'));
    }

    public function registerPost(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
            'phone' => 'required',
            'price' => 'required',
        ];

        $this->validate($request, $rules);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'user_type' => $request->user_as,
            'phone' => $request->phone,
            'expired_package_at' => date('Y-m-d H:i:s'),
            'active_status' => 1
        ]);

        UserPayment::create([
            'user_id'       => $user->id,
            'amount'        => $request->price,
            'unique_amount' => (int) get_option('price') - (int) $request->price,
            'status'        => 0
        ]);

        if ($user) {
            $this->loginPost($request);
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

    public function paymentDetail()
    {
        $sesUser = Session::get('user');

        if (is_null($sesUser)) {
            return redirect(route('login'));
        }

        $payment = UserPayment::where('user_id', $sesUser)
            ->where('status', 0)
            ->orderBy('id', 'DESC')
            ->first();
        if ($payment && $payment->detail_payment) {
            return redirect(route('login'))->with('success', 'Pembayaran sedang di proses, harap tunggu konfirmasi melalui email 2 X 24jam');
        } else {
            $unique_price = substr(str_shuffle('0123456789'), 1, 3);
            UserPayment::create([
                'user_id'       => $sesUser,
                'amount'        => (int) get_option('price') - (int) $unique_price,
                'unique_amount' => (int) $unique_price,
                'status'        => 0
            ]);
        }
        return view('extend.payment_detail');
    }

    public function paymentDetailPost(Request $request)
    {
        $rules = [
            'file'  => 'required',
        ];
        $this->validate($request, $rules);

        $randStr = substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', 5)), 0, 5);
        $file = current_disk()->putFileAs('uploads/payments', $request->file('file'), str_replace(' ', '_', strtolower($request->title)) . '_' . $randStr . '.pdf', 'public');

        UserPayment::where('id', $request->payment)->update([
            'detail_payment' => json_encode([
                'payment_type'  => 'manual',
                'file'          => $file
            ])
        ]);

        return redirect(route('login'))->with('success', 'Pembayaran sedang di proses, harap tunggu konfirmasi melalui email 2 X 24jam');
    }

    public function sendResetToken(Request $request)
    {
        $this->validate($request, ['email' => 'required']);

        $email = $request->email;

        $user = User::whereEmail($email)->first();
        if (!$user) {
            return back()->with('error', __t('email_not_found'));
        }

        $user->reset_token = str_random(32);
        $user->save();

        try {
            Mail::to($email)->send(new SendPasswordResetLink($user));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function passwordResetForm()
    {
        $title = __t('reset_your_password');
        return view(theme('auth.reset_form'), compact('title'));
    }

    public function passwordReset(Request $request, $token)
    {
        if (config('app.is_demo')) {
            return redirect()->back()->with('error', 'This feature has been disable for demo');
        }
        $rules = [
            'password'  => 'required|confirmed',
            'password_confirmation'  => 'required',
        ];
        $this->validate($request, $rules);

        $user = User::whereResetToken($token)->first();
        if (!$user) {
            return back()->with('error', __t('invalid_reset_token'));
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect(route('login'))->with('success', __t('password_reset_success'));
    }

    /**
     * Social Login Settings
     */

    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    public function redirectGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function redirectTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }
    public function redirectLinkedIn()
    {
        return Socialite::driver('linkedin')->redirect();
    }

    public function callbackFacebook()
    {
        try {
            $socialUser = Socialite::driver('facebook')->user();
            $user = $this->getSocialUser($socialUser, 'facebook');
            auth()->login($user);
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            return redirect(route('login'))->with('error', $e->getMessage());
        }
    }

    public function callbackGoogle()
    {
        try {
            $socialUser = Socialite::driver('google')->user();
            $user = $this->getSocialUser($socialUser, 'google');
            auth()->login($user);
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            return redirect(route('login'))->with('error', $e->getMessage());
        }
    }
    public function callbackTwitter()
    {
        try {
            $socialUser = Socialite::driver('twitter')->user();
            $user = $this->getSocialUser($socialUser, 'twitter');
            auth()->login($user);
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            return redirect(route('login'))->with('error', $e->getMessage());
        }
    }
    public function callbackLinkedIn()
    {
        try {
            $socialUser = Socialite::driver('linkedin')->user();
            $user = $this->getSocialUser($socialUser, 'linkedin');
            auth()->login($user);
            return redirect()->intended(route('dashboard'));
        } catch (\Exception $e) {
            return redirect(route('login'))->with('error', $e->getMessage());
        }
    }

    public function getSocialUser($providerUser, $provider = '')
    {
        $user = User::whereProvider($provider)->whereProviderUserId($providerUser->getId())->first();

        if ($user) {
            return $user;
        } else {

            $user = User::whereEmail($providerUser->getEmail())->first();
            if ($user) {

                $user->provider_user_id = $providerUser->getId();
                $user->provider = $provider;
                $user->save();
            } else {
                $user = User::create([
                    'email'             => $providerUser->getEmail(),
                    'name'              => $providerUser->getName(),
                    'user_type'         => 'user',
                    'active_status'     => 1,
                    'provider_user_id'  => $providerUser->getId(),
                    'provider'          => $provider,
                ]);
            }

            return $user;
        }
    }
}
