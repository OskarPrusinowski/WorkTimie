<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [[
            "name" => "Oskar",
            "surname" => "Prusinowski",
            "email" => "prukioksi@gmail.com",
            "password" => Hash::make("oskar1928"),
            "date_start_employment" => Carbon::now()->startOfYear(),
            "role_id" => 1,
            'group_id' => 1
        ]];
        $faker = Factory::create();
        for ($i = 0; $i < 30; $i++) {
            $data[] = [
                'name' => $faker->name,
                'surname' => $faker->lastName,
                'email' => $faker->email,
                "password" => Hash::make("dada"),
                "date_start_employment" => $faker->date(),
                "role_id" => 2,
                'group_id' => $faker->numberBetween(1, 3)
            ];
        }
        DB::table('users')->insert($data);
    }
}
