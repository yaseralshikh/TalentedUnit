<?php

namespace App\Exports;

use App\Office;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OfficeExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Office::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'created_at',
            'updated_at'
        ];
    }
}
