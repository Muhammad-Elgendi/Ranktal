<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Core\OnPageScraper;

class checkerController extends Controller
{
    //

    public function findOrCreateCheck(){
        $p =new OnPageScraper(Cache::get(),"https://is.net.sa");
        $cacheKey = md5($this->parsedUrl["host"].'/robots.txt');
		//"e6cc277ec2bb14ca698d23a414d196a3"
		$minutes = 600;
		$robotsContent = $this->cache->remember($cacheKey, $minutes, function () {
			return $this->getRobots();
		});

        $class_methods = get_class_methods($p);

        foreach ($class_methods as $method_name) {
            if($method_name != "__construct")
                $p->$method_name();
        }

        var_dump(get_object_vars($p));
    }
}
