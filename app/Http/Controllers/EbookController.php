<?php

namespace App\Http\Controllers;

use App\Ebook;
use App\EbookDownload;
use App\Post;
use App\TextSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class EbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if ($request->bulk_action_btn === 'update_status') {
        //     Ebook::query()->whereIn('id', $request->bulk_ids)->update(['status' => $request->status]);
        //     return back()->with('success', __a('bulk_action_success'));
        // }
        // if ($request->bulk_action_btn === 'delete') {
        //     if (config('app.is_demo')) return back()->with('error', __a('demo_restriction'));

        //     Ebook::query()->whereIn('id', $request->bulk_ids)->delete();
        //     return back()->with('success', __a('bulk_action_success'));
        // }

        $title = 'Ebook';
        $ebooks = Ebook::orderBy('id', 'desc')->paginate(10);
        return view('admin.cms.ebooks', compact('title', 'ebooks'));
    }

    public function posts(Request $request)
    {
        if ($request->bulk_action_btn === 'update_status') {
            Post::query()->whereIn('id', $request->bulk_ids)->update(['status' => $request->status]);
            return back()->with('success', __a('bulk_action_success'));
        }
        if ($request->bulk_action_btn === 'delete') {
            if (config('app.is_demo')) return back()->with('error', __a('demo_restriction'));

            Post::query()->whereIn('id', $request->bulk_ids)->delete();
            return back()->with('success', __a('bulk_action_success'));
        }

        $title = __a('posts');
        $posts = Post::whereType('post')->orderBy('id', 'desc')->paginate(20);

        return view('admin.cms.posts', compact('title', 'posts'));
    }

    public function createPost()
    {
        $title = __a('create_new_post');

        return view('admin.cms.post_create', compact('title'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function storePost(Request $request)
    {
        if (config('app.is_demo')) return back()->with('error', __a('app.feature_disable_demo'));

        $user = Auth::user();
        $rules = [
            'title'     => 'required|max:220',
            'post_content'   => 'required',
        ];
        $this->validate($request, $rules);

        $slug = unique_slug($request->title, 'Post');
        $data = [
            'user_id'               => $user->id,
            'title'                 => clean_html($request->title),
            'slug'                  => $slug,
            'post_content'          => clean_html($request->post_content),
            'type'                  => 'post',
            'status'                => '1',
            'feature_image'         => $request->feature_image,
        ];

        Post::create($data);
        return redirect(route('posts'))->with('success', __a('post_has_been_created'));
    }


    public function editPost($id)
    {
        $title = __a('edit_post');
        $post = Post::find($id);

        return view('admin.cms.edit_post', compact('title', 'post'));
    }

    public function updatePost(Request $request, $id)
    {
        if (config('app.is_demo')) return back()->with('error', __a('app.feature_disable_demo'));

        $rules = [
            'title'     => 'required|max:220',
            'post_content'   => 'required',
        ];
        $this->validate($request, $rules);
        $page = Post::find($id);

        $data = [
            'title'                 => clean_html($request->title),
            'post_content'          => clean_html($request->post_content),
            'feature_image'         => $request->feature_image,
        ];

        $page->update($data);
        return redirect()->back()->with('success', __a('post_has_been_updated'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = __a('pages');
        return view('admin.cms.ebook_create', compact('title'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if ($request->physic == 1) {
            $rules = [
                'title' => 'required|max:220',
                'image' => 'required',
                'price' => 'required'
            ];
        } else {
            $rules = [
                'title' => 'required|max:220',
                'image' => 'required',
                'price' => 'required',
                'file'  => 'required'
            ];
        }
        $this->validate($request, $rules);

        $file = '';
        if ($request->file('file')) {
            $rules = [
                'file' => 'required|max:32000',
            ];
            $this->validate($request, $rules);

            $randStr = substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', 5)), 0, 5);
            $file = current_disk()->putFileAs('public/uploads/ebooks', $request->file('file'), str_replace(' ', '_', strtolower($request->title)) . '_' . $randStr . '.pdf', 'public');
        }

        $slug = unique_slug($request->title, 'Ebook');
        $data = [
            'title'             => clean_html($request->title),
            'slug'              => clean_html($slug),
            'description'       => clean_html($request->description),
            'file'              => $file,
            'image'             => $request->image,
            'price'             => $request->price,
            'author'            => (empty($request->author)) ? "Fiqeeh" : clean_html($request->author),
            'status'            => 1,
            'free'              => ($request->price == 0) ? 1 : 0,
            'physic'            => $request->physic,
            'afiliasi_komisi'   => $request->afiliasi_komisi
        ];

        Ebook::create($data);
        return redirect(route('ebooks'))->with('success', 'Ebooks has been created');
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $title = "Edit Ebook";
        $ebook = Ebook::find($id);
        return view('admin.cms.edit_ebook', compact('title', 'ebook'));
    }

    public function update($id, Request $request)
    {
        $title = "Edit Ebook";

        $rules = [
            'title' => 'required|max:220',
            'image' => 'required',
            'price' => 'required'
        ];
        $this->validate($request, $rules);

        if ($request->file('file')) {
            $rules = [
                'file' => 'required|max:32000',
            ];
            $this->validate($request, $rules);

            $randStr = substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', 5)), 0, 5);
            $file = current_disk()->putFileAs('public/uploads/ebooks', $request->file('file'), str_replace(' ', '_', strtolower($request->title)) . '_' . $randStr . '.pdf', 'public');
            $data = [
                'file' => $file
            ];
            $ebook = Ebook::find($id);
            $ebook->update($data);
        }

        $data = [
            'title'             => clean_html($request->title),
            'description'       => clean_html($request->description),
            'image'             => $request->image,
            'price'             => $request->price,
            'author'            => (empty($request->author)) ? "Fiqeeh" : clean_html($request->author),
            'free'              => ($request->price == 0) ? 1 : 0,
            'physic'            => $request->physic,
            'afiliasi_komisi'   => $request->afiliasi_komisi
        ];
        $ebook = Ebook::find($id);
        $ebook->update($data);

        return view('admin.cms.edit_ebook', compact('title', 'ebook'));
    }

    public function updatePage(Request $request, $id)
    {
        if (config('app.is_demo')) return back()->with('error', __a('app.feature_disable_demo'));

        $rules = [
            'title' => 'required|max:220',
            'image' => 'required',
            'price' => 'required',
        ];
        $this->validate($request, $rules);
        $page = Ebook::find($id);

        $slug = unique_slug($request->title, 'Ebook');
        $data = [
            'title'         => clean_html($request->title),
            'slug'          => clean_html($slug),
            'description'   => clean_html($request->description),
            'author'        => clean_html($request->author),
        ];

        $page->update($data);
        return redirect()->back()->with('success', __a('page_has_been_updated'));
    }

    public function showPage($slug)
    {
        $ebook = Ebook::where('slug', $slug)->first();

        if (!$ebook) {
            return view('theme.error_404');
        }
        $title = $ebook->title;
        return view('theme.show_ebook', compact('title', 'ebook'));
    }

    public function downloadEbook(Request $request, $slug)
    {
        $ebook = Ebook::where('slug', $slug)->first();

        if (!$ebook) {
            return view('theme.error_404');
        }

        if ($ebook->free == 1) {
            $textEbook = TextSettings::with('instance')->where('title', 'User download ebook gratis')->first();
            if ($textEbook && !empty($textEbook->instance)) {
                $sendText = str_replace(['{nama}', '{url_ebook}'], [$request->name, url('/').'/public/'.$ebook->file], $textEbook->text);

                $curl = curl_init();

                curl_setopt($curl, CURLOPT_URL, 'https://x3.woonotif.com/api/send.php?type=text&message='.
                    urlencode($sendText).'&number='.$request->kode_negara.$request->phone.'&instance_id='.$textEbook->instance->instance_id.
                    '&access_token=648a82c5d656c');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($curl, CURLOPT_TIMEOUT, 10);

                $result = curl_exec($curl);
                if (curl_errno($curl)) {
                    echo 'Error:' . curl_error($curl);
                }
                curl_close($curl);
            }
            EbookDownload::updateOrCreate([
                'ebook_id'  => $ebook->id,
                'email'     => $request->email,
                'no_hp'     => $request->phone,
            ], [
                'ebook_id'  => $ebook->id,
                'nama'      => $request->name,
                'email'     => $request->email,
                'no_hp'     => $request->phone,
                'pekerjaan' => $request->pekerjaan,
                'kota'      => $request->kota
            ]);

            $title = "Berhasil Download Ebook";

            return view('extend.download_ebook', compact('title'));
        } elseif ($ebook->price > 0) {
            $data = [
                'ebook_id'  => $ebook->id,
                'nama'      => $request->name,
                'email'     => $request->email,
                'no_hp'     => $request->phone,
                'pekerjaan' => $request->pekerjaan,
                'kota'      => $request->kota
            ];

            if ($ebook->physic == 1) {
                $title = "Pembelian Buku Fisik";
                $data['alamat'] = $request->street . ' ' . $request->ward . ' ' . $request->subdistrict . ' ' . $request->city . ' ' . $request->province . ' ' . $request->country . ' ' . $request->province . ' ' . $request->postal_code;
            }
            else {
                $title = "Pembelian Ebook";
            }

            $ebookDownload = EbookDownload::updateOrCreate([
                'ebook_id'  => $ebook->id,
                'email'     => $request->email,
                'no_hp'     => $request->phone,
            ], $data);

            return view('extend.payment_ebook', compact('title', 'ebook', 'ebookDownload'));
        }
//        return response()->download(public_path() . '/' . $ebook->file, $slug . '.pdf', ['Content-Type', 'application/pdf']);
    }

    public function delete($id)
    {
        Ebook::find($id)->delete();
        return redirect(route('ebooks'))->with('success', 'Ebooks has been deleted');
    }

    public function payment($id, Request $request)
    {
        $title = "Pembayaran di Proses";
        $randStr = substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', 5)), 0, 5);
        $file = current_disk()->putFileAs('public/uploads/payments', $request->file('file'), Auth::user()->id . '_' . $randStr . '.' . $request->file('file')->extension(), 'public');

        $ebookDownload = EbookDownload::find($id);
        $ebookDownload->update([
            'payment_nominal'   => $request->amount + $request->unique_amount,
            'payment_detail'    => $file,
            'payment_status'    => 1,
        ]);

        $ebook = Ebook::where('id', $ebookDownload->ebook_id)->first();

        return view('extend.payment_process_ebook', compact('title', 'ebook', 'ebookDownload'));
    }
    
    public function bukuList(Request $request)
    {
        $title = 'Books';
        $afiliasi_books = EbookDownload::with('ebook', 'afiliasi')->orderBy('id', 'desc')->paginate(20);
        $books = Ebook::where('free', 0)->get();
        return view('admin.cms.ebook_list_payment', compact('title', 'afiliasi_books', 'books'));
    }

    public function bukuUpdateStatus(Request $request, $id)
    {
        $book = EbookDownload::find($id);

        if ($book->status == 4) {
            return redirect()->back()->with('error', 'Afiliasi Book Status Has Been Received Before!');
        }
        $book->update([
            'status' => $request->status,
            'no_resi' => $request->no_resi
        ]);
        if ($request->status == 4 && $book->user_afiliasi_id) {
            $user = User::find($book->user_afiliasi_id);
            $user->update([
                'afiliasi_unpaid' => $user->afiliasi_unpaid + $book->afiliasi_komisi
            ]);
        }
        return redirect()->back()->with('success', 'Afiliasi Book Status Updated!');
    }

}
