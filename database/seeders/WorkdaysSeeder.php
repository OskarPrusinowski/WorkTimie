<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class WorkdaysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $weekMap = [
        0 => 'Niedziela',
        1 => 'Poniedziałek',
        2 => 'Wtorek',
        3 => 'Środa',
        4 => 'Czwartek',
        5 => 'Piątek',
        6 => 'Sobota',
    ];

    public function run()
    {
        $usersId = DB::table('users')->get('id');
        $actualDay = Carbon::now()->addHours(2)->dayOfWeek;
        $day = $this->weekMap[$actualDay];
        $date = Carbon::now()->addHour();
        //DB::table('workdays')->where('id', '>', 0)->delete();
        $data = [];
        $holidays = DB::table('holidays')->where('date', Carbon::now()->addHours(2)->format('Y-m-d'))->first();
        $holiday = $holidays ? $holidays->name : null;
        if ($actualDay == 0) {
            $holiday = 'Niedziela';
        } else if ($actualDay == 6) {
            $holiday = 'Sobota';
        }
        foreach ($usersId as $userId) {
            $data[] = ['holiday' => $holiday, 'day' => $day, 'date' => $date, 'user_id' => $userId->id];
        }
        DB::table('workdays')->insert($data);
    }
}
