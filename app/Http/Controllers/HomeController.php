<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use App\Post;
use App\User;
use App\Enroll;
use App\Complete;
use App\Content;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        if (isset($request->reff)) {
            $request->session()->put('reff', $request->reff);
        }

        $viewdata['kls'] = Course::count();
        $viewdata['jmlh'] = Course::where('id')->count();
        if (\Auth::user()) {
            if (\Auth::user()->user_type == 'admin') {
                return redirect(route('admin'));
            } else {
                return redirect(route('beranda'));
            }
        }
        $title = __t('home_page_title');
        // $new_courses = Course::publish()->orderBy('created_at', 'desc')->take(12)->get();
        // $featured_courses = Course::publish()->whereIsFeatured(1)->orderBy('featured_at', 'desc')->take(6)->get();
        // $popular_courses = Course::publish()->whereIsPopular(1)->orderBy('popular_added_at', 'desc')->take(8)->get();
        // $posts = Post::post()->publish()->take(3)->get();

        $course = Course::where('status', 1)->where('level', 4)->get()->toArray();

        $url = route('home');
        foreach ($course as $value) {
            $viewdata['kelas'] = $value['title'];
            if (\Auth::user() && $value['continue_url']) {
                $viewdata['link_kelas'] = $url . "/courses/free-enroll/" . $value['id'];
            } else {
                $viewdata['link_kelas'] = $url . "/login";
            }
        }

        $viewdata['unique_price'] = substr(str_shuffle('0123456789'), 1, 3);
        return view(theme('index','viewdata'), compact('title', 'viewdata'));
    }
    public function hompageKelas(Request $request)
    {
        if (isset($request->reff)) {
            $request->session()->put('reff', $request->reff);
        }

        $viewdata['kls'] = Course::count();
        $viewdata['jmlh'] = Course::where('id')->count();
        if (\Auth::user()) {
            if (\Auth::user()->user_type == 'admin') {
                return redirect(route('admin'));
            } else {
                return redirect(route('beranda'));
            }
        }
        $title = __t('home_page_title');

        $course = Course::where('status', 1)->where('level', 4)->get()->toArray();

        $url = route('home');
        foreach ($course as $value) {
            $viewdata['kelas'] = $value['title'];
            if (\Auth::user() && $value['continue_url']) {
                $viewdata['link_kelas'] = $url . "/courses/free-enroll/" . $value['id'];
            } else {
                $viewdata['link_kelas'] = $url . "/login";
            }
        }

        $viewdata['unique_price'] = substr(str_shuffle('0123456789'), 1, 3);
        return view(theme('h_kelas','viewdata'), compact('title', 'viewdata'));
    }

    public function beranda()
    {
        $title = "Beranda Kelas";
        // $new_courses = Course::publish()->orderBy('created_at', 'desc')->take(12)->get();
        // $featured_courses = Course::publish()->whereIsFeatured(1)->orderBy('featured_at', 'desc')->take(6)->get();
        // $popular_courses = Course::publish()->whereIsPopular(1)->orderBy('popular_added_at', 'desc')->take(8)->get();
        // $posts = Post::post()->publish()->take(3)->get();
        $course = Course::where('status', 1)->get()->toArray();

        $url = \Request::root();
        foreach ($course as $value) {
            $kelas[] = $value['title'];
            if (\Auth::user() && $value['continue_url']) {
                $link_kelas[] = $url . "/courses/enroll/" . $value['slug'];
            } else {
                $link_kelas[] = $url . "/login";
            }
        }

        return view(theme('beranda'), compact('title', 'kelas', 'link_kelas'));
    }

    public function berandaKelas()
    {
        $title = "Semua Kelas";
        // $new_courses = Course::publish()->orderBy('created_at', 'desc')->take(12)->get();
        // $featured_courses = Course::publish()->whereIsFeatured(1)->orderBy('featured_at', 'desc')->take(6)->get();
        // $popular_courses = Course::publish()->whereIsPopular(1)->orderBy('popular_added_at', 'desc')->take(8)->get();
        // $posts = Post::post()->publish()->take(3)->get();
        $course = Course::where('status', 1)->get()->toArray();

        $url = \Request::root();
        foreach ($course as $value) {
            $kelas[] = $value['title'];
            if (\Auth::user() && $value['continue_url']) {
                $link_kelas[] = $url . "/courses/enroll/" . $value['slug'];
            } else {
                $link_kelas[] = $url . "/login";
            }
        }

        return view(theme('b_kelas'), compact('title', 'kelas', 'link_kelas'));
    }

    public function closeSurvey($id)
    {
        User::where('id', $id)->update([
            'close_survey' => 1
        ]);

        return back();
    }

    public function ajaxClass(Request $request)
    {
        // DB::enableQueryLog();
        $course = Course::select('courses.*', 'categories.category_name')
            ->join('categories', 'courses.category_id', 'categories.id')
            ->join('contents', 'courses.id', 'contents.course_id')
            ->orderBy('courses.id', 'DESC')
            ->where('courses.status', 1);

        if ($request->search) {
            $course = $course->where('courses.title', 'like', '%' . $request->search . '%');
        }
        if ($request->category_name) {
            $course = $course->where('categories.slug', $request->category_name);
            if ($request->category_name != 'developer') {
                $course = $course->whereNotIn('courses.category_id', [1203]);
            }
        }
        if ($request->type == 'Kelas') {
            $course = $course->whereNull('contents.video_src');
        } elseif ($request->type == 'Dokumen') {
            $course = $course->whereNotNull('contents.video_src');
        }
        if ($request->program) {
            $programs = explode(',', $request->program);
            $course = $course->whereIn('categories.slug', $programs);
        }
        if ($request->rating) {
            $ratings = explode(',', $request->rating);
            $course = $course->where(function ($query) use ($ratings) {
                foreach ($ratings as $key => $value) {
                    $query->orWhere('rating_value', 'like', $value . '%');
                }
            });
        }
        if ($request->level) {
            $level = explode(',', $request->level);
            $list_level = [];
            foreach ($level as $key => $value) {
                switch ($value) {
                    case 'pemula':
                        $list_level[] = 1;
                        break;
                    case 'menengah':
                        $list_level[] = 2;
                        break;
                    case 'ahli':
                        $list_level[] = 3;
                        break;
                }
            }

            $course = $course->whereIn('courses.level', $list_level);
        }
        $course = $course->groupBy('courses.id')
            ->orderBy('courses.published_at')
            ->get()
            ->toArray();
            $url = \Request::root();

        foreach ($course as $key => $value) {
            if ($request->user_id && $request->user_id != 0) {
                $user_id = User::find($request->user_id);
                $completed_ids = Complete::whereUserId($user_id)->whereCourseId($value['id'])->pluck('content_id')->toArray();

                $content = Content::whereCourseId($value['id'])->whereNotIn('id', $completed_ids)->orderBy('sort_order', 'asc')->first();

                if (!$content) {
                    $content = Content::whereCourseId($value['id'])->orderBy('sort_order', 'asc')->first();
                }
                if (!$content) {
                    $course[$key]['continue_url'] = $url . "/kelas/enroll/" . $value['slug'];
                }
                if (empty($course[$key]['continue_url'])) {
                    $course[$key]['continue_url'] = $url . "/kelas/enroll/" . $value['slug'];
                }
            } else { 
                $course[$key]['continue_url'] = $url . "/kelas/enroll/" . $value['slug'];
            }
            $course[$key]['course_level'] = course_levels($value['level']);

        }
        return response()->json($course);
    }

    public function search($type)
    {
        $title = "Search";
        if ($type == "kelas") {
            $course = Course::with('category')->join('contents', 'courses.id', 'contents.course_id')
                ->where('courses.status', 1);
        }
        if (isset($_GET['search'])) {
            $course = $course->where('courses.title', 'like', '%' . $_GET['search'] . '%')->groupBy('courses.id');
        }
        $course = $course->groupBy('courses.id')->paginate(10);
        

        return view(theme('search'), compact('course', 'type', 'title'));
    } 
    public function listKategori()
    {
        $title = "List Kategori";
            $course = Course::with('category')->join('contents', 'courses.id', 'contents.course_id')
                ->where('courses.status', 1)->whereNotNull('contents.video_src');
        if (isset($_GET['search'])) {
            $course = $course->where('contents.title', 'like', '%' . $_GET['search'] . '%')->groupBy('courses.id');
        }   
        $course = $course->groupBy('courses.id')->paginate(10);
        $url = \Request::root();

        return view(theme('list_kategori'), compact('course',  'title'));
    }

    public function kelasFavorite()
    {
        $title = __t('home_page_title');
        return view(theme('kelas_favorite'), compact('title'));
    }

    public function sudahDitonton()
    {
        $title = __t('home_page_title');
        $firstCourse = Enroll::where('enrolls.user_id', \Auth::user()->id)->with('course.media', 'course.category')
            ->join('courses', 'courses.id', '=', 'enrolls.course_id')->first();
        $courses = Enroll::where('enrolls.user_id', \Auth::user()->id)->with('course.media', 'course.category')
            ->join('courses', 'courses.id', '=', 'enrolls.course_id')->paginate(10);
        return view(theme('sudah_ditonton'), compact('title', 'courses', 'firstCourse'));
    }

    public function courses(Request $r)
    {
        $title = __t('courses');
        $categories = Category::parent()->with('sub_categories')->get();
        $topics = Category::whereCategoryId($r->category)->get();

        $courses = Course::query();
        $courses = $courses->publish();

        if ($r->path() === 'featured-courses') {
            $title = __t('featured_courses');
            $courses = $courses->where('is_featured', 1);
        } elseif ($r->path() === 'popular-courses') {
            $title = __t('popular_courses');
            $courses = $courses->where('is_popular', 1);
        }

        if ($r->q) {
            $courses = $courses->where('title', 'LIKE', "%{$r->q}%");
        }
        if ($r->category) {
            $courses = $courses->where('second_category_id', $r->category);
        }
        if ($r->topic) {
            $courses = $courses->where('category_id', $r->topic);
        }
        if ($r->level && !in_array(0, $r->level)) {
            $courses = $courses->whereIn('level', $r->level);
        }
        if ($r->price) {
            $courses = $courses->whereIn('price_plan', $r->price);
        }
        if ($r->rating) {
            $courses = $courses->where('rating_value', '>=', $r->rating);
        }


        /**
         * Find by Video Duration
         */
        if ($r->video_duration === '0_2') {
            $durationEnd = (60 * 60 * 3) - 1; //02:59:59
            $courses = $courses->where('total_video_time', '<=', $durationEnd);
        } elseif ($r->video_duration === '3_5') {
            $durationStart = (60 * 60 * 3);
            $durationEnd = (60 * 60 * 6) - 1;
            $courses = $courses->whereBetween('total_video_time', [$durationStart, $durationEnd]);
        } elseif ($r->video_duration === '6_10') {
            $durationStart = (60 * 60 * 6);
            $durationEnd = (60 * 60 * 11) - 1;
            $courses = $courses->whereBetween('total_video_time', [$durationStart, $durationEnd]);
        } elseif ($r->video_duration === '11_20') {
            $durationStart = (60 * 60 * 11);
            $durationEnd = (60 * 60 * 21) - 1;
            $courses = $courses->whereBetween('total_video_time', [$durationStart, $durationEnd]);
        } elseif ($r->video_duration === '21') {
            $durationStart = (60 * 60 * 21);
            $courses = $courses->where('total_video_time', '>=', $durationStart);
        }

        switch ($r->sort) {
            case 'most-reviewed':
                $courses = $courses->orderBy('rating_count', 'desc');
                break;
            case 'highest-rated':
                $courses = $courses->orderBy('rating_value', 'desc');
                break;
            case 'newest':
                $courses = $courses->orderBy('published_at', 'desc');
                break;
            case 'price-low-to-high':
                $courses = $courses->orderBy('price', 'asc');
                break;
            case 'price-high-to-low':
                $courses = $courses->orderBy('price', 'desc');
                break;
            default:

                if ($r->path() === 'featured-courses') {
                    $courses = $courses->orderBy('featured_at', 'desc');
                } elseif ($r->path() === 'popular-courses') {
                    $courses = $courses->orderBy('popular_added_at', 'desc');
                } else {
                    $courses = $courses->orderBy('created_at', 'desc');
                }
        }

        $per_page = $r->perpage ? $r->perpage : 10;
        $courses = $courses->paginate($per_page);

        return view(theme('courses'), compact('title', 'courses', 'categories', 'topics'));
    }

    public function clearCache()
    {
        Artisan::call('debugbar:clear');
        Artisan::call('view:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('optimize:clear');
        if (function_exists('exec')) {
            exec('rm ' . storage_path('logs/*'));
        }
        $this->rrmdir(storage_path('logs/'));

        return redirect(route('home'));
    }

    public function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (is_dir($dir . "/" . $object))
                        $this->rrmdir($dir . "/" . $object);
                    else
                        unlink($dir . "/" . $object);
                }
            }
            //rmdir($dir);
        }
    }

    public function aboutUs()
    {
        return view(theme('about_us'));
    }

    public function freeEbook()
    {
        $title = "Buku";
        return view(theme('free_ebook'), compact('title'));
    }

    public function pageMarket()
    {
        $title = "Market";
        return view(theme('market'), compact('title'));
    }

    public function paidEbook()
    {
        return view(theme('paid_ebook'));
    }

    public function faq()
    {
        return view(theme('faq'));
    }

    public function testimoni()
    {
        return view(theme('testimoni'));
    }

    public function investor()
    {
        return view(theme('investor'));
    }

    public function afiliasi()
    {
        return view(theme('afiliasi'));
    }

    public function konsultasi_bisnis()
    {
        return view(theme('konsultasi_bisnis'));
    }

    public function terima_kasih()
    {
        return view(theme('terima_kasih'));
    }

    public function konsultasi_properti()
    {
        return view(theme('konsultasi_properti'));
    }

    public function sampleCertificate()
    {
        return view(theme('sample_certificate'));
    }
    public function hitung(){

    }
}
