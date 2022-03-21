<?php

namespace App\Console\Commands;

use Database\Seeders\WorkdaysSeeder;
use Illuminate\Console\Command;

class DailyWorkdays extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workdays:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creating daily workdays';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->call(WorkdaysSeeder::class);
    }
}
