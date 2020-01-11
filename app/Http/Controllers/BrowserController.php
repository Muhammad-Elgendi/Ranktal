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
use Facebook\WebDriver\WebDriverKeys;

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

    
    // Google doesn't block proxies that hit their home pages so you can get suggests without pain
    public static function getGoogleSuggests($keyword){

        // Get a proxy
        $proxy = ProxyController::getProxy();
        $type = empty($proxy->type) ? 'http' : $proxy->type;
        $proxy_url = $type.'://'.$proxy->proxy;

        $driver = BrowserController::visitSiteWithProxy($proxy_url, "https://google.com");
        return BrowserController::getGoogleSuggestsHtml($driver, $keyword);
    }

    public static function getGoogleSuggestsHtml(RemoteWebDriver &$driver, $keyword)
    {
        $html = null;
        try {
            // fill the search box
            // $driver->getKeyboard()->sendKeys($keyword);
            $driver->findElement(WebDriverBy::cssSelector('input[name="q"]'))->sendKeys($keyword);
            // wait untill appear of elements
            // div class="suggestions-inner-container"

            $driver->wait(3, 500)->until(
                function () use ($driver) {
                    $elements = $driver->findElements(WebDriverBy::cssSelector('div[class="suggestions-inner-container"]'));
                    return count($elements) > 0;
                },
                'Error locating elements'
            );

            $html = $driver->getPageSource();
        } catch (TimeOutException $e) { } catch (NoSuchElementException $expr) { } catch (WebDriverCurlException $ex) { } catch (WebDriverException $exp) { }

        // close driver
        $driver->quit();

        return $html;
    }

    public static function getAnswerPublicSuggests($keyword){

        // Get a proxy
        $proxy = ProxyController::getProxy();
        $type = empty($proxy->type) ? 'http' : $proxy->type;
        $proxy_url = $type.'://'.$proxy->proxy;

        $driver = BrowserController::visitSiteWithProxy($proxy_url, "https://answerthepublic.com");
        return BrowserController::getAnswerPublicHtml($driver, $keyword);
    }

    public static function getAnswerPublicHtml(RemoteWebDriver &$driver, $keyword)
    {
        $html = null;
        try {
            // fill the search box
            // $driver->getKeyboard()->sendKeys($keyword);
            $driver->findElement(WebDriverBy::cssSelector('input[id="report_keyword"]'))->sendKeys($keyword);           
            // click search
            $driver->getKeyboard()->pressKey(WebDriverKeys::ENTER);

            // wait untill disapear of
            // <img height="11" width="43" alt="Loading" src="/assets/spinner-bar-43x11-d248411bbf25a1946f44227ebb0ecb72a6189bc943cfe607d6dae50dd81b6bb5.gif">
            // Or untill appear of elements
            // div class="row modifier-list--suggestion"
            // ul class="modifier-list"

            $driver->wait(6, 300)->until(
                function () use ($driver) {
                    $elements = $driver->findElements(WebDriverBy::cssSelector('div[class="row modifier-list--suggestion"]'));
                    $elements2 = $driver->findElements(WebDriverBy::cssSelector('ul[class="modifier-list"]'));
                    return count($elements) > 0 || count($elements2) > 0;
                },
                'Error locating elements'
            );

            $html = $driver->getPageSource();
        } catch (TimeOutException $e) { } catch (NoSuchElementException $expr) { } catch (WebDriverCurlException $ex) { } catch (WebDriverException $exp) { }

        // close driver
        $driver->quit();

        return $html;
    }

    public static function getSoovleSuggests($keyword)
    {

        // Get a proxy
        $proxy = ProxyController::getProxy();
        $type = empty($proxy->type) ? 'http' : $proxy->type;
        $proxy_url = $type.'://'.$proxy->proxy;

        $driver = BrowserController::visitSiteWithProxy($proxy_url, "https://soovle.com");
        return BrowserController::getSoolveHtml($driver, $keyword);
    }

    public static function getSoolveHtml(RemoteWebDriver &$driver, $keyword)
    {
        $html = null;
        try {
            // fill the search box
            // $driver->getKeyboard()->sendKeys($keyword);
            $driver->findElement(WebDriverBy::cssSelector('input[id="searchinput"]'))->sendKeys($keyword);           
            $driver->wait(5, 4000)->until(
                function () use ($driver) {
                    $elements = $driver->findElements(WebDriverBy::cssSelector('div[classname="sugg"]'));

                    return count($elements) > 0;
                },
                'Error locating elements'
            );
            $html = $driver->getPageSource();
        } catch (TimeOutException $e) { } catch (NoSuchElementException $expr) { } catch (WebDriverCurlException $ex) { } catch (WebDriverException $exp) { }

        // close driver
        $driver->quit();

        return $html;
    }

    // Get htmls of google serp
    public static function getGoogleSerp($keyword, $device, $language, $country, $latitude, $longitude, $location,  $url = null, $proxy = null)
    {

        $html = [];
        if ($proxy == null) {
            // Get a proxy
            $proxy = ProxyController::getProxy('google');
        }

        $type = empty($proxy->type) ? 'http' : $proxy->type;
        $proxy_url = $type . '://' . $proxy->proxy;

        // Formulate the url        
        // https://www.google.com/search?q=seo+software+tools&hl=ar&gl=EG&ie=utf-8&oe=utf-8&pws=0&uule=a+cm9sZToxCnByb2R1Y2VyOjEyCnByb3ZlbmFuY2U6Ngp0aW1lc3RhbXA6MTU3MTE2NjA5NDY3NDAwMApsYXRsbmd7CmxhdGl0dWRlX2U3OjM3NDEwODQyNQpsb25naXR1ZGVfZTc6LTEyMjA3MjcxMzQKfQpyYWRpdXM6OTMwMDA%3D
        // other url
        // $url = $domain."/search?q=".$keyword."&ie=utf8&oe=utf8&hl=".$language."&num=100&client=ubuntu";
        
        if ($url == null) {
            // Formulate the url
            $keyword = urlencode($keyword);
            $location = urlencode($location);
            $domain = KeywordTrackerController::getGoogleDomain($country);
            $url = $domain.'/search?q='.$keyword.'&hl='.$language.'&gl='.$country.'&ie=utf-8&oe=utf-8&pws=0&num=100&uule='.$location;
        }    

        $driver = BrowserController::visitSiteWithProxyAndLatlngAndDevice($proxy_url, $url, $latitude, $longitude, $device);
        $html[] = $driver->getPageSource();
        for ($i = 1; $i <= 1; $i++) {

            try {
                // click the next page
                $link = $driver->findElement(
                    WebDriverBy::cssSelector('#pnnext')
                );
                $link->click();

                // Wait for at most 10s and retry every 500ms if the page is not completely loaded.
                $driver->wait(10, 500)->until(
                    function () use ($driver) {
                        $pageReady = $driver->executeScript('return window.document.readyState', array());

                        return $pageReady == 'complete';
                    },
                    'Error page loading takes more than 10s'
                );
                // add html to array
                $html[] = $driver->getPageSource();
                $url =  $driver->getCurrentURL();
            } catch (TimeOutException $e) { } catch (NoSuchElementException $expr) { } catch (WebDriverCurlException $ex) { } catch (WebDriverException $exp) { }
        }

        $driver->quit();
        return compact('html', 'proxy','url');
    }

    // Not used
    public static function getGoogleHtmls(RemoteWebDriver $driver, $proxy, $keyword)
    {
        $html = [];
        $google_pass = null;
        try {

            // fill the search box
            $driver->findElement(WebDriverBy::cssSelector('input[name="q"]'))->sendKeys($keyword);
            // click search
            $driver->getKeyboard()->pressKey(WebDriverKeys::ENTER);
            // $driver->findElement(WebDriverBy::cssSelector('input[name="q"]'))->sendKeys();

            // Wait for at most 10s and retry every 500ms if the page is not completely loaded.
            $driver->wait(10, 500)->until(
                function () use ($driver) {
                    $pageReady = $driver->executeScript('return window.document.readyState', array());

                    return $pageReady == 'complete';
                },
                'Error page loading takes more than 10s'
            );

            // Check if google detect proxy
            if (stripos($driver->getCurrentURL(), 'sorry') !== false) {

                $google_pass = false;
            } else {

                $html[] = $driver->getPageSource();
                // click the next page
                $link = $driver->findElement(
                    WebDriverBy::cssSelector('a[id="pnnext"]')
                );
                $link->click();

                // Wait for at most 10s and retry every 500ms if the page is not completely loaded.
                $driver->wait(10, 500)->until(
                    function () use ($driver) {
                        $pageReady = $driver->executeScript('return window.document.readyState', array());

                        return $pageReady == 'complete';
                    },
                    'Error page loading takes more than 10s'
                );
                // add html to array
                $html[] = $driver->getPageSource();

                // update proxy status
                $google_pass = true;
            }
        } catch (TimeOutException $e) {
            $google_pass = false;
        } catch (NoSuchElementException $expr) {
            $google_pass = false;
        } catch (WebDriverCurlException $ex) {
            $google_pass = false;
        } catch (WebDriverException $exp) {
            $google_pass = false;
        }

        // close driver
        $driver->quit();

        // save proxy status
        $proxy->google_pass = $google_pass;
        $proxy->save();

        return $html;
    }

    // Not used
    // Take a driver that already navigated to google page get google serp and suggest list html
    public static function getGoogleHtmlAndSuggests(RemoteWebDriver &$driver, &$proxy)
    {
        /**
         * Next Page
         * <a class="pn" href="/search?q=seo+software+saas&amp;ei=1LCMXfKIIfnKgwe8tYEQ&amp;start=10&amp;sa=N&amp;ved=0ahUKEwjywtypwO7kAhV55eAKHbxaAAIQ8NMDCKoB" id="pnnext" style="text-align:left">
         * <span class="csb ch" style="background:url(/images/nav_logo299.webp) no-repeat;background-position:-96px 0;width:71px"></span>
         * <span style="display:block;margin-left:53px">Next</span>
         * </a>
         * 
         * Related
         * <div class="card-section">
         * <div class="brs_col">
         * <p class="nVcaUb">
         * <a href="/search?biw=1600&amp;bih=737&amp;q=free+seo+software+download&amp;sa=X&amp;ved=2ahUKEwi9weOWwe7kAhUDURUIHY60B18Q1QIoAHoECAsQAQ">
         *   <b>free</b> seo software <b>download</b>
         * </a>
         * </p>
         * </div>
         * </div>
         * 
         * Location 
         * <span id="Wprf1b">Shebeen El-Kom, Qism Shebeen El-Kom, Shibin el Kom</span>
         * 
         * Country
         * <span class="Q8LRLc">Egypt</span>
         * 
         * People also ask
         * <div decode-data-ved="1" eid="c7KMXcbEC72cjLsP6Jip4AU" class="related-question-pair" data-ved="2ahUKEwiGyrjvwe7kAhU9DmMBHWhMClwQq7kBKAB6BAgLEAI"><g-accordion-expander jscontroller="XMgU6d" jsshadow="" jsaction="ac_ar:y3EGVb;b_cs:XyzvNd;rcuQ6b:npT2md"><div jsname="ARU61" class="mWyH1d kno-atc" aria-controls="_c7KMXcbEC72cjLsP6Jip4AU21" aria-expanded="false" id="_c7KMXcbEC72cjLsP6Jip4AU22" jsslot="" role="tab" jsaction="CQwlrf;fastbutton:CQwlrf"><span class="vp45yf z1asCe bjaP2b" style="right:16px"><svg focusable="false" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M7.41 8.59L12 13.17l4.59-4.58L18 10l-6 6-6-6 1.41-1.41z"></path></svg></span><div style="padding-right:40px" jsname="xXq91c" class="match-mod-horizontal-padding hide-focus-ring cbphWd" data-kt="KjHo2r-d6cbuzuQBl7jAsPumzu2ZAZb1xr2QtPasvwGZ2fjBzPj190Dymejm4rPp4tgB" tabindex="0" data-hveid="CAsQAw" data-ved="2ahUKEwiGyrjvwe7kAhU9DmMBHWhMClwQuk4oAHoECAsQAw">Is SEO PowerSuite free?</div></div><div jsname="dcydfb" class="gy6Qzb kno-ahide" aria-hidden="true" aria-labelledby="_c7KMXcbEC72cjLsP6Jip4AU22" id="_c7KMXcbEC72cjLsP6Jip4AU21" jsslot="" role="tabpanel" jsaction="CQwlrf;fastbutton:CQwlrf" data-ved="2ahUKEwiGyrjvwe7kAhU9DmMBHWhMClwQpPYEKAF6BAgLEAQ" style="max-height: 0px;"><div><div jsname="oQYOj" id="_c7KMXcbEC72cjLsP6Jip4AU23" data-hveid="CAsQBQ" data-ved="2ahUKEwiGyrjvwe7kAhU9DmMBHWhMClwQu04oAHoECAsQBQ"><div class="mod" data-md="61" style="clear:none"><!--m--><div class="LGOjhe" aria-level="3" role="heading" data-hveid="CAsQBg"><span class="ILfuVd NA6bn"><span class="e24Kjd"><b>SEO PowerSuite</b> offers unlimited sites, keywords, and backlinks to track, and a wealth of features you won't find anywhere else, many of which are available in the <b>free</b> version. The catch? There isn't any. Because it's a desktop platform, we don't have to pay for hundreds of servers to process your data.</span></span></div><!--n--></div><div class="g"><!--m--><div data-hveid="CAsQCA" data-ved="2ahUKEwiGyrjvwe7kAhU9DmMBHWhMClwQFSgAMAJ6BAgLEAg"><div class="rc"><div class="r"><a href="https://www.link-assistant.com/" ping="/url?sa=t&amp;source=web&amp;rct=j&amp;url=https://www.link-assistant.com/&amp;ved=2ahUKEwiGyrjvwe7kAhU9DmMBHWhMClwQFjACegQICxAJ"><h3 class="LC20lb"><div class="ellip">SEO PowerSuite: All-In-One SEO Software &amp; SEO Tools</div></h3><br><div class="TbwUpd"><cite class="iUh30">https://www.link-assistant.com</cite></div></a></div><div class="s"><div></div></div></div></div><!--n--></div><div class="match-mod-horizontal-padding kcHZBe">Search for: <a href="/search?biw=1600&amp;bih=737&amp;q=Is+SEO+PowerSuite+free%3F&amp;sa=X&amp;ved=2ahUKEwiGyrjvwe7kAhU9DmMBHWhMClwQzmd6BAgLEAo">Is SEO PowerSuite free?</a></div></div></div></div></g-accordion-expander></div>
         * 
         * 
         */

        // Check for capetcha
        /**
         * <div class="recaptcha-checkbox-border" role="presentation"></div>
         * checkmark
         * <div class="recaptcha-checkbox-checkmark" role="presentation" style=""></div>
         */
        $html = [];


        // // get google suggests html for current search term

        // // click the search bar
        // $bar = $driver->findElement(
        //     WebDriverBy::cssSelector('input[name="q"]')
        // );
        // $bar->click();

        // // wait for list to appear
        // $driver->wait(2, 500)->until(
        //     WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('ul[role="listbox"]'))
        // );

        // $list = $driver->findElement(
        //     WebDriverBy::cssSelector('ul[role="listbox"]')
        // );

        // // get list element html
        // $result['suggest'] = $list->getAttribute('innerHTML');

        // Check if google detect proxy
        if (stripos($driver->getCurrentURL(), 'sorry') !== false) {
            // try to solve recaptcha

            //     $capetcha = $driver->findElement(
            //         WebDriverBy::cssSelector('div[class="recaptcha-checkbox-border"]')
            //     );
            //     $capetcha->click();

            //     // wait for checkmark visability
            //     $driver->wait(10, 500)->until(
            //         WebDriverExpectedCondition::visibilityOfElementLocated(WebDriverBy::cssSelector('div[class="recaptcha-checkbox-checkmark"]'))
            //     );

            //     // Wait for at most 10s and retry every 500ms if the page is not completely loaded.
            //     $driver->wait(10, 500)->until(
            //         function () use ($driver) {
            //             $pageReady = $driver->executeScript('return window.document.readyState',array());

            //             return $pageReady == 'complete';
            //         },
            //         'Error page loading takes more than 10s'
            //     );

            $proxy->google_pass = false;
            $proxy->save();
        } else {
            try {

                $html[] = $driver->getPageSource();
                // click the next page
                $link = $driver->findElement(
                    WebDriverBy::cssSelector('a[id="pnnext"]')
                );
                $link->click();

                // Wait for at most 10s and retry every 500ms if the page is not completely loaded.
                $driver->wait(10, 500)->until(
                    function () use ($driver) {
                        $pageReady = $driver->executeScript('return window.document.readyState', array());

                        return $pageReady == 'complete';
                    },
                    'Error page loading takes more than 10s'
                );
                // add html to array
                $html[] = $driver->getPageSource();
            } catch (TimeOutException $e) { } catch (NoSuchElementException $expr) { } catch (WebDriverCurlException $ex) { } catch (WebDriverException $exp) { }

            $proxy->google_pass = true;
            $proxy->save();
        }

        // close driver
        $driver->quit();

        return $html;
    }

    // Get html of bing serp with used proxy
    public static function getBingSerp($keyword, $device, $language, $country, $latitude, $longitude, $url = null, $proxy = null)
    {
        $html = [];
        if ($proxy == null) {
            // Get a proxy
            $proxy = ProxyController::getProxy('bing');
        }
        $type = empty($proxy->type) ? 'http' : $proxy->type;
        $proxy_url = $type . '://' . $proxy->proxy;

        if ($url == null) {
            // Formulate the url
            $keyword = urlencode($keyword);
            $url = "https://www.bing.com/search?q=" . $keyword . "&setLang=" . $language . "&cc=" . $country;
        }

        $driver = BrowserController::visitSiteWithProxyAndLatlngAndDevice($proxy_url, $url, $latitude, $longitude, $device);
        $html[] = $driver->getPageSource();

        for ($i = 1; $i <= 20; $i++) {

            try {
                // click the next page
                $link = $driver->findElement(
                    WebDriverBy::cssSelector('.sb_pagN')
                );
                $link->click();

                // Wait for at most 10s and retry every 500ms if the page is not completely loaded.
                $driver->wait(10, 500)->until(
                    function () use ($driver) {
                        $pageReady = $driver->executeScript('return window.document.readyState', array());

                        return $pageReady == 'complete';
                    },
                    'Error page loading takes more than 10s'
                );
                // add html to array
                $html[] = $driver->getPageSource();
            } catch (TimeOutException $e) { } catch (NoSuchElementException $expr) { } catch (WebDriverCurlException $ex) { } catch (WebDriverException $exp) { }
        }

        $driver->quit();
        return compact('html', 'proxy');
    }

    public static function visitSiteWithProxyAndLatlngAndDevice($proxy, $url, $latitude, $longitude, $device = 'desktop', $loadExtention = false)
    {

        // This would be the url of the host running the server-standalone.jar
        $host = 'http://' . env('BROWSER_HOST') . ':' . env('BROWSER_PORT') . '/wd/hub';
        $options = new ChromeOptions();

        if ($loadExtention) {
            // Add buster-captcha-solver extension
            // Setting extensions is also optional
            $options->addExtensions(array(
                '/var/www/chrome/extentions/buster-captcha-solver.crx'
            ));
            $options->addArguments(array(
                '--proxy-server=' . $proxy,
                '--blink-settings=imagesEnabled=false'
            ));
        } else {
            // Available options:
            // http://peter.sh/experiments/chromium-command-line-switches/
            // run the browser directly in incognito mode.
            /**
             *          '--no-sandbox',
             *          '--headless',
             */
            $options->addArguments(array(
                '--incognito',
                '--proxy-server=' . $proxy,
                '--blink-settings=imagesEnabled=false'
            ));
        }

        if ($device == 'mobile') {
            $options->setExperimentalOption('mobileEmulation', ["deviceName" => "Nexus 5"]);
        }


        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
        $driver = RemoteWebDriver::create(
            $host,
            $capabilities,
            5000
        );

        // remove all cookies
        $driver->manage()->deleteAllCookies();

        // Enable geolocation
        $driver->executeScript('window.navigator.geolocation.getCurrentPosition = 
        function(success){
             var position = {"coords" : {
                                           "latitude": "' . $latitude . '", 
                                           "longitude": "' . $longitude . '"
                                         }
                             }; 
             success(position);}', array());

        // set timeout to 30s after that exception with be thrown
        $driver->manage()->timeouts()->pageLoadTimeout(30);

        try {
            // navigate to the URL of the site
            $driver->get($url);

            // Wait for at most 10s and retry every 200ms if the page is not completely loaded.
            $driver->wait(10, 200)->until(
                function () use ($driver) {
                    $pageReady = $driver->executeScript('return window.document.readyState', array());

                    return $pageReady == 'complete';
                },
                'Error page loading takes more than 10s'
            );
        } catch (TimeOutException $e) {
            return $driver;
        } catch (WebDriverCurlException $ex) {
            return $driver;
        } catch (WebDriverException $exp) {
            return $driver;
        }

        return $driver;
    }

    /**
     * Proxy in form IP:PORT
     */
    public static function isGooglePassedProxy($proxy)
    {
        // $keyword = '5+5';
        // $url = https://www.google.com/search?q=5%2B5&oq=5%2B5&aqs=chrome.0.69i59j69i65l3.2278j0j1&sourceid=chrome&ie=UTF-8
        // $url = 'https://www.google.com/search?q=5%2B5&oq=5%2B5&aqs=chrome..69i57.3027j0j0&sourceid=chrome&ie=UTF-8';  
        $url = "https://www.google.com/search?q=5*12&ie=utf-8&oe=utf-8&pws=0";
        $driver = BrowserController::visitSiteWithProxy($proxy, $url,16); 
        return BrowserController::checkGooglePass($driver);
    }

    /**
     * Proxy in form IP:PORT
     */
    public static function isBingPassedProxy($proxy){
        $url = "https://www.bing.com/search?q=5*12";
        $driver = BrowserController::visitSiteWithProxy($proxy, $url);
        return BrowserController::checkBingPass($driver);
    }

    /**
     * Pass a driver that already navigated to https://www.google.com
     */
    public static function checkGooglePass(RemoteWebDriver &$driver)
    {
        $pass = null;
        try {
            // // fill the search box
            // $driver->findElement(WebDriverBy::cssSelector('input[name="q"]'))->sendKeys('1+1');
            // // $driver->getKeyboard()->sendKeys($keyword);
            // // // click search
            // $driver->getKeyboard()->pressKey(WebDriverKeys::ENTER);
         

            // Wait for at most 5s and retry every 500ms if the page is not completely loaded.
            $driver->wait(5, 200)->until(
                function () use ($driver) {
                    $pageReady = $driver->executeScript('return window.document.readyState', array());

                    return $pageReady == 'complete';
                },
                'Error page loading takes more than 10s'
            );

            // Check if google detect proxy
            if (stripos($driver->getCurrentURL(), 'sorry') !== false) {
                $pass = false;
            } else {
                $exists = BrowserController::isElementExist($driver, WebDriverBy::cssSelector('input[name="q"]'));
                if ($exists) {
                    $pass = true;
                } else {
                    $pass = false;
                }
            }
        } 
        catch (TimeOutException $e) {
            $pass = false;
        } 
        catch (NoSuchElementException $expr) {
            $pass = false;
        }
         catch (WebDriverCurlException $ex) {
            $pass = false;
        } 
        catch (WebDriverException $exp) {
            $pass = false;
        }
        // close the browser
        $driver->quit();
        return $pass;
    }

    /**
     * Pass a driver that already navigated to https://bing.com
     */
    public static function checkBingPass(RemoteWebDriver &$driver)
    {
        // check if <form action="/search"> element exist
        $pass = null;

        // Check using html
        // $html = $driver->getPageSource();
        // $doc = new \DOMDocument;
        // libxml_use_internal_errors(true);
        // $doc->loadHTML($html);
        // $xpath = new \DOMXpath($doc);
        // $exists = $xpath->query('//form[@action="/search"]')->length > 0;
        // $exists = BrowserController::isElementExist($driver, WebDriverBy::cssSelector('form[action="/search"]'));

        // if ($exists) {
        //     $pass = true;
        // } else {
        //     $pass = false;
        // }

        try {
            // // fill the search box
            // $driver->findElement(WebDriverBy::cssSelector('input[name="q"]'))->sendKeys('1+1');
            // // $driver->getKeyboard()->sendKeys($keyword);
            // // // click search
            // $driver->getKeyboard()->pressKey(WebDriverKeys::ENTER);
         

            // // Wait for at most 10s and retry every 500ms if the page is not completely loaded.
            // $driver->wait(6, 200)->until(
            //     function () use ($driver) {
            //         $pageReady = $driver->executeScript('return window.document.readyState', array());

            //         return $pageReady == 'complete';
            //     },
            //     'Error page loading takes more than 10s'
            // );

            // Check if bing detect proxy          
            $exists = BrowserController::isElementExist($driver, WebDriverBy::cssSelector('input[name="q"]'));
            if ($exists) {
                $pass = true;
            } else {
                $pass = false;
            }
        
        } catch (TimeOutException $e) {
            $pass = false;
        } catch (NoSuchElementException $expr) {
            $pass = false;
        } catch (WebDriverCurlException $ex) {
            $pass = false;
        } catch (WebDriverException $exp) {
            $pass = false;
        }
     
        // close the browser
        $driver->quit();
        return $pass;
    }

    public static function isElementExist(RemoteWebDriver &$driver, WebDriverBy $by)
    {
        try {
            $exists = $driver->findElement($by)->isDisplayed();
            return $exists;
        } catch (NoSuchElementException $e) {
            return false;
        } catch (TimeOutException $ex) {
            return false;
        } catch (WebDriverCurlException $exp) {
            return false;
        }
    }

    public static function visitSiteWithProxy($proxy, $url,$timeout = 10)
    {

        // This would be the url of the host running the server-standalone.jar
        $host = 'http://' . env('BROWSER_HOST') . ':' . env('BROWSER_PORT') . '/wd/hub';
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
            '--proxy-server=' . $proxy,
            '--blink-settings=imagesEnabled=false'
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

        // set timeout to 10s after that exception with be thrown
        $driver->manage()->timeouts()->pageLoadTimeout($timeout);

        try {

         
            // navigate to the URL of the site
            $driver->get($url);  

            // // Wait for at most 10s and retry every 200ms if the page is not completely loaded.
            // $driver->wait(10, 200)->until(
            //     function () use ($driver) {
            //         $pageReady = $driver->executeScript('return window.document.readyState', array());
            //         return $pageReady == 'complete';
            //     },
            //     'Error page loading takes more than 10s'
            // );
        } catch (TimeOutException $e) {
            return $driver;
        } catch (WebDriverCurlException $ex) {
            return $driver;
        } catch (WebDriverException $exp) {
            return $driver;
        }

        return $driver;
    }

    public static function browse()
    {
        // This would be the url of the host running the server-standalone.jar
        $host = 'http://' . env('BROWSER_HOST') . ':' . env('BROWSER_PORT') . '/wd/hub';
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
