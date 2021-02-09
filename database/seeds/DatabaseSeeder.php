<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(LaratrustSeeder::class);
        $this->call(OfficeSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CourseSeeder::class);
        $this->call(ProgramSeeder::class);
    }
}
