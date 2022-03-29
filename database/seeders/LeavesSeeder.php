<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LeavesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = Carbon::now()->addHours(2)->format('Y-m-d');
        $userIds = DB::table('leaves')->where('start', '<=', $date)->where('end', '>=', $date)->get('user_id');
        foreach ($userIds as $userId) {
            DB::table('workdays')->where("user_id", $userId->user_id)->where('date', $date)->update(['holiday' => 'Urlop']);
        }
    }
}
