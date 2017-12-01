<?php

namespace App\Console;

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
        // $schedule->command('inspire')
        //          ->hourly();
        // Da ka Event
        $schedule->call(function(){
            $url = 'http://jira.multiverseinc.com/PunchEvent';
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET',$url);
            if ($res->voiceUrl==''){
                $res = $client->request('GET',$url);
            }
        })->timezone('Asia/Shanghai')->dailyAt('9:13');
        // Check sprint progress.
        $schedule->call(function(){
            $url = 'http://jira.multiverseinc.com/amChecked';
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET',$url);
            if ($res->voiceUrl==''){
                $res = $client->request('GET',$url);
            }
        })->timezone('Asia/Shanghai')->dailyAt('10:00');
        // Verify completed tasks
        $schedule->call(function(){
            $url = 'http://jira.multiverseinc.com/doneIssueChecked';
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET',$url);
            if ($res->voiceUrl==''){
                $res = $client->request('GET',$url);
            }
        })->timezone('Asia/Shanghai')->dailyAt('17:30');
        // volunteer for unassigned task.
        $schedule->call(function(){
            $url = 'http://jira.multiverseinc.com/todoChecked';
            $client = new \GuzzleHttp\Client();
            $res = $client->request('GET',$url);
            if ($res->voiceUrl==''){
                $res = $client->request('GET',$url);
            }
        })->weekdays()
            ->everyFiveMinutes()
            ->unlessBetween('09:25', '09:50')
            ->unlessBetween('12:00', '14:00');
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
