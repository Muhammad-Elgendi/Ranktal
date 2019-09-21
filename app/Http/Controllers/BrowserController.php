<?php

namespace App\Http\Controllers;

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Cookie;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Exception\TimeOutException;
use Facebook\WebDriver\Exception\WebDriverException;
use PHPUnit\Framework\Exception;
use Facebook\WebDriver\Exception\WebDriverCurlException;

class BrowserController extends Controller
{


    // when recaptcha appear
    /**
     * click on <div class="recaptcha-checkbox-border" role="presentation"></div>
     * then click on this
     * <button class="rc-button goog-inline-block" tabindex="0" title="Solve the challenge" id="solver-button"></button>
     * then wait some seconds until this appear
     * <div class="recaptcha-checkbox-checkmark" role="presentation" style=""></div>
     * and this <div class="recaptcha-checkbox-border" role="presentation"></div> display becomes none
     * DONE ^^
     */

    /**
    * Login to chrome url https://accounts.google.com/signin/chrome/sync/identifier?ssp=1&continue=https%3A%2F%2Fwww.google.com%2F&flowName=GlifDesktopChromeSync
    * enter email
    *3 tabs then enter
    * enter pass
    *.........
    *
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Proxy in form IP:PORT
     */
    public static function isGooglePassedProxy($proxy){
        $driver = BrowserController::visitSiteWithProxy($proxy,"https://www.google.com");
        return BrowserController::checkGooglePass($driver);
    }

    /**
     * Proxy in form IP:PORT
     */
    public static function isBingPassedProxy($proxy){
       $driver = BrowserController::visitSiteWithProxy($proxy,"https://www.bing.com");
       return BrowserController::checkBingPass($driver);
    }

    /**
     * Pass a driver that already navigated to https://www.google.com
     */
    public static function checkGooglePass( RemoteWebDriver &$driver){
        // Check if Google Search input if exist

        $pass = null; 

        // Check using html
        // $html = $driver->getPageSource();
        // $doc = new \DOMDocument;
		// libxml_use_internal_errors(true);
		// $doc->loadHTML($html);
        // $xpath = new \DOMXpath($doc);
        // $exists = $xpath->query('//input[@name="q"]')->length > 0;


        $exists = BrowserController::isElementExist( $driver ,WebDriverBy::cssSelector('input[name="q"]'));

        if($exists){
            $pass = true;
        }else{
            $pass = false;
        }
    
        // close the browser
        $driver->quit();

        return $pass;
    }

    /**
     * Pass a driver that already navigated to https://bing.com
     */
    public static function checkBingPass( RemoteWebDriver &$driver){
        // check if <form action="/search"> element exist
        $pass = null;

        // Check using html
        // $html = $driver->getPageSource();
        // $doc = new \DOMDocument;
		// libxml_use_internal_errors(true);
		// $doc->loadHTML($html);
        // $xpath = new \DOMXpath($doc);
        // $exists = $xpath->query('//form[@action="/search"]')->length > 0;
        $exists = BrowserController::isElementExist( $driver ,WebDriverBy::cssSelector('form[action="/search"]'));

        if($exists){
            $pass = true;
        }else{
            $pass = false;
        }
     
        // close the browser
        $driver->quit();

        return $pass;

    }

    public static function isElementExist(RemoteWebDriver &$driver,WebDriverBy $by){
        try{
            $exists = $driver->findElement( $by )->isDisplayed();
            return $exists;
        }catch(NoSuchElementException $e){
            return false;
        }catch(TimeOutException $ex){
            return false;
        }catch(WebDriverCurlException $exp){
            return false;
        }
    }

    public static function visitSiteWithProxy($proxy,$url){
      
        // This would be the url of the host running the server-standalone.jar
        $host = 'http://'.env('BROWSER_HOST').':'.env('BROWSER_PORT').'/wd/hub';
        $options = new ChromeOptions();

        // Add buster-captcha-solver extension
        // Setting extensions is also optional
        // $options->addExtensions(array(
        //     '/var/www/chrome/extentions/buster-captcha-solver.crx'
        // ));
        
        // Available options:
        // http://peter.sh/experiments/chromium-command-line-switches/
        // run the browser directly in incognito mode.
        $options->addArguments(array(
            '--incognito',
            '--proxy-server='.$proxy
        ));

        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);        
        $driver = RemoteWebDriver::create(
            $host,
            $capabilities,
            5000
        );

        // remove all cookies
        $driver->manage()->deleteAllCookies();

        // set timeout to 30s after that exception with be thrown
        $driver->manage()->timeouts()->pageLoadTimeout(30);
        
        try{
            // navigate to the URL of the site
            $driver->get($url);

            // Wait for at most 10s and retry every 500ms if the page is not completely loaded.
            $driver->wait(10, 500)->until(
                function () use ($driver) {
                    $pageReady = $driver->executeScript('return window.document.readyState',array());
            
                    return $pageReady == 'complete';
                },
                'Error page loading takes more than 10s'
            );
        }catch(TimeOutException $e){
            return $driver;
        }catch(WebDriverCurlException $ex){
            return $driver;
        }catch(WebDriverException $exp){
            return $driver;
        }

        return $driver;
    }
    
    public function browse(){   
       // This would be the url of the host running the server-standalone.jar
        $host = 'http://'.env('BROWSER_HOST').':'.env('BROWSER_PORT').'/wd/hub';
        $options = new ChromeOptions();
        // Setting extensions is also optional
        $options->addExtensions(array(
            '/var/www/chrome/extentions/buster-captcha-solver.crx'
        ));
        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);        
        $driver = RemoteWebDriver::create(
            $host,
            $capabilities,
            5000       
        );

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
