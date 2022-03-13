<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $roles = ['admin', 'employee'];

    public function run()
    {
        $data = [];
        foreach ($this->roles as $role) {
            $data[] = ['name' => $role];
        }
        DB::table('roles')->insert($data);
    }
}
