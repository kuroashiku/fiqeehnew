<?php

namespace App\Http\Controllers;

use App\EbookDownload;
use App\AfiliasiPayment;
use App\Course;
use App\Ebook;
use App\FollowUp;
use App\Option;
use App\Payment;
use App\Province;
use App\SurveyAnswer;
use App\User;
use App\UserPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class AfiliasiController extends Controller
{
    public function index()
    {
        $title = __t('dashboard');

        $user = Auth::user();

        return view(theme('afiliasi.dashboard'), compact('title'));
    }

    public function payment(Request $request)
    {
        $title = 'Payments';
        $afiliasi_payments = AfiliasiPayment::where('user_afiliasi_id', Auth::user()->id)->paginate(20);
        $optionMinimumPayment = Option::where('option_key', 'minimal_pengajuan_afiliasi')->first();
        return view(theme('afiliasi.payment'), compact('title', 'afiliasi_payments', 'optionMinimumPayment'));
    }

    public function paymentPost(Request $request)
    {
        $optionMinimumPayment = Option::where('option_key', 'minimal_pengajuan_afiliasi')->first();
        if ($request->amount < $optionMinimumPayment->option_value) {
            return redirect()->back()->with('error', "Minimal Pengajuan Pembayaran Afiliasi Rp.".number_format($optionMinimumPayment->option_value, 0, ',', '.'));
        }

        $afiliasi_payments = AfiliasiPayment::where('user_afiliasi_id', Auth::user()->id)->where('status', 0)->first();
        if ($afiliasi_payments) {
            return redirect()->back()->with('error', "Anda Sudah Mengajukan Pembayaran, Silahkan Tunggu Konfirmasi Admin!");
        }

        AfiliasiPayment::create([
            'user_afiliasi_id' => Auth::user()->id,
            'amount' => $request->amount,
            'status' => 0,
            'is_delete' => 0,
        ]);

        return redirect()->back()->with('success', "Payment Request Success!");
    }

    public function blasting(Request $request)
    {
        dd($request->all());
        $textSend = urlencode($request->text_blast);

        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, 'https://x3.woonotif.com/api/send.php?type=text&message='.$textSend.'%0A%0A'.$textSend2.'%0A%0A'.$textSend3.'&number='.$request->text_phone.'&instance_id='.$request->text_instance.'&access_token=648a82c5d656c');
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);

        $result = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Error:' . curl_error($curl);
        }
        curl_close($curl);

        return response()->json(['success' => 'Blasting Telah Berhasil Di Kirim!']);
    }

    public function books(Request $request)
    {
        $title = 'Books';
        $afiliasi_books = EbookDownload::with('ebook')->where('user_afiliasi_id', Auth::user()->id)->paginate(20);
        $books = Ebook::where('free', 0)->get();
        return view('afiliasi.index-buku', compact('title', 'afiliasi_books', 'books'));
    }

    public function bookList(Request $request)
    {
        $title = 'Books';
        $ebooks = Ebook::where('free', 0)->orderBy('id', 'desc')->paginate(20);
        return view('afiliasi.list-buku', compact('title', 'ebooks'));
    }

    public function bookPost(Request $request)
    {
        $book = Ebook::find($request->ebook_id);

        $file = $request->file('payment_photo');
        $image = $file;
        $upload_dir = 'public/uploads/images/';

        $getFilename = $file->getClientOriginalName();
        $ext = '.' . $file->getClientOriginalExtension();
        $baseSlug = str_replace($ext, '', $getFilename);

        $slug = strtolower($baseSlug);
        $slug = unique_slug($slug, 'Media');
        $slug_ext = $slug . $ext;

        current_disk()->putFileAs('public/uploads/images/', $file, $slug_ext, 'public');

        $payment = EbookDownload::create([
            'ebook_id' => $request->ebook_id,
            'user_afiliasi_id' => Auth::user()->id,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'payment_detail' => 'public/uploads/images/'.$slug_ext,
            'payment_status' => 1,
            'afiliasi_komisi' => $book->afiliasi_komisi,
        ]);

        if ($payment) {
            return redirect()->back()->with('success', "Afiliasi Book Pyament Success!");
        }
        return redirect()->back()->with('error', "Failed add Afiliasi Book Pyament!");
    }
}
