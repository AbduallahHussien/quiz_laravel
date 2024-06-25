<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SendEmailReport;
use Illuminate\Support\Facades\DB;
use App\Domains\Scheduled\Interfaces\ScheduledRepositoryInterface;

class Kernel extends ConsoleKernel
{
    
    protected function schedule(Schedule $schedule): void
    {
    }
   

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
    public function failed()
        {
            Artisan::call('queue:retry all');
        }
}

