<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        // Register your custom commands here
        \App\Console\Commands\ImportProducts::class,
        \App\Console\Commands\ImportStock::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        // Schedule your commands here
        $schedule->command('import:stocks')->daily();
    }
}
