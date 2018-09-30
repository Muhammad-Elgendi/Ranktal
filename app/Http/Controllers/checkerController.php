<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Core\OnPageScraper;

class checkerController extends Controller
{
    //

    public function findOrCreateCheck(){
        $scraper =new OnPageScraper("https://is.net.sa");
        $cacheKey = md5($scraper->parsedUrl["host"].'/robots.txt');
		// //"e6cc277ec2bb14ca698d23a414d196a3"
		$minutes = 600;
		$robotsContent = Cache::remember($cacheKey, $minutes, function () use ($scraper){
			return $scraper->getRobots();
        });
        $scraper->setRobotsContent($robotsContent);

        $class_methods = get_class_methods($scraper);

        foreach ($class_methods as $method_name) {
            if($method_name != "__construct" && $method_name != "setRobotsContent")
                $scraper->$method_name();
        }

        var_dump(get_object_vars($scraper));

        // var_dump(Cache::get($cacheKey));
    }
}
