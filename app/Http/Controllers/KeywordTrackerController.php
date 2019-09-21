<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Core\PageConnector;
use Illuminate\Support\Facades\DB;


class KeywordTrackerController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    // View Method
    public function index()
    {
        return view('dashboard.keywordTracker');
    }

    public function vkeywordTrackerUsingAjax(Request $request)
    {
        if ($request->ajax()) { } else
            return "This page isn't for you ! ^_^";
    }

    private function prepareViewArray($catagory, &$json, &$response)
    {
        $array = [];

        return $array;
    }

    public function getGoogleSerps()
    {
        // General configuration
        $test_website_url = "http://www.website.com";                        // The URL, or a sub-string of it, of the indexed website. you can use a domain/hostname as well but including http:// is recommended to avoid false positives (like http://alexa.com/siteinfo/domain) !
        $test_keywords = "some keyword,another keyword";    // comma separated keywords to test the rank for
        $test_max_pages = 3;                                                             // The number of result pages to test until giving up per keyword. Each page contains up to 100 results or 10 results when using Google Instant
        $test_100_resultpage = 0;                                                    // Warning: Google ranking results will become inaccurate! Set to 1 to receive 100 instead of 10 results and reduce the amount of proxies required. Mainly useful for scraping relevant websites.
        //$test_safe_search="medium";										// {right now not supported by the script}. Google safe search configuration. Possible choices: off, medium (default), high  

        /* Local result configuration. Enter 'help' to receive a list of possible choices. use global and en for the default worldwide results in english 
        * You need to define a country as well as the language. Visit the Google domain of the specific country to see the available languages.
        * Only a correct combination of country and language will return the correct search engine result pages. */
        $test_country = "global";                                                    // Country code. "global" is default. Use "help" to receive a list of available codes. [com,us,uk,fr,de,...]
        $test_language = "en";                                                         // Language code. "EN" is default Use "help" to receive a list. Visit the local Google domain to find available langauges of that domain. [en,fr,de,...]
        $filter = 1;                                                                             // 0 for no filter (recommended for maximizing content), 1 for normal filter (recommended for accuracy)
        $force_cache = 0;                                                                    // set this to 1 if you wish to force the loading of cache files, even if the files are older than 24 hours. Set to -1 if you wish to force a new scrape.
        $load_all_ranks = 1;                                                            /* set this to 0 if you wish to stop scraping once the $test_website_url has been found in the search engine results,
																								 * if set to 1 all $test_max_pages will be downloaded. This might be useful for more detailed ranking analysis.*/
        $portal = "int"; // int or us (must match your settings, int is default)
        $show_html = 0;                                                                         // 1 means: output formated with HTML tags. 0 means output for console (recommended script usage)
        $show_all_ranks = 1;                                                            // set to 1 to display a complete list of all ranks per keyword, set to 0 to only display the ranks for the specified website
        // ***************************************************************************

        if ($show_html) $NL = "<br>\n";
        else $NL = "\n";
        if ($show_html) $HR = "<hr>\n";
        else $HR = "---------------------------------------------------------------------------------------------------\n";
        if ($show_html) $B = "<b>";
        else $B = "!";
        if ($show_html) $B_ = "</b>";
        else $B_ = "!";

        /*
        * This loop iterates through all keyword combinations
        */
        $ch = NULL;
        $rotate_ip = 0; // variable that triggers an IP rotation (normally only during keyword changes)
        $max_errors_total = 3; // abort script if there are 3 keywords that can not be scraped (something is going wrong and needs to be checked)

        $rank_data = array();
        $siterank_data = array();
        $results=array();
        $keywords = explode(",", $test_keywords);

        foreach ($keywords as $keyword) {
            $rank = 0;
            $max_errors_page = 5; // abort script if there are 5 errors in a row, that should not happen

            if ($test_max_pages <= 0) break;
            $search_string = urlencode($keyword);
            $rotate_ip = 1; // IP rotation for each new keyword

            /*
 	* This loop iterates through all result pages for the given keyword
 	*/
            for ($page = 0; $page < $test_max_pages; $page++) {
                $serp_data = load_cache($search_string, $page, $country_data, $force_cache); // load results from local cache if available for today
                $maxpages = 0;

                if (!$serp_data) {
                    $ip_ready = check_ip_usage(); // test if ip has not been used within the critical time
                    while (!$ip_ready || $rotate_ip) {
                        $ok = rotate_proxy(); // start/rotate to the IP that has not been started for the longest time, also tests if proxy connection is working
                        if ($ok != 1)
                            die("Fatal error: proxy rotation failed:$NL $ok$NL");
                        $ip_ready = check_ip_usage(); // test if ip has not been used within the critical time
                        if (!$ip_ready) die("ERROR: No fresh IPs left, try again later. $NL");
                        else {
                            $rotate_ip = 0; // ip rotated
                            break; // continue
                        }
                    }

                    delay_time(); // stop scraping based on the license size to spread scrapes best possible and avoid detection
                    global $scrape_result; // contains metainformation from the scrape_serp_google() function
                    $raw_data = scrape_serp_google($search_string, $page, $country_data); // scrape html from search engine
                    if ($scrape_result != "SCRAPE_SUCCESS") {
                        if ($max_errors_page--) {
                            echo "There was an error scraping (Code: $scrape_result), trying again .. $NL";
                            $page--;
                            continue;
                        } else {
                            $page--;
                            if ($max_errors_total--) {
                                echo "Too many errors scraping keyword $search_string (at page $page). Skipping remaining pages of keyword $search_string .. $NL";
                                break;
                            } else {
                                die("ERROR: Max keyword errors reached, something is going wrong. $NL");
                            }
                            break;
                        }
                    }
                    mark_ip_usage(); // store IP usage, this is very important to avoid detection and gray/blacklistings
                    global $process_result; // contains metainformation from the process_raw() function
                    $serp_data = process_raw_v2($raw_data, $page); // process the html and put results into $serp_data

                    if (($process_result == "PROCESS_SUCCESS_MORE") || ($process_result == "PROCESS_SUCCESS_LAST")) {
                        $result_count = count($serp_data);
                        $serp_data['page'] = $page;
                        if ($process_result != "PROCESS_SUCCESS_LAST")
                            $serp_data['lastpage'] = 1;
                        else
                            $serp_data['lastpage'] = 0;
                        $serp_data['keyword'] = $keyword;
                        $serp_data['cc'] = $country_data['cc'];
                        $serp_data['lc'] = $country_data['lc'];
                        $serp_data['result_count'] = $result_count;
                        store_cache($serp_data, $search_string, $page, $country_data); // store results into local cache	
                    }

                    if ($process_result != "PROCESS_SUCCESS_MORE")
                        break; // last page
                    if (!$load_all_ranks) {
                        for ($n = 0; $n < $result_count; $n++)
                            if (strstr($results[$n]['url'], $test_website_url)) {
                                verbose("Located $test_website_url within search results.$NL");
                                break;
                            }
                    }
                } // scrape clause

                $result_count = $serp_data['result_count'];

                for ($ref = 0; $ref < $result_count; $ref++) {
                    $rank++;
                    $rank_data[$keyword][$rank]['title'] = $serp_data[$ref]['title'];
                    $rank_data[$keyword][$rank]['url'] = $serp_data[$ref]['url'];
                    $rank_data[$keyword][$rank]['host'] = $serp_data[$ref]['host'];
                    //$rank_data[$keyword][$rank]['desc']=$serp_data['desc'']; // not really required
                    if (strstr($rank_data[$keyword][$rank]['url'], $test_website_url)) {
                        $info = array();
                        $info['rank'] = $rank;
                        $info['url'] = $rank_data[$keyword][$rank]['url'];
                        $siterank_data[$keyword][] = $info;
                    }
                }
            } // page loop
        } // keyword loop

    }
}
