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
        'usersShow', 'usersManage', 'holidaysShow', 'holidaysManage', 'applicationsAdminManage','overtimesManage','additionalHoursManage', 'leavesManage',  'overtimesShow',  'additionalHoursShow',
        'leavesShow', 'applicationsShow', 'applicationsManage',   'workdaysShow',
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
