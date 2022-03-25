<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rolesPermissions = [[1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20], [6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20]];
        $roleId = 1;
        $data = [];
        foreach ($rolesPermissions as $rolePermission) {
            foreach ($rolePermission as $permission) {
                $data[] = ['role_id' => $roleId, 'permission_id' => $permission];
            }
            $roleId++;
        }
        DB::table("roles_permissions")->insert($data);
    }
}
