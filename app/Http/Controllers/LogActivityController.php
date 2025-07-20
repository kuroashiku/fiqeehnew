<?php

namespace App\Http\Controllers;
use App\User;
use App\UserPayment;

class LogActivityController extends Controller
{

    public function export()
    {
        $students = User::where('user_type', 'student')->orderBy('id')->get();
                // $data['students'] = $students->with('user_enrolls.course.category')
                //     ->get()->toArray();
                foreach ($students as $key => $value) {
                    $students[$key]['payment'] = UserPayment::where('user_id', $value['id'])->orderBy('created_at', 'DESC')->cursor();
                }
        $logs = $students;
        $filename = "log-activities.csv";

        return response()->streamDownload(function() use ($logs) {
            $csv = fopen("php://output", "w+");

            fputcsv($csv, ["ID","Name"]);

            foreach ($logs as $log) {
                fputcsv($csv, [
                    $log->id,
                    $log->name,
                ]);
            }

            fclose($csv);
        }, $filename, ["Content-type" => "text/csv"]);
    }

}