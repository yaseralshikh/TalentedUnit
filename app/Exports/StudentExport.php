<?php

namespace App\Exports;

use App\Student;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentExport implements FromCollection , WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Student::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'name',
            'idcard',
            'mobile',
            'email',
            'stage',
            'class',
            'degree',
            'office_id',
            'school_id',
            'teacher_id',
            'created_at',
            'updated_at'
        ];
    }
}
