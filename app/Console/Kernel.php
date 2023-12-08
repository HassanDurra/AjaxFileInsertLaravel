<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Symfony\Component\Process\Process; // Add this line to import the Process class

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
    }

    protected $commands = [
        Commands\SessionExpirey::class,
        // Add other commands here...
    ];

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');
        require base_path('routes/console.php');
         // Start the command as a daemonized process
         if (app()->runningInConsole()) {
            $this->startSessionExpireyCommand();
        }
    }
    protected function startSessionExpireyCommand()
    {
      
    }
}
