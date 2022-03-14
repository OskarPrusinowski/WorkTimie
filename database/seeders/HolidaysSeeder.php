<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HolidaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sunDay = new Carbon("2010-01-01");
        $stop = new Carbon("2030-01-01");
        $data = [];
        while ($sunDay->dayOfWeek != 0) {
            $sunDay->addDay();
        }

        while ($sunDay->lt($stop)) {
            $data[] = ['name' => "Wolna niedziela", "day" => "Niedziela", "date" => new Carbon($sunDay)];
            $sunDay->addDays(7);
        }
        DB::table('holidays')->insert($data);
    }
}
