<?php

namespace App\Imports;

use App\Teacher;
use Maatwebsite\Excel\Concerns\ToModel;

class TeacherImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Teacher([
            'name' => $row[1],
            'idcard' => $row[2],
            'mobile' => $row[3],
            'email' => $row[4],
            'specialization' => $row[5],
            'image' => $row[6],
            'office_id' => $row[7],
            'school_id' => $row[8],
        ]);
    }
}
