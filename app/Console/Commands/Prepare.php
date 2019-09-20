<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Prepare extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:me';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Launch all necessary processes for worked project';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        exec('php artisan migrate:fresh');
        echo 'Migrations: done' . PHP_EOL;
        exec('php artisan fillfilms:go');
        echo 'Database: filled' . PHP_EOL;
    }
}
