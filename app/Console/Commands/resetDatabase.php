<?php

namespace App\Console\Commands;

use Database\Seeders\GroupsSeeder;
use Database\Seeders\PermissionsSeeder;
use Database\Seeders\RolesPermissionsSeeder;
use Database\Seeders\RolesSeeder;
use Database\Seeders\UsersSeeder;
use Illuminate\Console\Command;

class resetDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reseting databse';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call("migrate:rollback");
        $this->call("migrate");
        $this->call(RolesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(RolesPermissionsSeeder::class);
        $this->call(GroupsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call("workdays:create");
    }
}
