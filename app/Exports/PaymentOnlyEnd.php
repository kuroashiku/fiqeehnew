<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Validation\Rule;

class PaymentOnlyEnd implements FromView, ShouldAutoSize
{
    private $data;

    public function rules(): array
    {
        return [
            '0' => Rule::unique(['id', 'id'])
        ];
    }

    public function customValidationMessages()
{
    return [
        '0.unique' => 'Duplicate',
    ];
}


    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
    }

    public function view(): View
    {
        return view('laporan.payment_only_end', [
            'data' => $this->data,
        ]);
    }
}
