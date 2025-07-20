<?php

namespace App\Http\Controllers;

use App\EbookDownload;
use App\AfiliasiPayment;
use App\Ebook;
use App\FollowUp;
use App\Option;
use App\Payment;
use App\User;
use App\UserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAfiliasiController extends Controller
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

        $title = "Afiliasi";

        $afiliasi = User::where('user_type', 'afiliasi');

        if ($request->status != "") {
            $afiliasi = $afiliasi->where('status', $request->status);
        }
        if ($request->start_date != "") {
            $afiliasi = $afiliasi->where('created_at', '>=', $request->start_date);
        }
        if ($request->end_date != "") {
            $afiliasi = $afiliasi->where('created_at', '<=', $request->end_date);
        }
        $afiliasi = $afiliasi->orderBy('id', 'desc')->paginate(20);

        $komisiKelas = Option::where('option_key', 'komisi_kelas')->first();
        $komisiBuku = Option::where('option_key', 'komisi_buku')->first();
        $minimalPengajuanAfiliasi = Option::where('option_key', 'minimal_pengajuan_afiliasi')->first();
        $peraturanAfiliasi = Option::where('option_key', 'peraturan_afiliasi')->first();

        return view('admin.afiliasi.index', compact('title', 'afiliasi', 'komisiKelas', 'komisiBuku', 'minimalPengajuanAfiliasi', 'peraturanAfiliasi'));
    }

    public function bukuList(Request $request)
    {
        $title = 'Books';
        $afiliasi_books = EbookDownload::with('ebook')->whereNotNull('user_afiliasi_id')->paginate(20);
        $books = Ebook::where('free', 0)->get();
        return view('admin.afiliasi.list-buku', compact('title', 'afiliasi_books', 'books'));
    }

    public function bukuUpdateStatus(Request $request, $id)
    {
        $book = EbookDownload::find($id);

        $book->update([
            'status' => $request->status,
            'no_resi' => $request->no_resi
        ]);
        if ($request->status == 3) {
            $user = User::find($book->user_afiliasi_id);
            $user->update([
                'afiliasi_unpaid' => $user->afiliasi_unpaid + $book->afiliasi_komisi
            ]);
        }
        return redirect()->back()->with('success', 'Afiliasi Book Status Updated!');
    }

    public function indexPayment(Request $request)
    {
        $title = 'Afiliasi Payment';
        $payments = AfiliasiPayment::orderBy('id', 'desc')->paginate(20);
        return view('admin.afiliasi.index-payment', compact('title', 'payments'));
    }

    public function indexPaymentPost(Request $request)
    {
        if ($request->status == 1) {
            $file = $request->file('detail_payment');
            $image = $file;
            $upload_dir = 'public/uploads/images/';

            $getFilename = $file->getClientOriginalName();
            $ext = '.' . $file->getClientOriginalExtension();
            $baseSlug = str_replace($ext, '', $getFilename);

            $slug = strtolower($baseSlug);
            $slug = unique_slug($slug, 'Media');
            $slug_ext = $slug . $ext;

            current_disk()->putFileAs('public/uploads/images/', $file, $slug_ext, 'public');

            $userAfiliasi = User::find($request->user_id);
            $userAfiliasiPayment = AfiliasiPayment::find($request->id);

            $userAfiliasi->update([
                'afiliasi_unpaid' => $userAfiliasi->afiliasi_unpaid - $userAfiliasiPayment->amount,
                'afiliasi_paid' => $userAfiliasi->afiliasi_paid + $userAfiliasiPayment->amount
            ]);

            $payments = AfiliasiPayment::find($request->id)->update([
                'status' => $request->status,
                'detail_payment' => 'public/uploads/images/'.$slug_ext,
            ]);
        } else {
            $payments = AfiliasiPayment::find($request->id)->update([
                'status' => $request->status,
                'detail_payment' => $request->detail_payment_reason
            ]);
        }

        return redirect()->back()->with('success', 'Afiliasi Payment Status Updated!');
    }

    public function indexBuku(Request $request)
    {
        $title = 'Afiliasi Buku';
        $ebooks = Ebook::where('free', 0)->orderBy('id', 'desc')->paginate(20);
        return view('admin.afiliasi.index-buku', compact('title', 'ebooks'));
    }

    public function createBuku(Request $request)
    {
        $title = 'Create Afiliasi Buku';
        return view('admin.afiliasi.create-buku', compact('title'));
    }

    public function storeBuku(Request $request)
    {
        $rules = [
            'title' => 'required|max:220',
            'image' => 'required',
            'price' => 'required',
            'afiliasi_komisi' => 'required'
        ];
        $this->validate($request, $rules);

        // random string generator for unique code
        $slug = unique_slug($request->title, 'Ebook');
        $data = [
            'title'         => clean_html($request->title),
            'slug'          => clean_html($slug),
            'description'   => clean_html($request->description),
            'image'         => $request->image,
            'price'         => $request->price,
            'afiliasi_komisi' => $request->afiliasi_komisi,
            'status'        => 1,
            'free'          => ($request->price == 0) ? 1 : 0
        ];

        Ebook::create($data);
        return redirect(route('admin_afiliasi_buku'))->with('success', 'Afiliasi buku has been created');
    }

    public function editBuku($id)
    {
        $title = "Edit Afiliasi Buku";
        $ebook = Ebook::find($id);
        return view('admin.afiliasi.edit-buku', compact('title', 'ebook'));
    }

    public function updateBuku(Request $request, $id)
    {
        $rules = [
            'title' => 'required|max:220',
            'image' => 'required',
            'price' => 'required',
            'afiliasi_komisi' => 'required'
        ];
        $this->validate($request, $rules);
        $page = Ebook::find($id);

        $slug = unique_slug($request->title, 'Ebook');
        $data = [
            'title'         => clean_html($request->title),
            'slug'          => clean_html($slug),
            'description'   => clean_html($request->description),
            'image'         => $request->image,
            'afiliasi_komisi' => $request->afiliasi_komisi,
        ];

        $page->update($data);
        return redirect()->back()->with('success', __a('page_has_been_updated'));
    }

    public function deleteBuku($id)
    {
        Ebook::find($id)->delete();
        return redirect(route('admin_afiliasi_buku'))->with('success', 'Afiliasi buku has been deleted');
    }

    public function addExpiredAfiliasi(Request $request, $id)
    {
        $post = $request->except("_token");

        $user = User::find($id);
        $user->update([
            'expired_package_at' => date('Y-m-d H:i:s', strtotime($user->expired_package_at.'+'.(int)$post['expired'].' month')),
            'active_status' => 1
        ]);

        if ($user) {
            return redirect()->back()->with('success', "Afiliasi expired updated!");
        }
        return redirect()->back()->with('error', "Failed update afiliasi expired!");
    }

    public function send(Request $request)
    {
        $textSend = urlencode($request->text_blast);

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

    public function view($id)
    {
        $title = "Afiliasi Detail";
        $afiliasi = User::find($id);
        return view('admin.afiliasi.view', compact('title', 'afiliasi'));
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
            User::find($id)->update([
                'active_status' => $request->status
            ]);
        }

        return back()->with('success', __a('success'));
    }

    public function updateOptions(Request $request)
    {
        // laravel create or update option

        try {
            Option::updateOrCreate(
                ['option_key' => 'komisi_kelas'],
                ['option_value' => $request->komisi_kelas]
            );
            Option::updateOrCreate(
                ['option_key' => 'komisi_buku'],
                ['option_value' => $request->komisi_buku]
            );
            Option::updateOrCreate(
                ['option_key' => 'minimal_pengajuan_afiliasi'],
                ['option_value' => $request->minimal_pengajuan_afiliasi]
            );
            Option::updateOrCreate(
                ['option_key' => 'peraturan_afiliasi'],
                ['option_value' => $request->peraturan_afiliasi]
            );

            return back()->with('success', __a('success'));
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
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
