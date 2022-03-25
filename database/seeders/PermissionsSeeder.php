<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    protected $permissions = [
        'usersShow', 'usersManage', 'holidaysShow', 'holidaysManage', 'overtimesShow', 'overtimesManage', 'additionalHoursShow',
        'additionalHoursManage', 'leavesManage', 'leavesShow', 'applicationsShow', 'applicationsManage',   'workdaysShow',
        'workdaysManage', 'workPeriodsShow', 'workPeriodsManage', 'groupsShow', 'groupsManage', 'departmentsShow', 'departmentsManage'
    ];

    public function run()
    {
        $data = [];
        foreach ($this->permissions as $permission) {
            $data[] = ['name' => $permission];
        }
        DB::table('permissions')->insert($data);
    }
}
