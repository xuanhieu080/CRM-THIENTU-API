<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetFullName extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-full-name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::statement('UPDATE users SET full_name = CONCAT(first_name, " ", last_name)');
        DB::statement('UPDATE customers SET full_name = CONCAT(first_name, " ", last_name)');
    }
}
