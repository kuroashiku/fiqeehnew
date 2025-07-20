<?php

namespace App\Http\Controllers;

use App\Package;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if ($request->bulk_action_btn === 'update_status') {
        //     Package::query()->whereIn('id', $request->bulk_ids)->update(['status' => $request->status]);
        //     return back()->with('success', __a('bulk_action_success'));
        // }
        // if ($request->bulk_action_btn === 'delete') {
        //     if (config('app.is_demo')) return back()->with('error', __a('demo_restriction'));

        //     Package::query()->whereIn('id', $request->bulk_ids)->delete();
        //     return back()->with('success', __a('bulk_action_success'));
        // }

        $title = 'Package';
        $packages = Package::orderBy('id', 'desc')->paginate(20);
        return view('admin.settings.package', compact('title', 'packages'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $title = 'Package';
        return view('admin.settings.package_create', compact('title'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:220',
            'price' => 'required',
            'status'  => 'required',
        ];
        $this->validate($request, $rules);

        $slug = unique_slug($request->title, 'Package');
        $data = [
            'title'         => clean_html($request->title),
            'slug'          => clean_html($slug),
            'description'   => clean_html($request->description),
            'price'         => $request->price,
            'discount_price'=> $request->discount_price,
            'status'        => 1,
        ];
        
        Package::create($data);
        return redirect(route('packages'))->with('success', 'Packages has been created');
    }

    /**
     * @param $slug
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $title = "Edit Package";
        $package = Package::find($id);
        return view('admin.settings.package_edit', compact('title', 'package'));
    }

    public function updatePackage(Request $request, $id)
    {
        $rules = [
            'title' => 'required|max:220',
            'price' => 'required',
            'status'  => 'required',
        ];
        $this->validate($request, $rules);
        $page = Package::find($id);

        $slug = unique_slug($request->title, 'Package');
        $data = [
            'title'         => clean_html($request->title),
            'slug'          => clean_html($slug),
            'description'   => clean_html($request->description),
            'price'         => $request->price,
            'discount_price'=> $request->discount_price,
            'status'        => 1,
        ];

        $page->update($data);
        return redirect()->back()->with('success', 'Package Updated');
    }

    public function delete($id)
    {
        Package::find($id)->delete();
        return redirect(route('packages'))->with('success', 'Packages has been deleted');
    }
}
