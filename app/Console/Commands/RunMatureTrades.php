<?php

namespace App\Console\Commands;

use App\Jobs\MatureTrades;
use Illuminate\Console\Command;

class RunMatureTrades extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-mature-trades';

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
        MatureTrades::dispatch();
        $this->info('MatureTrades dispatched successfully...');
    }
}
