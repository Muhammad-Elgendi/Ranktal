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
        $this->middleware('auth');
    }

    public function seedProxies()
    {
       $proxies = ProxyProvider::getSpysMeProxy();
       foreach($proxies as $proxy){
            $newProxy = new Proxy();
            // $newProxy->
       }
    }

}
