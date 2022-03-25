<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ApplicationsCounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $years = ['2020', '2021', '2022', '2023', '2024'];
        $types = ['Urlop', 'Nadgodziny', 'Wcześniejsze zakończenie pracy'];
        $data = [];
        foreach ($years as $year) {
            foreach ($types as $type) {
                $data[] = ['type' => $type, 'year' => $year];
            }
        }
        DB::table('applications_counters')->insert($data);
    }
}
