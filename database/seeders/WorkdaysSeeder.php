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
        $day = $this->weekMap[Carbon::now()->addHour()->dayOfWeek];
        $date = Carbon::now()->addHour();
        //DB::table('workdays')->where('id', '>', 0)->delete();
        $data = [];
        foreach ($usersId as $userId) {
            $data[] = ['day' => $day, 'date' => $date, 'user_id' => $userId->id];
        }
        DB::table('workdays')->insert($data);
    }
}
