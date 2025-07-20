<?php

namespace App\Imports;

use App\User;
use App\UserPayment;
use DateTime;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Hash;

class UsersImport implements ToCollection
{
    public $data;

    public function collection(Collection $rows)
    {
        $userInserted = [];
        for ($i = 1; $i < count($rows); $i++) {
            $row = $rows[$i];
            if (empty($row[1])) {
                continue;
            }

            $createdAt = Date::excelToDateTimeObject($row[11], 'Asia/Jakarta');
            $dataUser = [
                'name'              => $row[1],
                'phone'             => $row[2],
                'email'             => str_replace(' ','',strtolower($row[3])),
                'age'               => $row[4],
                'city'              => $row[5],
                'job_title'         => $row[6],
                'about_me'          => $row[7],
                'total_employee'    => $row[8],
                'created_at'        => $createdAt,
                'user_type'         => 'student',
                'active_status'     => 1,
                'last_payment'      => $row[9],
            ];

            try {
                $user = User::where('email', str_replace(' ','',strtolower($row[3])))->first();
                
                if ($user) {
                    User::where('id', $user->id)->update($dataUser);
                } else {
                    $dataUser['password'] = env('USER_PASSWORD_HASH');
                    $dataUser['expired_package_at'] = '2000-01-01 00:00:00';
                    $user = User::create($dataUser);
                    $userInserted[] = str_replace(' ','',strtolower($row[3]));
                }
                
                // Payment
                UserPayment::where('user_id', $user->id)->delete();
                $countProduct = (count($row) - 13) / 4;
                $product = $user->product;
                $expired = date('Y-m-d', strtotime($user->expired_package_at));
                $lastEndDate = "";
                for ($n = 0; $n < $countProduct; $n++) {
                    $countStart = 13 + ($n * 4);
                    if (!empty($row[$countStart]) && !empty($row[$countStart + 1])) {
                        $startDate = Date::excelToDateTimeObject($row[$countStart + 2], 'Asia/Jakarta');
                        $endDate = Date::excelToDateTimeObject($row[$countStart + 3], 'Asia/Jakarta');

                        $payment = [
                            'user_id'       => $user->id,
                            'product'       => $row[$countStart],
                            'amount'        => $row[$countStart + 1],
                            'unique_amount' => 0,
                            'started_at'    => $startDate,
                            'expired_at'    => $endDate,
                            'status'        => 1,
                            'monthly'       => $startDate->diff($endDate)->m,
                        ];
                        $dataPayment[] = UserPayment::create($payment);

                        if (!empty($row[$countStart])) {
                            $product = $row[$countStart];
                        }
                        $lastEndDate = $endDate->format('Y-m-d');
                    }
                }

                if (strtotime($lastEndDate) > strtotime($expired)) {
                    $prodExp = [
                        'product'               => $product,
                        'expired_package_at'    => $lastEndDate
                    ];
                    User::where('id', $user->id)->update($prodExp);
                }
            } catch (\Throwable $th) {
                dd([$th, $row]);
            }
        }

        $this->data = implode(', ', $userInserted);
    }
}
