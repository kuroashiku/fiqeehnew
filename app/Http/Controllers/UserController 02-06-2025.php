<?php

namespace App\Http\Controllers;

use App\FollowUp;
use App\BlastingSettings;
use App\Course;
use App\Option;
use Excel;
use App\Imports\UsersImport;
use App\Imports\UsersUpdate;
use App\Review;
use App\User;
use App\UserPayment;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DateTime;
use App\Province;
use App\PaymentAds;
use App\TextSettings;

class UserController extends Controller
{
    public function profile($id) 
    {
        $user =  User::find($id);
        if (!$user) {
            abort(404);
        }

        $title = $user->name;
        return view(theme('profile'), compact('user', 'title'));
    }

    public function review($id)
    {
        $review = Review::find($id);
        $title = 'Review by ' . $review->user->name;

        return view(theme('review'), compact('review', 'title'));
    }

    public function updateWishlist(Request $request)
    {
        $course_id = $request->course_id;

        $user = Auth::user();
        if (!$user->wishlist->contains($course_id)) {
            $user->wishlist()->attach($course_id);
            $response = ['success' => 1, 'state' => 'added'];
        } else {
            $user->wishlist()->detach($course_id);
            $response = ['success' => 1, 'state' => 'removed'];
        }

        $addedWishList = DB::table('wishlists')->where('user_id', $user->id)->pluck('course_id');

        $user->update_option('wishlists', $addedWishList);

        return $response;
    }



    public function changePassword()
    {
        $title = __a('change_password');
        if (Auth::user()->user_type == 'afiliasi') {
            return view('admin.afiliasi.change_password', compact('title'));
        } else {
            return view('admin.change_password', compact('title'));
        }
    }

    public function changePasswordPost(Request $request)
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

        $old_password = $request->old_password;
        $new_password = $request->new_password;

        if (Auth::check()) {
            $logged_user = Auth::user();

            if (Hash::check($old_password, $logged_user->password)) {
                $logged_user->password = Hash::make($new_password);
                $logged_user->save();
                return redirect()->back()->with('success', __a('password_changed_msg'));
            }
            return redirect()->back()->with('error', __a('wrong_old_password'));
        }
    }

        public function store(Request $request)
    {
        $post = $request->except("_token");
        $instance = BlastingSettings::where('id',1)->first();
        $waktu2 = date('d/m/Y', strtotime('+'.(int)$request->expired.' month'));
        $waktu = date('d/m/Y', strtotime('now'));
        $waktu3 = date('d-m-Y',strtotime($waktu2));
        // $links = Province::where('provinsi', $request->city)->get();
        $nomoruser= substr($request->phone,2,18);
        // $link_wa = $links->link;
        // foreach($links as $u){
            // $linkss = $u->link;
            if($request->expired != 0){
            $textSend = urlencode(str_replace(['{name}', '{product}','{product_ads}','{phone}','{city}','{now}','{expired}'], [$request->name, $request->product,$request->product_ads,$nomoruser,$request->city,$waktu,$waktu2], $request->text_blast));
            $textSend2 = urlencode($request->text_blast2);
            $textSend3 = urlencode($request->text_blast3);

            $curl = curl_init(); 

            curl_setopt($curl, CURLOPT_URL, 'https://x3.woonotif.com/api/send.php?type=text&message='.$textSend.'&number='.$request->phone.'&instance_id='.$request->text_instance.'&access_token=648a82c5d656c');
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_TIMEOUT, 10);

            $result = curl_exec($curl);
            if (curl_errno($curl)) {
                echo 'Error:' . curl_error($curl);
            }
            curl_close($curl);
            }else{
                
            }

        // }
        

        switch ($post['type']) {
            case 'bulk':

                DB::beginTransaction();

                try {
                    $imported = new UsersUpdate;
                    Excel::import($imported, $request['file']);
                    DB::commit();

                    return back()->with('success', __a('success') . ' Data yang di input baru ' . $imported->data);
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect()->back()->with('error', $e->getMessage());
                }
            default:
                $userPost = $request->except("_token", "amount", "expired", "type","text_blast","text_instance");

                $post['password'] = Hash::make($post['password']);
                $post['active_status'] = 1;


                DB::beginTransaction();
                if(User::select('*')->where('phone','!=',$post['phone'])){

                    try {
                        $userPost['password'] = Hash::make($userPost['password']);
                        $userPost['expired_package_at'] = date('Y-m-d H:i:s', strtotime('+'.(int)$post['expired'].' month'));
    
                        $user = User::create($userPost);
                        UserPayment::create([
                            'user_id' => $user->id,
                            'amount' => $post['amount'],
                            'monthly' => $post['expired'],
                            'product' => $post['product'],
                            'product_ads' => $post['product_ads'],
                            'category_product' => $post['category_product'],
                            'expired_at' => date('Y-m-d H:i:s', strtotime('+'.(int)$post['expired'].' month')), 
                            'started_at' => date('Y-m-d H:i:s'),
                            'unique_amount' => 0,
                            'status' => 1
                        ]);
                        DB::commit();
                        return back()->with('success', __a('success'));
                    } catch (\Exception $e) {
                        DB::rollback();
                        return redirect()->back()->with('error', $e->getMessage());
                    }
                    break;
                    
                }else{
                    return redirect()->back()->with('error', $e->getMessage());
                }
                try {
                    $userPost['password'] = Hash::make($userPost['password']);
                    $userPost['expired_package_at'] = date('Y-m-d H:i:s', strtotime('+'.(int)$post['expired'].' month'));

                    $user = User::create($userPost);
                    UserPayment::create([
                        'user_id' => $user->id,
                        'amount' => $post['amount'],
                        'monthly' => $post['expired'],
                        'product' => $post['product'],
                        'product_ads' => $post['product_ads'],
                        'category_product' => $post['category_product'],
                        'expired_at' => date('Y-m-d H:i:s', strtotime('+'.(int)$post['expired'].' month')), 
                        'started_at' => date('Y-m-d H:i:s'),
                        'unique_amount' => 0,
                        'status' => 1
                    ]);
                    DB::commit();
                    return back()->with('success', __a('success'));
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect()->back()->with('error', $e->getMessage());
                }
                break;
        }
    }
        public function storeads(Request $request)
    {
        $post = $request->except("_token");

        switch ($post['type']) {
            case 'bulk':

                DB::beginTransaction();

                try {
                    $imported = new UsersImport;
                    Excel::import($imported, $request['file']);
                    DB::commit();

                    return back()->with('success', __a('success') . ' Data yang di input baru ' . $imported->data);
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect()->back()->with('error', $e->getMessage());
                }
            default:
                $userPost = $request->except("_token", "amount", "expired", "type");

                $post['password'] = Hash::make($post['password']);
                $post['active_status'] = 1;


                DB::beginTransaction();

                try {
                    $userPost['password'] = Hash::make($userPost['password']);
                    $userPost['expired_package_at'] = date('Y-m-d H:i:s', strtotime('+'.(int)$post['expired'].' month'));

                    $user = User::create($userPost);
                    PaymentAds::create([
                        'user_id' => $user->id,
                        'amount' => $post['amount'],
                        'unique_amount' => 0,
                        'status' => $post['active_status'],
                        'product' => $post['product']
                    ]);
                    DB::commit();
                    return back()->with('success', __a('success'));
                } catch (\Exception $e) {
                    DB::rollback();
                    return redirect()->back()->with('error', $e->getMessage());
                }
                break;
        }
    }

    public function createPwd($password)
    {
        return Hash::make($password);
    }

    public function regenerateJatuhTempo($password)
    {
        if ($password == 'Kampus2025') {
            $listUser = User::where('user_type', 'student')->get();
            foreach ($listUser as $user) {
                $userPayment = UserPayment::where('user_id', $user->id)
                    ->where('status', 1)
                    ->where('category_product', 1)
                    ->orderBy('id')
                    ->get();
                foreach ($userPayment as $kPay => $payment) {
                    if ($kPay == 0) {
                        UserPayment::where('id', $payment->id)->update([
                            'tanggal_jatuh_tempo' => date('Y-m-d 01:01:01', strtotime($user->created_at))
                        ]);
                    } elseif (!empty($userPayment[$kPay-1]->expired_at)) {
                        UserPayment::where('id', $payment->id)->update([
                            'tanggal_jatuh_tempo' => date('Y-m-d 00:00:00', strtotime($userPayment[$kPay-1]->expired_at))
                        ]);
                    }
                }
            }
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     *
     * Update the payment status, and it's related dataa
     */

    public function users(Request $request)
    {
        $userLogin = Auth::user();

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

        if ($userLogin->user_type == 'afiliasi') {
            $users = $users->where('afiliasi_id', $userLogin->id);
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
        if ($request->filter_data == "last_payment") {
            $users = $users->where('last_payment', NULL);
        }
        if ($request->filter_data == "last_payment_pending") {
            $users = $users->where('last_payment','!=', NULL);
        }
        // if ($request->filter_data == "monthly") { 
        //     $payments = $payments->where('user_payments.monthly', NULL);
        // }
        // if ($request->filter_data == "expired") {
        //     $payments = $payments->where('user_payments.expired_at', NULL);
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
        $followUp = TextSettings::get();
        foreach ($followUp as $kf => $vf) {
            $followUp[$kf]['text'] = urldecode($vf['text']);
        }
 

        $title = "Users Data";
        $users = $users->where('is_delete', 0)->orderBy('updated_expired', 'desc')->paginate(20);
        $course = Course::where('category_id', '!=', 1205)->where('category_id', '!=', 1203)->orderBy('title','asc')->publish()->get();
        $courses = Course::where('category_id', '=', 1205)->orWhere('category_id', '=', 1203)->orderBy('title','asc')->publish()->get();
        $cours = Course::where('status', '=', '1')->orderBy('title','asc')->get();
        $product = UserPayment::select('product')->whereNotNull('product')->whereNotIn('product', ['Koreksi Expired'])->distinct()->get();
        $category = Category::where('category_id','1161')->get();
        $province = Province::get('provinsi')->whereNotNull('provinsi');

        if ($userLogin->user_type == 'afiliasi') {
            return view('admin.afiliasi.users.index', compact('title', 'users', 'course', 'courses', 'dataLeads', 'product', 'province', 'cours'));
        } else {
            return view('admin.users.index', compact('title', 'users', 'course', 'courses', 'dataLeads', 'product', 'province', 'cours','followUp'));
        }
    } 

    public function usersProgress(Request $request)
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


        $title = "Progress User";
        $users = $users->orderBy('id', 'desc')->paginate(20);
        $course = Course::publish()->get();
        $product = UserPayment::select('product')->whereNotNull('product')->whereNotIn('product', ['Koreksi Expired'])->distinct()->get();

        $province = Province::get('provinsi')->whereNotNull('provinsi');
        
        return view('admin.users.progress', compact('title', 'users', 'course', 'dataLeads', 'product', 'province'));
    }

    public function deletedUsers(Request $request)
    {
        $userLogin = Auth::user();

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

        if ($userLogin->user_type == 'afiliasi') {
            $users = $users->where('afiliasi_id', $userLogin->id);
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
        if ($request->filter_data == "last_payment") {
            $users = $users->where('last_payment', NULL);
        }
        // if ($request->filter_data == "monthly") { 
        //     $payments = $payments->where('user_payments.monthly', NULL);
        // }
        // if ($request->filter_data == "expired") {
        //     $payments = $payments->where('user_payments.expired_at', NULL);
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
        $followUp = TextSettings::get();
        foreach ($followUp as $kf => $vf) {
            $followUp[$kf]['text'] = urldecode($vf['text']);
        }
 

        $title = "Deleted Users";
        $users = $users->where('is_delete', 1)->orderBy('updated_expired', 'desc')->paginate(20);
        $course = Course::where('category_id', '!=', 1205)->where('category_id', '!=', 1203)->orderBy('title','asc')->publish()->get();
        $courses = Course::where('category_id', '=', 1205)->orWhere('category_id', '=', 1203)->orderBy('title','asc')->publish()->get();
        $cours = Course::where('status', '=', '1')->orderBy('title','asc')->get();
        $product = UserPayment::select('product')->whereNotNull('product')->whereNotIn('product', ['Koreksi Expired'])->distinct()->get();
        $category = Category::where('category_id','1161')->get();
        $province = Province::get('provinsi')->whereNotNull('provinsi');

        if ($userLogin->user_type == 'afiliasi') {
            return view('admin.afiliasi.users.index', compact('title', 'users', 'course', 'courses', 'dataLeads', 'product', 'province', 'cours'));
        } else {
            return view('admin.users.deleted_users', compact('title', 'users', 'course', 'courses', 'dataLeads', 'product', 'province', 'cours','followUp'));
        }
    } 


    public function addExpiredUser(Request $request, $id)
    {
        $post = $request->except("_token","text_blast","text_instance");

        
                // $post = $request->except("_token","text_blast","text_instance");
                $instance = BlastingSettings::where('id',1)->first();
                $waktu2 = date('d/m/Y', strtotime('+'.(int)$request->expired.' month'));
                $waktu = date('d/m/Y', strtotime('now'));
                $waktu3 = date('d-m-Y',strtotime($waktu2));
                // $links = Province::where('provinsi', $request->city)->get();
                $nomoruser= substr($request->phone,2,18);
                // $link_wa = $links->link;
                // foreach($links as $u){
                    // $linkss = $u->link;
                    if($request->expired != 0){
                    $textSend = urlencode(str_replace(['{name}', '{product}','{product_ads}','{phone}','{city}','{now}','{expired}'], [$request->username, $request->products,$request->products_ads,$nomoruser,$request->city,$waktu,$waktu2], $request->text_blast));
                    $textSend2 = urlencode($request->text_blast2);
                    $textSend3 = urlencode($request->text_blast3); 
        
                    $curl = curl_init(); 
        
                    curl_setopt($curl, CURLOPT_URL, 'https://x3.woonotif.com/api/send.php?type=text&message='.$textSend.'&number='.$request->phone.'&instance_id='.$request->text_instance.'&access_token=648a82c5d656c');
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
                    curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        
                    $result = curl_exec($curl);
                    if (curl_errno($curl)) {
                        echo 'Error:' . curl_error($curl);
                    }
                    curl_close($curl);
                    }


        UserPayment::create([
            'user_id' => $id,
            'amount' => $post['amount'],
            'monthly' => $post['expired'],
            'product' => $post['products'],
            'product_ads' => $post['products_ads'],
            'category_product' => $post['category_products'],
            'expired_at' => date('Y-m-d H:i:s', strtotime('+'.(int)$post['expired'].' month')),
            'started_at' => date('Y-m-d H:i:s'),
            'unique_amount' => 0,
            'status' => 1,
            'is_delete' => 0
        ]);

        $user = User::find($id);
        if ($user->active_status == 0) {
            $userReff = User::find($user->afiliasi_id);
            $userReff->update([
                'afiliasi_unpaid' => $user->afiliasi_unpaid + $user->afiliasi_komisi
            ]);
        }

        if (date('Y-m-d H:i:s') > $user->expired_package_at) {
            $user->update([
                'expired_package_at' => date('Y-m-d H:i:s', strtotime('+'.(int)$post['expired'].' month')),
                'afiliasi_paid' => 3,
                'active_status' => 1,
                'product' => $post['products'],
                'product_ads' => $post['products_ads'],
                'category_product' => $post['category_products'],
                'updated_expired' => date('Y-m-d H:i:s',strtotime('now')),
                'last_payment' => date('Y-m-d H:i:s',strtotime('now'))
            ]);
        } else {
            $user->update([
                'expired_package_at' => date('Y-m-d H:i:s', strtotime($user->expired_package_at.'+'.(int)$post['expired'].' month')),
                'afiliasi_paid' => 3,
                'active_status' => 1,
                'product' => $post['products'],
                'product_ads' => $post['products_ads'],
                'category_product' => $post['category_products'],
                'updated_expired' => date('Y-m-d H:i:s',strtotime('now')),
                'last_payment' => date('Y-m-d H:i:s',strtotime('now'))
            ]);
        }

            
        // if ($user) {
        //     return redirect()->back()->with('success', "User expired updated!");
        // }

        // return redirect()->back()->with('error', "Failed update user expired!");

            

        return redirect()->back()->with('success', 'Blasting Telah Berhasil Di Kirim & User Expired Updated!');

    }

    public function addAdsUser(Request $request, $id)
    {
        $post = $request->except("_token");

        PaymentAds::create([
            'user_id' => $id,
            'amount' => $post['amount'],
            'monthly' => $post['expired'],
            'product' => $post['product'],
            'expired_at' => date('Y-m-d H:i:s', strtotime('+'.(int)$post['expired'].' month')),
            'started_at' => date('Y-m-d H:i:s'),
            'unique_amount' => 0,
            'status' => 1
        ]);

        $user = User::find($id);
        if (date('Y-m-d H:i:s') > $user->expired_ads_at) {
            $user->update([
                'expired_ads_at' => date('Y-m-d H:i:s', strtotime('+'.(int)$post['expired'].' month')),
                'afiliasi_paid' => 3
            ]);
        } else {
            $user->update([
                'expired_ads_at' => date('Y-m-d H:i:s', strtotime($user->expired_ads_at.'+'.(int)$post['expired'].' month')),
                'afiliasi_paid' => 3
            ]);
        }

        if ($user) {
            return redirect()->back()->with('success', "User Ads updated!");
        }
        return redirect()->back()->with('error', "Failed update user Ads!");
    }
 
    public function editUser(Request $request, $id)
    {
        $post = $request->except("_token");

        DB::beginTransaction();
        try {
            $user = User::find($id);

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
                // $textSend2 = urlencode($request->text_blast2);
                // $textSend3 = urlencode($request->text_blast3);

                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, 'https://x3.woonotif.com/api/send.php?type=text&message='.$textSend.'&number='.$request->text_phone.'&instance_id='.$request->text_instance.'&access_token=648a82c5d656c');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($curl, CURLOPT_TIMEOUT, 10);

                $result = curl_exec($curl);
                if (curl_errno($curl)) {
                    echo 'Error:' . curl_error($curl);
                }
                curl_close($curl);

        return redirect()->back()->with('success', 'Blasting Telah Berhasil Di Kirim!');
    }
    public function getProduct()
    {
        $produk = Course::where('category_id', '!=' , '1203')->get();
        return response()->json($produk);
    }
    public function textBlasting(Request $request)
    {
        $post = $request->except("_token");

        foreach ($post as $key => $value) {
            TextSettings::where('id', $key)->update([
                'text' => $value['text'],
            ]);
        }
        return back()->with('success', __a('success'));
    }

    public function delete($id)
    {
        if (config('app.is_demo')) return back()->with('error', __a('demo_restriction'));

        $payment = User::find($id);
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

    public function categorySelect(){
        $data = Category::where('category_name','LIKE','%'.request('q').'%')->paginate(20);

        return response()->json($data);
    }

    public function selectProduct($id){
        $data = Course::where('category_id', $id)->where('category_name','LIKE','%'.request('q').'%')->paginate(20);

        return response()->json($data);
    }
    
    public function dropdown(Request $request){
        $provinsi = Category::findOrFail($request->id);
        $kotaFiltered = $provinsi->product->pluck('category_id', 'title');
        return response()->json($kotaFiltered);
    }
}
 