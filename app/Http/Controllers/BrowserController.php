<?php

namespace App\Http\Controllers;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Cookie;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class BrowserController extends Controller
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
    
   public function browse(){
       // This would be the url of the host running the server-standalone.jar
        $host = 'http://'.env('BROWSER_HOST').':'.env('BROWSER_PORT').'/wd/hub';
        $capabilities = DesiredCapabilities::chrome();
        $driver = RemoteWebDriver::create($host, $capabilities, 5000);

        // navigate to 'http://www.seleniumhq.org/'
        $driver->get('https://www.seleniumhq.org/');
        // adding cookie
        $driver->manage()->deleteAllCookies();
        $cookie = new Cookie('cookie_name', 'cookie_value');
        $driver->manage()->addCookie($cookie);
        $cookies = $driver->manage()->getCookies();
        print_r($cookies);
        // click the link 'About'
        $link = $driver->findElement(
            WebDriverBy::id('menu_about')
        );
        $link->click();
        // wait until the page is loaded
        $driver->wait()->until(
            WebDriverExpectedCondition::titleContains('About')
        );
        // print the title of the current page
        echo "The title is '" . $driver->getTitle() . "'\n";
        // print the URI of the current page
        echo "The current URI is '" . $driver->getCurrentURL() . "'\n";
        // write 'php' in the search box
        $driver->findElement(WebDriverBy::id('q'))
            ->sendKeys('php') // fill the search box
            ->submit(); // submit the whole form
        // wait at most 10 seconds until at least one result is shown
        $driver->wait(10)->until(
            WebDriverExpectedCondition::presenceOfAllElementsLocatedBy(
                WebDriverBy::className('gsc-result')
            )
        );
        // close the browser
        $driver->quit();
   }


}
