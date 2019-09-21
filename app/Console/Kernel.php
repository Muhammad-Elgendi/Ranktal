<?php

namespace App\Console;

use App\Http\Controllers\ProxyController;
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
        Commands\GenerateReport::class
    ];


    /**
     * For more info https://laradock.io/documentation/#run-laravel-scheduler
     * Currently We use workspace container
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //proxy acquisition
        $schedule->call(function(){
            ProxyController::saveProxiesFrom('getParsedSpysMeProxy');
        })->hourly();

        $schedule->call(function(){
            ProxyController::saveProxiesFrom('getParsedPubProxy');
        })->everyThirtyMinutes();

        $schedule->call(function(){
            ProxyController::saveProxiesFrom('getParsedProxyScrape');
        })->hourly();

        $schedule->call(function(){
            ProxyController::saveProxiesFrom('getParsedSpysMeProxy');
            ProxyController::saveProxiesFrom('getParsedPubProxy');
            ProxyController::saveProxiesFrom('getParsedProxyScrape');
        })->name('grab-all-proxies')->withoutOverlapping()->at("00:29");

        //proxy checking
        $schedule->call(function(){
            ProxyController::updateProxiesInfo();
        })->name('update-proxies-info')->withoutOverlapping()->everyFiveMinutes();

        $schedule->call(function(){     
            ProxyController::updateProxiesPassEngines();
        })->name('update-proxies-pass-engines')->withoutOverlapping()->everyFiveMinutes();

        //update cache with real ip
        $schedule->call('App\Http\Controllers\ProxyController@updateServerRealIP')->twiceDaily(1, 13); 


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
