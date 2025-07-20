<?php

namespace App\Http\Controllers;

use App\BlastingSettings;
use App\Course;
use App\Mail\SendPasswordResetLink;
use App\Option;
use App\User;
use App\UserPayment;
use App\FollowUp;
use App\TextSettings;
use Carbon\Traits\Test;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Laravel\Socialite\Facades\Socialite;
use phpDocumentor\Reflection\Types\Null_;
use Session;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        $title = __t('login');
        return view(theme('login'), compact('title'));
    }

    public function loginAfiliasi(Request $request)
    {
        $title = "Log In Afiliasi";
        return view('afiliasi.login', compact('title'));
    }

    public function loginPost(Request $request)
    {
        $rules = [
            'phone' => 'required',
            'kode_negara' => 'required',
            'password' => 'required'
        ];
        $this->validate($request, $rules);

        if (isset($request->user_as) && $request->user_as == 'afiliasi') {
            $checkUser = User::where('phone', change_phone_format($request->phone, $request->kode_negara))->where('user_type', 'afiliasi')->first();
            if (!$checkUser) {
                return redirect()->back()->with('error', 'Akun anda belum terdaftar')->withInput($request->input());
            }
        } else {
            $checkUser = User::where('phone', change_phone_format($request->phone, $request->kode_negara))->where('user_type', '!=', 'afiliasi')->first();
            if (!$checkUser) {
                return redirect()->back()->with('error', 'Akun anda belum terdaftar')->withInput($request->input());
            }
        }

        $credential = [
            'phone'     => $checkUser->phone,
            'password'     => $request->password,
            'user_type' => $checkUser->user_type
        ];

        if (Auth::attempt($credential, $request->remember_me)) {
            $request->session()->forget('token');
            $auth = Auth::user();

            if ($request->_redirect_back_to) {
                return redirect($request->_redirect_back_to);
            }

            $token = substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 200);
            User::where('id', $auth->id)->update([
                'session_id'    => $token,
                'attempt'       => 0,
                're_attempt_at' => null,
                'last_login'    => date('Y-m-d H:i:s',strtotime('now'))
            ]);
            $request->session()->put('token', $token);

            Log::info("Login : User " . $auth->name); 

            if ($auth->isAdmin()) {
                return redirect(route('admin'));
            } else if ($auth->user_type == 'instructor') {
                return redirect(route('dashboard'));
            } else if ($auth->user_type == 'afiliasi') {
                return redirect(route('afiliasi'));
            } else {
                return redirect(route('beranda'));
            }
        }

        // else {
        //     $user = User::where('email', $request->email)->first();
        //     if ($user) {
        //         if ($user->re_attempt_at != null && $user->re_attempt_at <= date("Y-m-d H:i:s", strtotime("+3 hours"))) {
        //             return redirect()->back()->with('error', 'Akunmu di blokir selama 3 jam')->withInput($request->input());
        //         } elseif ($user->attempt == 2) {
        //             User::where('id', $user->id)->update([
        //                 're_attempt_at' => date("Y-m-d H:i:s"),
        //                 'attempt'       => 0
        //             ]);
        //             return redirect()->back()->with('error', 'Akunmu telah di blokir selama 3 jam')->withInput($request->input());
        //         } else {
        //             User::where('id', $user->id)->increment('attempt', 1);
        //             return redirect()->back()->with('error', (3 - ($user->attempt + 1)) . ' kali lagi gagal, maka akunmu akan di blokir selama 3 jam')->withInput($request->input());
        //         }
        //     }
        // }

        return redirect()->back()->with('error', "Login gagal, nomor atau password salah!")->withInput($request->input());
    }

    public function register()
    {
        $title = __t('signup');
        $unique_price = substr(str_shuffle('0123456789'), 1, 3);
        return view(theme('register'), compact('title', 'unique_price'));
    }

    public function registerAfiliasi()
    {
        $title = __t('signup');
        $unique_price = substr(str_shuffle('0123456789'), 1, 3);
        return view('afiliasi.register', compact('title', 'unique_price'));
    }

    public function registerCourse($course)
    {
        $title = __t('signup');
        $unique_price = substr(str_shuffle('0123456789'), 1, 3);
        return view(theme('register'), compact('title', 'unique_price', 'course'));
    }

    public function registerPost(Request $request)
    {
        if ($request->user_as == 'afiliasi') {
            $checkUser = User::where('phone', $request->phone)->where('user_type', 'afiliasi')->first();
            if ($checkUser) {
                return redirect(route('loginAfiliasi'))->with('error', 'Akun anda sudah terdaftar. Silahkan login disini untuk mengakses Fiqeeh.');
            }

            $rules = [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|min:6',
                'phone' => 'required',
                'no_rekening' => 'required',
                'kode_rekening' => 'required',
                'price' => 'required',
                'kode_negara' => 'required'
            ];
            $this->validate($request, $rules);
        } else {
            $instance = BlastingSettings::where('id',1)->first();
            $penerima = BlastingSettings::where('id',3)->first();
            $sending = TextSettings::where('id',5)->first();
            $textSend = urlencode(str_replace(['{name}','{phone}','{email}'], [$request->name, $request->phone, $request->email],$sending->text));
            $textSend2 = urlencode($request->text_blast2);
            $textSend3 = urlencode($request->text_blast3);

            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, 'https://x3.woonotif.com/api/send.php?type=text&message='.$textSend.'&number='.$penerima->nomor.'&instance_id='.$instance->instance_id.'&access_token=648a82c5d656c');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);

            $result = curl_exec($curl);
            if (curl_errno($curl)) {
                echo 'Error:' . curl_error($curl);
            }
            curl_close($curl);

            $checkUser = User::where('phone', $request->phone)->where('user_type', 'student')->first();
            if ($checkUser) {
                return redirect(route('login'))->with('error', 'Akun anda sudah terdaftar. Silahkan login disini untuk mengakses Fiqeeh.');
            }

            $rules = [
                'name' => 'required|max:255',
                'email' => 'required|email|max:255',
                'password' => 'required|min:6',
                'phone' => 'required',
                'price' => 'required',
                'kode_negara' => 'required'
            ];
            $this->validate($request, $rules);
        }

        $produk = null;
        if ($request->product) {
            $followUp = FollowUp::where('title', 'W2')->first();

            $curl = curl_init();
 
            $course = Course::whereSlug($request->product)->first();

            curl_setopt_array($curl, array(
                CURLOPT_URL, env('WOONOTIF_URL_API') . '/api/send.php?type=text&message=' . urlencode(str_replace(['{{name}}', '{{produk}}'], [$request->name, $course->title], $followUp->text)) . '&number=' . change_phone_format($request->phone, $request->kode_negara) . '&instance_id=' . env('WOONOTIF_INSTANCE_ID') . '&access_token=' . env('WOONOTIF_ACCESS_TOKEN'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10, 
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
            ));

            curl_exec($curl);
            curl_close($curl);

            $produk = $course->title;

            if (!$request->from_page && $request->session()->get('reff')) {
                $userReff = User::where('afiliasi_code', $request->session()->get('reff'))
                    ->where('active_status', 1)->first();
                $optionKomisi = Option::where('option_key', 'komisi_kelas')->first();
            }
            if ($request->file != null){
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => bcrypt($request->password),
                    'user_type' => $request->user_as,
                    'phone' => change_phone_format($request->phone, $request->kode_negara),
                    'expired_package_at' => date('Y-m-d H:i:s', strtotime('-1 day', time())),
                    'category_product' => 1,
                    'product' => 'Kampus Bisnis Syariah',
                    'active_status' => 0,
                    'afiliasi_id' => (isset($userReff)) ? $userReff->id : null,
                    'product' => $produk,
                    'last_payment' => date('Y-m-d H:i:s',strtotime('now'))
                ]);

                // $user_name = Auth::user()->name;
                // $user_email = Auth::user()->email; 
                // $user_phone = Auth::user()->phone;
                // $user_id = Auth::user()->id;
                $lastUserId = User::max('id');

                $randStr = substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', 5)), 0, 5);
                $file = current_disk()->putFileAs('public/uploads/payments', $request->file('file'), $lastUserId . '_' . $randStr . '.' . $request->file('file')->extension(), 'public');
                UserPayment::create([
                    'user_id'       => $lastUserId ,
                    'amount'        => (int) $request['amount'] + (int) $request['unique_amount'],
                    'unique_amount' => (int) $request['unique_amount'],
                    'category_product' => 1,
                    'expired_at'  => date('Y-m-d H:i:s', strtotime('+'.(int)$request['bulan'].' month')),
                    'product'       => 'Kampus Bisnis Syariah', 
                    'status'        => 0,
                    'payment_type'  => 'manual',
                    'monthly'       => $request['bulan'],
                    'file'          => $file,
                    'detail_payment' => json_encode([
                        'payment_type'  => 'manual',
                        'file'          => $file
                    ])
                ]);
            }else{
                return back()->with('error', __t('Anda Belum Melampirkan Bukti Pembayaran'))->withInput($request->input());
            }
            

            if ($user) {
                $credential = [
                    'email'     => $request->email,
                    'password'     => $request->password,
                    'user_type' => 'student'
                ];

                if (Auth::attempt($credential)) {
                    return redirect(route('payment_waiting'));
                }
            }

        }
        else if ($request->user_as == 'student') {
            $followUp = FollowUp::where('title', 'W1')->first();

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => env('WOONOTIF_URL_API') . '/api/send.php?type=text&message=' . urlencode(str_replace(['{{name}}'], [$request->name], $followUp->text)) . '&number=' . change_phone_format($request->phone, $request->kode_negara) . '&instance_id=' . env('WOONOTIF_INSTANCE_ID') . '&access_token=' . env('WOONOTIF_ACCESS_TOKEN'),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
            ));

            curl_exec($curl);
            curl_close($curl);

            $komisi = 0;
            if ($request->session()->get('reff')) {
                $userReff = User::where('afiliasi_code', $request->session()->get('reff'))
                    ->where('active_status', 1)->first();
                $optionKomisi = Option::where('option_key', 'komisi_kelas')->first();
                $komisi += $optionKomisi->option_value;
            }
            if($request->file != null){
                $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'user_type' => $request->user_as,
                'phone' => change_phone_format($request->phone, $request->kode_negara),
                'category_product' => 1,
                'expired_package_at' => date('Y-m-d H:i:s', strtotime('-1 day', time())),
                'product' => 'Kampus Bisnis Syariah', 
                'active_status' => 0,
                'afiliasi_id' => (isset($userReff)) ? $userReff->id : null,
                'afiliasi_komisi' => $komisi,
                'last_payment' => date('Y-m-d H:i:s',strtotime('now'))
                ]);
                $lastUserId = User::max('id');

                $randStr = substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', 5)), 0, 5);
                $file = current_disk()->putFileAs('public/uploads/payments', $request->file('file'), $lastUserId  . '_' . $randStr . '.' . $request->file('file')->extension(), 'public');
                UserPayment::create([
                    'user_id'       => $lastUserId ,
                    'amount'        => (int) $request['amount'] + (int) $request['unique_amount'],
                    'unique_amount' => (int) $request['unique_amount'],
                    'category_product' => 1,
                    'expired_at'  => date('Y-m-d H:i:s', strtotime('+'.(int)$request['bulan'].' month')),
                    'product'       => 'Kampus Bisnis Syariah', 
                    'status'        => 0,
                    'payment_type'  => 'manual',
                    'monthly'       => $request['bulan'],
                    'file'          => $file,
                    'detail_payment' => json_encode([
                        'payment_type'  => 'manual',
                        'file'          => $file
                    ])
                ]);
            }else{
                return back()->with('error', __t('Anda Belum Melampirkan Bukti Pembayaran'))->withInput($request->input());
            }
            

            if ($user) {
                $credential = [
                    'email'     => $request->email,
                    'password'     => $request->password,
                    'user_type' => 'student'
                ];

                if (Auth::attempt($credential)) {
                    return redirect(route('payment_waiting'));
                }
            }
        } else if ($request->user_as == 'afiliasi') {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'user_type' => $request->user_as,
                'phone' => change_phone_format($request->phone, $request->kode_negara),
                'active_status' => 0,
                'afiliasi_code' => substr(str_shuffle(str_repeat($x='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(7/strlen($x)) )),1,7),
                'afiliasi_unpaid' => 0,
                'afiliasi_paid' => 0,
                'afiliasi_bank_code' => $request->kode_rekening,
                'afiliasi_bank_account' => $request->no_rekening,
            ]);

            if ($user) {
                $credential = [
                    'email'     => $request->email,
                    'password'     => $request->password,
                    'user_type' => 'afiliasi'
                ];

                if (Auth::attempt($credential)) {
                    return redirect(route('afiliasi'));
                }
            }
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
        $title = "Pembayaran Detail";

        return view('extend.payment_detail', compact('title'));
    }

    public function paymentDetailPost(Request $request)
    {
        $instances = BlastingSettings::where('id',1)->first();
        $receiver = BlastingSettings::where('id',3)->first();

        $user_name = Auth::user()->name;
        $user_email = Auth::user()->email; 
        $user_phone = Auth::user()->phone;
        $user_id = Auth::user()->id;
        $sendings = TextSettings::where('id',6)->first();
            $textSend = urlencode(str_replace(['{name}','{phone}','{email}'], [$user_name, $user_email, $user_phone],$sendings->text));
            $textSend2 = urlencode($request->text_blast2);
            $textSend3 = urlencode($request->text_blast3);

            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, 'https://x3.woonotif.com/api/send.php?type=text&message='.$textSend.'&number='.$receiver->nomor.'&instance_id='.$instances->instance_id.'&access_token=648a82c5d656c');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);

            $result = curl_exec($curl);
            if (curl_errno($curl)) {
                echo 'Error:' . curl_error($curl);
            }
            curl_close($curl);
        $rules = [
            'file'          => 'required',
            'amount'        => 'required',
            'unique_amount' => 'required',
        ];
        $this->validate($request, $rules);

        $randStr = substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', 5)), 0, 5);
        $file = current_disk()->putFileAs('public/uploads/payments', $request->file('file'), Auth::user()->id . '_' . $randStr . '.' . $request->file('file')->extension(), 'public');

        UserPayment::create([
            'user_id'       => Auth::user()->id,
            'amount'        => (int) $request['amount'] + (int) $request['unique_amount'],
            'unique_amount' => (int) $request['unique_amount'],
            'category_product' => 1,
            'expired_at'  => date('Y-m-d H:i:s', strtotime('+'.(int)$request['bulan'].' month')),
            'product'       => 'Kampus Bisnis Syariah', 
            'status'        => 0,
            'payment_type'  => 'manual',
            'monthly'       => $request['bulan'],
            'file'          => $file,
            'detail_payment' => json_encode([
                'payment_type'  => 'manual',
                'file'          => $file
            ])
        ]);

        User::where('id', $user_id)->update([
            'last_payment' => date('Y-m-d H:i:s',strtotime('now'))
        ]);

        return redirect(route('payment_waiting'));
    }

    public function paymentWaiting()
    {
        $title = "Menunggu Pembayaran";

        return view('extend.payment_waiting', compact('title'));
    }

    public function sendResetToken(Request $request)
    {
        $this->validate($request, ['phone' => 'required']);

        $checkUser = User::where('phone', change_phone_format($request->phone, $request->kode_negara))->first();

        $phone = $checkUser->phone;

        $user = User::wherePhone($phone)->first();
        if (!$user) {
            return back()->with('error', __t('Nomor Whatsapp Tidak Terdaftar'));
        }

        $user->reset_token = 'password_reset';
        $user->save();

        try {

            $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, env('WOONOTIF_URL_API') . '/api/send.php?number='.$phone.'&type&message=Anda+telah+mengajukan+permintaan+untuk+mengatur+ulang+sandi+anda+di+Fiqeeh.com.+Silahkan+setel+ulang+sandi+Anda+di+'.route('reset_password_link', $user->reset_token).'&instance_id=686097D3F05E1&access_token=648a82c5d656c');
                curl_setopt($curl, CURLOPT_URL, 'https://x3.woonotif.com/api/send.php?type=text&message=Anda+telah+mengajukan+permintaan+untuk+mengatur+ulang+sandi+anda+di+Fiqeeh.com.+Silahkan+setel+ulang+sandi+Anda+di+'.route('reset_password_link', $user->reset_token).'&number='.$phone.'&instance_id=686097D3F05E1&access_token=648a82c5d656c');
                // /send.php?number=.$value->phone.&type=media&message=.$textSend.&media_url=.$request->link_img.&filename=file_test.png&instance_id=.$request->text_acces.&access_token=. env('WOONOTIF_ACCESS_TOKEN')
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($curl, CURLOPT_TIMEOUT, 10);

                $result = curl_exec($curl);
                if (curl_errno($curl)) {
                    echo 'Error:' . curl_error($curl);
                }
                curl_close($curl);
            // Mail::to($email)->send(new SendPasswordResetLink($user));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect(route('login'))->with('success', 'Silahkan periksa Whatsapp anda, untuk melakukan reset password.');
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
