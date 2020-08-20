<?php

namespace App\Exports;

use App\Teacher;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TeacherExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Teacher::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'idcard',
            'mobile',
            'email',
            'specialization',
            'image',
            'office_id',
            'school_id',
            'created_at',
            'updated_at'
        ];
    }
}
