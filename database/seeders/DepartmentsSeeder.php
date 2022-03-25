<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $names = ['UZ', 'IT', 'marketing'];
        $data = [];
        foreach ($names as $name) {
            $data[] = ['name' => $name];
        }
        DB::table('departments')->insert($data);
    }
}
