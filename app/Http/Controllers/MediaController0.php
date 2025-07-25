<?php

namespace App\Http\Controllers;

use App\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{

    public function loadFileManager(Request $request) 
    {
        if (!$request->ajax()) {
            abort(404); 
        }

        $user = Auth::user();
        if ($user->user_type == 'student') {
            $media_query = $user->medias();
        } else {
            $media_query = Media::query();
        }

        if (!empty($request->filter_name)) {
            $media_query = $media_query->where("name", 'like', "%{$request->filter_name}%");
        }

        $media_query = $media_query->orderBy('id', 'desc')->paginate(30);
        $data['medias'] = $media_query;

        return view('inc.filemanager_content', $data);
    }

    /**
     * @param Request $request
     * @return array
     */

    public function store(Request $request)
    {
        if (config('app.is_demo')) return ['success' => false, 'msg' => __a('demo_restriction')];

        $user_id = Auth::user()->id;
        $allowed_file_types = (array) get_option('allowed_file_types_arr');

        if ($request->hasFile('files')) {
            $files = $request->file('files');

            try {
                foreach ($files as $file) {
                    $getFilename = $file->getClientOriginalName();
                    $clientExt = $file->getClientOriginalExtension();

                    if (!in_array($clientExt, $allowed_file_types)) {
                        return ['success' => false, 'msg' => $clientExt . ' - ' . __('admin.file_types_not_allowed')];
                    }

                    $extOriginal = $file->getClientOriginalExtension();
                    $ext = '.' . str_replace(['jpeg', 'jpg'], ['webp', 'webp'], $file->getClientOriginalExtension());
                    $baseSlug = str_replace($extOriginal, '', $getFilename);

                    $getMimeType = $file->getClientMimeType();
                    $getSize = $file->getSize();

                    $slug = strtolower($baseSlug);
                    $slug = unique_slug($slug, 'Media');
                    $slug_ext = $slug . $ext;

                    if (substr($getMimeType, 0, 5) == 'image') {
                        //It's imgae file
                        $image = $file;
                        $image_sizes = config('media.size');
                        $upload_dir = 'public/uploads/images/';

                        foreach ($image_sizes as $ikey => $ivalue) {
                            $img_thumb_name = $upload_dir . $ikey . '/' . $slug_ext;


                            $resized = Image::make($image)->encode('webp', 100)->fit($ivalue[0], $ivalue[1], function ($constraint) {
                                $constraint->upsize();
                            })->stream();
                            
                            // dd([$resized, $img_thumb_name]);
                            //upload thumb image
                            current_disk()->put(str_replace(['jpeg', 'jpg'], ['webp', 'webp'], $img_thumb_name), $resized->__toString(), 'public');
                        }
                        current_disk()->putFileAs('public/uploads/images/', $file, $slug_ext, 'public');
                    } else {
                        current_disk()->putFileAs('public/uploads/', $file, $slug_ext, 'public');
                    }

                    $uploaded_data = [
                        'user_id'   => $user_id,
                        'name'   => str_replace(['jpeg', 'jpg'], ['webp', 'webp'], $getFilename),
                        'slug'   => $slug,
                        'slug_ext'   => $slug_ext,
                        'file_size'   => $getSize,
                        'mime_type'   => str_replace(['jpeg', 'jpg'], ['webp', 'webp'], $getMimeType),
                    ];

                    if (substr($getMimeType, 0, 5) == 'video') {
                        $metaData = read_video_metadata($file->getPathname());
                        $uploaded_data['metadata'] = json_encode($metaData['metadata']);
                    }
 
                    $is_uploaded = Media::create($uploaded_data);
                }
            } catch (\Exception $e) {
                $errorMsg = $e->getMessage();
                return ['success' => false, 'msg' => $errorMsg];
            }

            return ['success' => true, 'msg' => __a('media_uploaded')];
        }
    }

    function storeEditor(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            current_disk()->putFileAs('public/tmp/uploads/', $request->file('upload'), $fileName, 'public');

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('tmp/uploads/' . $fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
        return false;
    }
    
    public function delete(Request $request)
    {
        if (config('app.is_demo')) return ['success' => false, 'msg' => __a('demo_restriction')];

        $media_ids = $request->media_ids;
        if (!empty($media_ids)) {
            $media_ids = array_filter(explode(',', $media_ids));
            if (is_array($media_ids)) {
                try {
                    foreach ($media_ids as $media_id) {
                        $media = Media::find($media_id);
                        if ($media) {
                            $media_name = $media->slug_ext;

                            //Deleting from database
                            $media->delete();

                            //Deleting from storage
                            $storage = current_disk();
                            if (substr($media->mime_type, 0, 5) == 'image') {
                                $image_sizes = config('media.size');

                                //Get all image size and delete form them
                                foreach ($image_sizes as $ikey => $ivalue) {
                                    $media_path = "uploads/images/{$ikey}/{$media_name}";

                                    if ($storage->has($media_path)) {
                                        $storage->delete($media_path);
                                    }
                                }

                                //Delete original file
                                $media_path = "uploads/images/{$media_name}";
                                if ($storage->has($media_path)) {
                                    $storage->delete($media_path);
                                }
                            }

                            //deleting any other file
                            $media_path = "uploads/{$media_name}";
                            if ($storage->has($media_path)) {
                                $storage->delete($media_path);
                            }
                        }
                    }
                } catch (\Exception $e) {
                    return array('success' => false, 'msg' => $e->getMessage());
                }
            }
        }
        return array('success' => true, 'msg' => __a('media_deleted'));
    }


    public function mediaManager(Request $request)
    {
        $title = __a('media_manager');

        $user = Auth::user();
        if ($user->isAdmin()) {
            $media_query = Media::query();
        } else {
            $media_query = $user->medias();
        }
        if (!empty($request->q)) {
            $media_query = $media_query->where("name", 'like', "%{$request->q}%");
        }
        $medias = $media_query->orderBy('id', 'desc')->paginate(30);
        return view('admin.media_manager', compact('title', 'medias'));
    }

    public function mediaManagerUpdate(Request $request)
    {
        if ($request->media_id) {
            Media::whereId($request->media_id)->update(['title' => $request->title, 'alt_text' => $request->alt_text]);
        }
        return ['success' => true];
    }
}
