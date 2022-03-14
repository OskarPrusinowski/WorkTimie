<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FreeSaturdaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $start = 2010;
        $stop = 2030;
        $data = [];
        for ($i = $start; $i < $stop; $i++) {
            $data[] = ['year' => $i, 'free' => false];
        }
        DB::table("free_saturdays")->insert($data);
    }
}
