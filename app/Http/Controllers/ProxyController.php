<?php

namespace App\Http\Controllers;
use App\Core\ProxyProvider;
use App\Proxy;
class ProxyController extends Controller
{


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }
    
    /* This method is scheduled to run every hour in app/Console/Kernel.php@schedule()
        because SpyMe update its proxy list every hour    
    */
    public function saveSpysMeProxies()
    {
       $proxies = ProxyProvider::getParsedSpysMeProxy();
       foreach($proxies as $proxy){
            $newProxy = new Proxy();
            
            $newProxy->proxy = $proxy['proxy'];
            $newProxy->country = $proxy['country'];
            $newProxy->google_pass = $proxy['google_pass'];
            $newProxy->is_working = true;

            $newProxy->save();
       }
    }

    /* This method is scheduled to run every Thirty Minutes in app/Console/Kernel.php@schedule()
        because pubproxy API has 50 REQUESTS PER DAY LIMIT    
    */
    public function savePubProxies()
    {
       $proxies = ProxyProvider::getParsedPubProxy();
       foreach($proxies as $proxy){
            $newProxy = new Proxy();
            
            $newProxy->proxy = $proxy['proxy'];
            $newProxy->country = $proxy['country'];
            $newProxy->google_pass = $proxy['google_pass'];
            $newProxy->is_working = true;

            $newProxy->save();
       }
    }


}
