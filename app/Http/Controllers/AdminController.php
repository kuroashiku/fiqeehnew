<?php

namespace App\Http\Controllers;

use App\Category;
use App\Course;
use App\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     *
     * Landing page of dashboard
     */
    public function index()
    {
        $title = __a('dashboard');

        /**
         * Format Date Name
         */
        $start_date = date("Y-m-01");
        $end_date = date("Y-m-t");

        $begin = new \DateTime($start_date);
        $end = new \DateTime($end_date . ' + 1 day');
        $interval = \DateInterval::createFromDateString('1 day');
        $period = new \DatePeriod($begin, $interval, $end);

        $datesPeriod = array();
        foreach ($period as $dt) {
            $datesPeriod[$dt->format("Y-m-d")] = 0;
        }

        /**
         * Query This Month
         */

        $sql = "SELECT SUM(amount) as total_amount,
              DATE(started_at) as date_format
              from user_payments
              WHERE status = 1
              AND (started_at BETWEEN '{$start_date}' AND '{$end_date}')
              GROUP BY date_format
              ORDER BY started_at ASC ;";
        $getEarnings = DB::select(DB::raw($sql));

        $total_amount = array_pluck($getEarnings, 'total_amount');
        $queried_date = array_pluck($getEarnings, 'date_format');

        $dateWiseSales = array_combine($queried_date, $total_amount);

        $chartData = array_merge($datesPeriod, $dateWiseSales);
        foreach ($chartData as $key => $salesCount) {
            unset($chartData[$key]);

            $formatDate = date('d M', strtotime($key));
            //$formatDate = date('d', strtotime($key));
            $chartData[$formatDate] = $salesCount ? $salesCount : 0;
        }

        return view('admin.dashboard', compact('title', 'chartData'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *
     * Show all courses to the admin.
     */
    public function adminCourses(Request $request)
    {
        $ids = $request->bulk_ids;
        $now = Carbon::now()->toDateTimeString();

        if ($request->bulk_action_btn) {
            if (config('app.is_demo')) return back()->with('error', __a('demo_restriction'));
        }

        //Update
        if ($request->bulk_action_btn === 'update_status' && $request->status && is_array($ids) && count($ids)) {
            $data = ['status' => $request->status];

            if ($request->status == 1) {
                $data['published_at'] = $now;
            }

            Course::whereIn('id', $ids)->update($data);
            return back()->with('success', __a('bulk_action_success'));
        }
        if ($request->bulk_action_btn === 'mark_as_popular' && is_array($ids) && count($ids)) {
            Course::whereIn('id', $ids)->update(['is_popular' => 1, 'popular_added_at' => $now]);
            return back()->with('success', __a('bulk_action_success'));
        }
        if ($request->bulk_action_btn === 'mark_as_feature' && is_array($ids) && count($ids)) {
            Course::whereIn('id', $ids)->update(['is_featured' => 1, 'featured_at' => $now]);
            return back()->with('success', __a('bulk_action_success'));
        }

        if ($request->bulk_action_btn === 'remove_from_popular' && is_array($ids) && count($ids)) {
            Course::whereIn('id', $ids)->update(['is_popular' => null, 'popular_added_at' => null]);
            return back()->with('success', __a('bulk_action_success'));
        }
        if ($request->bulk_action_btn === 'remove_from_feature' && is_array($ids) && count($ids)) {
            Course::whereIn('id', $ids)->update(['is_featured' => null, 'featured_at' => null]);
            return back()->with('success', __a('bulk_action_success'));
        }

        //Delete
        if ($request->bulk_action_btn === 'delete' && is_array($ids) && count($ids)) {
            foreach ($ids as $id) {
                Course::find($id)->delete_and_sync();
            }
            return back()->with('success', __a('bulk_action_success'));
        }

        $title = __a('courses');
        $categories = Category::where('step', 2)->get();
        $courses = Course::query();

        if ($request->filter_status == "0") {
            $courses = $courses->where('status', $request->filter_status);
        } elseif ($request->filter_status) {
            $courses = $courses->where('status', $request->filter_status);
        } else {
            $courses = $courses->where('status', '>', 0);
        }
        if ($request->filter_category) {
            $courses = $courses->join('category_courses', 'courses.id', 'category_courses.course_id')
                ->where('category_courses.category_id', $request->filter_category);
        }
        if ($request->q) {
            $courses = $courses->where('title', 'LIKE', "%{$request->q}%");
        }

        if ($request->filter_by === 'popular') {
            $courses = $courses->where('is_popular', 1);
            $courses = $courses->orderBy('popular_added_at', 'desc');
        } elseif ($request->filter_by === 'featured') {
            $courses = $courses->where('is_featured', 1);
            $courses = $courses->orderBy('featured_at', 'desc');
        } else {
            $courses = $courses->orderBy('last_updated_at', 'desc');
        }
        $courses = $courses->with('category', 'content')->paginate(20);

        return view('admin.courses.courses', compact('title', 'courses', 'categories'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *
     * Withdraw requests
     */
    public function withdrawsRequests(Request $request)
    {
        if ($request->bulk_action_btn) {
            if (config('app.is_demo')) return back()->with('error', __a('demo_restriction'));
        }

        if ($request->bulk_action_btn === 'update_status' && $request->update_status) {
            Withdraw::whereIn('id', $request->bulk_ids)->update(['status' => $request->update_status]);
            return back();
        }
        if ($request->bulk_action_btn === 'delete') {
            Withdraw::whereIn('id', $request->bulk_ids)->delete();
            return back();
        }


        $title = __a('withdraws');
        $withdraws = Withdraw::query();

        if ($request->status) {
            if ($request->status !== 'all') {
                $withdraws = $withdraws->where('status', $request->status);
            }
        } else {
            $withdraws = $withdraws->where('status', 'pending');
        }

        $withdraws = $withdraws->orderBy('created_at', 'desc')->paginate(50);

        return view('admin.withdraws', compact('title', 'withdraws'));
    }
}
