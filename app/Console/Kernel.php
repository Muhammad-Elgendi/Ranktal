<?php

namespace App\Console;

use App\Http\Controllers\BrowserController;
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
        // clear bad proxies
        $schedule->call(function(){
            ProxyController::clearBadProxies();
        })->everyMinute();  
        
        $schedule->call(function(){     
            ProxyController::refreshProxiesStatus();
        })->hourly();  

        //update cache with real ip
        $schedule->call('App\Http\Controllers\ProxyController@updateServerRealIP')->twiceDaily(1, 13);

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

        //proxy checking 

        $schedule->call(function(){     
            ProxyController::updateProxiesPassEngines();         
        })->name('update-old-proxies-pass-engines')->withoutOverlapping()->everyMinute()->appendOutputTo(storage_path().'/logs/scheduling.txt')->runInBackground();

        $schedule->call(function(){
            ProxyController::updateProxiesPassEngines('desc');
        })->name('update-new-proxies-pass-engines')->withoutOverlapping()->everyMinute()->appendOutputTo(storage_path().'/logs/scheduling.txt')->runInBackground();   
    
        $schedule->call(function(){
            ProxyController::updateProxiesInfo();
        })->name('update-proxies-info')->withoutOverlapping()->everyMinute()->runInBackground();
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