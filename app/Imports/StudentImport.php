<?php

namespace App\Imports;

use App\Student;
use Maatwebsite\Excel\Concerns\ToModel;

class StudentImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Student([
            'name' => $row[1],
            'idcard' => $row[2],
            'mobile' => $row[3],
            'email' => $row[4],
            'stage' => $row[5],
            'class' => $row[6],
            'degree' => $row[7],
            'office_id' => $row[8],
            'school_id' => $row[9],
            'teacher_id' => $row[10],
        ]);
    }
}
