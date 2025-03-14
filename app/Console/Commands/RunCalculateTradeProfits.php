<?php

namespace App\Console\Commands;

use App\Jobs\CalculateTradeProfits;
use Illuminate\Console\Command;

class RunCalculateTradeProfits extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-calculate-trade-profits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Calculate trade profits';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        CalculateTradeProfits::dispatch();
        $this->info('CalculateTradeProfits dispatched successfully...');
    }
}
