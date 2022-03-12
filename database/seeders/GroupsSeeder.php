<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GroupsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $groups = [['etat', 8], ['FV', 6], ['Umowa Zlecenie', 0]];

    public function run()
    {
        $data = [];
        foreach ($this->groups as $group) {
            $data[] = ['name' => $group[0], 'work_time' => $group[1]];
        }
        DB::table('groups')->insert($data);
    }
}
