<?php

namespace App\Imports;

use App\School;
use Maatwebsite\Excel\Concerns\ToModel;

class SchoolImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new School([
            'name' => $row[1],
            'office_id' => $row[2],
            'moe_id' => $row[3],
            'stage' => $row[4],
            'manager' => $row[5],
            'mobile' => $row[6],
            'email' => $row[7],
        ]);
    }
}
