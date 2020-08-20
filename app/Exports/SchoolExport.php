<?php

namespace App\Exports;

use App\School;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SchoolExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return School::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'office_id',
            'moe_id',
            'stage',
            'manager',
            'mobile',
            'email',
            'created_at',
            'updated_at'
        ];
    }
}
