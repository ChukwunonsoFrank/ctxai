<?php

namespace App\Console\Commands;

use App\Jobs\UpdateTradePair;
use Illuminate\Console\Command;

class RunUpdateTradePair extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:run-update-trade-pair';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update trade pair';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        UpdateTradePair::dispatch();
        $this->info('CalculateTradeProfits dispatched successfully...');
    }
}
