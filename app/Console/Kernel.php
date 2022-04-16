<?php

namespace App\Console;

use App\Jobs\SendReminderMailJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->command('queue:work', [
            '--stop-when-empty' => null,
        ])->everyMinute();

        $schedule->job( (new SendReminderMailJob())->delay(now()->addMinutes(2)), 'mail')->everyTwoMinutes();
        $schedule->job(new SendReminderMailJob(), 'mail')->everyTwoMinutes();
        $schedule->job(new SendReminderMailJob(), 'mail')->everyTwoMinutes();
        $schedule->job(new SendReminderMailJob(), 'sms')->everyTwoMinutes();
        $schedule->job(new SendReminderMailJob(), 'sms')->everyTwoMinutes();
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
}
