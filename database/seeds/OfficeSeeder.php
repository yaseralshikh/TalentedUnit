<?php

use Illuminate\Database\Seeder;

class OfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $offices = [
            'مكتب تعليم وسط جازان',
            'مكتب تعليم ابوعريش',
            'مكتب تعليم صامطة',
            'مكتب تعليم المسارحة والحرث',
            'مكتب تعليم العارضة',
            'مكتب تعليم فرسان',
            'ادارة الموهوبين',
        ];

        foreach ($offices as $office) {

            \App\Office::create([
                'name' => $office,
            ]);

        }//end of foreach
    }
}
