<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Site;
use App\CrawlingJob;
use App\Core\PageConnector;
use Illuminate\Support\Facades\DB;
use App\Backlink;

class CrawlingController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    // View Method
    public function index()
    {
        $sites = Auth::user()->sites;
        return view('dashboard.onDemandCrawl')->with('sites', $sites);
    }

    /**
     * Delete the site and all of its stored problems
     */
    public function destroy($id)
    {
        Auth::user()->sites()->detach($id);
        return redirect(app()->getLocale() . '/dashboard/on-demand-crawl');
    }

    /**
     * recrawl the site
     */
    public function recrawl(Request $request){
        // if (!$request->ajax()) {
        //     return redirect(app()->getLocale() . '/dashboard/on-demand-crawl');
        // }

        $id = $request->get('id');
        // check if the user has an access to recrawl the site
        $firstSite = Auth::user()->sites()->where('site_id',$id)->first();
        if($firstSite !== null){
            // has access to the site
            $site = Site::findOrFail($id);
            //  set the crawling job to waiting
            $job = CrawlingJob::findOrFail($site->crawlingJob->id);
            $job->status = "Waiting";
            $job->save();

            // TODO : set the remaining pages of the user account as a limit for the crawling request

            // send recrawl request to the crawler
            $this->sendCrawlingRequest($site->host,$site->id,$site->exact_match);
            // view checks
            return $this->viewSiteCrawlUsingAjax($request, $site->host, $site->exact_match);
        }
    }

    /**
     * Currently we generate sitemaps without priorities since google doesn't use it
     */
    public function generateSitemap(Request $request){ 
        $id = $request->get('id');     
        // Check if this site is allowed to this user
        $site = Auth::user()->sites()->where('site_id',$id)->first();
        if($site === null){
            // doesn't has access to the site
            return abort(404);
        }

        // set the header of the response to instruct the browser to download the body into sitemap.xml file
        header('Content-disposition: attachment; filename="sitemap.xml"');
        header('Content-type: "text/xml"; charset="utf8"');
        // Get the maximum depth of the site
        // $max_depth = $site->urls()->where('status',200)->max('crawl_depth');
        // $levels = $max_depth+1;
        // Valid values range from 0.0 to 1.0. 
        // The default priority of a page is 0.5.
        // Valid priority values have range interval [0.0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1.0].
        // $levelsPerPriority = ceil($levels/11);
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n";
        $urls = $site->urls()->where('status',200)->orderBy('crawl_depth','asc')->get();
        foreach($urls as $url){
            $xml.="<url>\n";
            $xml.="<loc>".$url->url."</loc>\n";
            $xml.="<lastmod>".$url->created_at->format('Y-m-d')."</lastmod>\n";
            // $xml.="<priority>0.8</priority>";
            $xml.="</url>\n";
        }
        $xml .="\n</urlset>";
        // return sitemap.xml file content
        return $xml;
    }

    public function viewSiteCrawlUsingAjax(Request $request, $site = null, $exact = null){
        if (!$request->ajax()) {
            return redirect(app()->getLocale() . '/dashboard/on-demand-crawl');
        }

        // check if this call is for a recrawling request
        if ($site !== null && $exact !== null) {
            $json = $this->doSiteCrawl($request, $site, $exact);
        } else {
            $json = $this->doSiteCrawl($request);
        }
        $array = json_decode($json);
        $response = array();

        $catagories = [
            'overview', 'crawlerIssues', 'crawlerWarnings',
            'metadata', 'redirect', 'content'
        ];

        // each catagory has a localized header , its issues array and its id

        $overview = [
            __('overview'), ['crawledPages', 'externalLinks'],
            "overview"
        ];

        $crawlerIssues = [
            __('critical-crawler'), ['errors5xx', 'errors4xx', 'redirectTo4xx'],
            "crawlerIssues"
        ];

        $crawlerWarnings = [
            __('crawler-warnings'), ['metaNoindex', 'xRobotsNoIndex', 'xRobotsNoFollow', 'metaNofollow'],
            "crawlerWarnings"
        ];

        $metadata = [
            __('metadata-issues'), [
                'missingDescription', 'longTitles', 'longDescription',
                'multipleTitles', 'shortTitles', 'dynamincUrls', 'missingTitles', 'missingCanonical',
                'shortDescription', 'longUrls'
            ],
            "metadataIssues"
        ];

        $redirect = [
            __('redirect-issues'), ['temporaryRedirect', 'redirectChains', 'metaRefresh', 'headerRefresh'],
            "redirectIssues"
        ];

        $content = [
            __('content-issues'), ['duplicateContent', 'thinContent', 'missingH1', 'duplicateTitles'],
            "contentIssues"
        ];

        $response['count'] = [];
        foreach ($catagories as $index => $catagory) {
            $tempArray = $this->prepareViewArray($$catagory, $array, $response);
            if ($tempArray == null) {
                continue;
            } else {
                $response['catagories'][$index] = $tempArray;
            }
        }

        $response["url"] = $array->url;
        $response["status"] = $array->status;
        $response["pagesCount"] = $array->pagesCount;
        $response["lastCrawl"] = $array->lastCrawl;
        $response["siteId"] = $array->siteId;
        $response['count2xx'] = $array->count2xx;
        $response['count3xx'] = $array->count3xx;
        $response['count4xx'] = $array->count4xx;
        $response['count5xx'] = $array->count5xx;

        return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    private function prepareViewArray($catagory, &$json, &$response){
        $array = [];
        $array['header'] = $catagory[0];
        $array['id'] = $catagory[2];
        $array['issues'] = [];
        $issuesCount = 0;
        foreach ($catagory[1] as $issue) {
            if (!empty($json->$issue && is_array($json->$issue))) {
                $issueArray = [];
                $issueArray['title'] = $issue;
                // Tab title = loclizedTitle
                $issueArray['loclizedTitle'] = __($issue);
                $issueArray['content'] = __($issue . 'Content');

                // Translate header
                foreach (array_keys(get_object_vars($json->$issue[0])) as $key) {
                    $issueArray['header'][] = __($key);
                }

                $issueCount = 0;
                foreach ($json->$issue as $ind => $obj) {
                    foreach ($obj as $key => $value) {
                        if (in_array($key, ['url', 'src_url', 'dest_url', 'source_url', 'target_url', 'redirect1', 'redirect2'])) {
                            $issueArray['rows'][$ind][] = "<a href=\"" . $value . "\" target=\"_blank\" >" . $value . "</a>";
                        } else {
                            $issueArray['rows'][$ind][] = $value;
                        }
                    }
                    $issuesCount++;
                    $issueCount++;
                }

                if (!in_array($issue, ['crawledPages', 'externalLinks'])) {

                    $response['count'][] = [__($issue), $issueCount];
                    $array['issuesCount'] = $issuesCount;
                } else {
                    $array['issuesCount'] = 0;
                }

                $array['issues'][] = $issueArray;
            } else {
                // comment this to not add labels for non existed problems
                // $response['count'][] = [__($issue), 0];
            }
        }
        if (empty($array['issues'])) {
            return null;
        }
        return $array;
    }

    public function doSiteCrawl(Request $request, $site = null, $exact = null, $campaign_id = null){
        if ($site == null && $exact == null) {
            $site = $request->get('site');
            $exact = $request->get('exact');
        }

        if(!is_bool($exact)){
            $exactText = strtolower($exact);
            if ($exactText === "true") {
                $exact = true;
            } elseif ($exactText === "false") {
                $exact = false;
            } else {
                $exact = boolval($exactText);
            }
        }

        // validate url parameter
        $site = (stripos($site, "https://") === false && stripos($site, "http://") === false) ? "http://" . $site : $site;
        $isGoodUrl = !empty(filter_var($site, FILTER_VALIDATE_URL));

        if (!$isGoodUrl) {
            return;
        } else {
            return $this->addSite($site, $exact,$campaign_id);
        }
    }

    public function addSite($site, $exact, $campaign_id){

        $userId = Auth::user()->id; 

        // check if site data is existed
        $existedSite = Site::where('host', $site)->first();

        if ($existedSite === null) {
                       
            // Create new site
            $newSiteId = $this->createNewSite($site,$exact);
            // Add access to site's data to the user
            Auth::user()->sites()->attach($newSiteId);

            // TODO : set the remaining pages of the user account as a limit for the crawling request

            // send a request to the crawler
            $this->sendCrawlingRequest($site,$newSiteId,$exact);
 
            return $this->showChecks($newSiteId);
        } else{
            // Add access to site's data to the user
            // if this user doesn't have access to it if not return checks            
            if(Auth::user()->sites()->where('site_id',$existedSite->id)->first() === null)
                Auth::user()->sites()->attach($existedSite->id);
            return $this->showChecks($existedSite->id);
        }
    }

    /**
     * Create New site in database along with its crawling job data
     * crawling job could be accessed from the site model
     * @return Id of the new site
     */
    public function createNewSite($site,$exact){
        // Create new site

        $newSite = new Site;
        $newSite->host = $site;
        $newSite->exact_match = $exact;
        $newSite->save();

        // Add crawling job to queue

        $job = new CrawlingJob;
        $job->site_id = $newSite->id;
        $job->status = "Waiting";
        $job->node = "default";
        $job->save();
        return $newSite->id;
    }

    /**
     * This function is responsable for sending a new crawling request to the crawler endpoint
     * @return status of response
     */
    public function sendCrawlingRequest($siteUrl,$siteId,$exact,$pages = 100,$crawlers = 3){
        // Send Request to SEO-crawler server
        // For example
        // http://10.0.75.1:8888/audit?url=https://google.com/&pages=5000&crawlers=3&siteId=73&match=1
        
        $converted_exact = $exact ? 'true' : 'false';
        $requestUrl = 'http://' . env('SEO_CRAWLER_HOST') . ':' . env('SEO_CRAWLER_PORT') . '/audit?url=' . $siteUrl . '&pages='.$pages.'&crawlers='.$crawlers.'&siteId=' . $siteId . '&match=' . $converted_exact;
        $connector = new PageConnector($requestUrl);
        $connector->connectPage();
        $connector->setIsGoodStatus();
        return $connector->isGoodStatus;
    }

    private function showChecks($siteId){
        // prepare readable checks for user in json 
        $site = Site::find($siteId);

        // prepare the result array
        $result = [];

        // Crawling Status
        $status = $site->crawlingJob->status;
        $result['status'] = __($status);
        $result['url'] = $site->host;
        $result['lastCrawl'] = $site->crawlingJob->finished_at;
        $result['siteId'] = $siteId;
        $urls = DB::select('select url ,status , crawl_depth from urls where site_id = ?', [$siteId]);

        $pagesCrawled = count((array) $urls);
        $result['pagesCount'] = $pagesCrawled;

        $urls2xxCount = $urls3xxCount = $urls4xxCount = $urls5xxCount = 0;
        foreach ($urls as $key => &$url) {
            if ($url->status > 199 && $url->status < 300) {
                $urls2xxCount++;
            } elseif ($url->status > 299 && $url->status < 400) {
                $urls3xxCount++;
            } elseif ($url->status > 399 && $url->status < 500) {
                $urls4xxCount++;
            } elseif ($url->status > 499 && $url->status < 600) {
                $urls5xxCount++;
            }
        }
        // unset url so it doesn't point to the last element of array
        unset($url);

        $result['count2xx'] = $urls2xxCount;
        $result['count3xx'] = $urls3xxCount;
        $result['count4xx'] = $urls4xxCount;
        $result['count5xx'] = $urls5xxCount;

        $result['crawledPages'] = $urls;

        $external_links = DB::select('select * from backlinks where source_url like ?', ['%' . $site->host . '%']);
        foreach ($external_links as $link) {
            $link->anchor_text = htmlspecialchars($link->anchor_text);
        }
        $result['externalLinks'] = $external_links;

        // URL Too long
        // We recommend keeping URLs under 75 characters.
        /**
         * Your page URL is too long. Learn more about URL issues.


Why and How to Fix

Why it's an issue:
URLs describe a site or page to visitors and search engines. Keeping them relevant, compelling, and accurate is the key to ranking well. Our crawler is programmed to flag any URLs longer than 75 characters as an issue.

How to fix it:

Rand says:“Choose shorter, human-readable URLs with descriptive keywords. We recommend keeping URLs under 75 characters. When possible, place content on the same subdomain to preserve authority. Optimal format: http://www.example.com/category-keyword/subcategory-keyword/primary-keyword.html.”
         */

        $urlsProblems =  DB::select('select urls.url,title, LENGTH(urls.url) ,crawl_depth from urls INNER JOIN titles ON titles.url = urls.url where urls.site_id  = ' . $siteId . ' AND LENGTH(urls.url) > 75 AND urls.status = 200 ');
        $result['longUrls'] = $urlsProblems;

        // Missing Description
        /**
         * Meta descriptions provide the content or snippet that appears directly below the title tag on the SERP, and also appear on social media sites when your page URL is shared. Learn more about meta descriptions.


Why and How to Fix

Why it's an issue:
Meta descriptions are a very important factor in improving click-through rates on SERPs. In the absence of a meta description, social media platforms and search engines will pull in the first matching text they find on page, which may not be interesting for users. If it's too long or doesn't relate to what the searcher is looking for, you may be missing a traffic-driving opportunity.

How to fix it:

Britney says:“The meta description should employ keywords in an intelligent and compelling way that encourages a searcher to click. Optimally, the length of your description should be 55-300 characters.”
         */

        $missingDescription =  DB::select("select DISTINCT descriptions.url,titles.title,crawl_depth from urls INNER JOIN descriptions ON descriptions.url = urls.url INNER JOIN titles ON  titles.url = descriptions.url where  urls.site_id =  " . $siteId . " AND descriptions.description ='' AND urls.status = 200");
        $result['missingDescription'] = $missingDescription;

        // duplicate content
        /**
         * When the code and content on a page looks too similar or is identical to the code and content on another page or pages of your site, it will be flagged as "Duplicate Page Content". Our crawler will flag any pages with 90% or more overlapping content or code, as having duplicate content. Learn more about duplicate page content.


Why and How to Fix

Why it's an issue:
Search engines may not know which pages are best to include in their index and which to prioritize in rankings. This may lead to a decrease in traffic or even cause your page to be filtered out of search results.

How to fix it:

Brian says:“There are a few different ways you can fix this issue when simply changing the content is not an option: Consider adding 301 redirects to direct duplicate pages to the one you want people to visit, adding the rel=canonical tag to your canonical (most authoritative) page, or by using the Parameter Handling Tool in Google Search Console.”
         */

        $duplicates = DB::select("select similarities.src_url,similarities.dest_url,titles.title,crawl_depth,similarities.percent *100 as percent from urls INNER JOIN similarities ON src_url = urls.url INNER JOIN titles  ON titles.url = src_url where urls.site_id =  " . $siteId . " AND similarities.percent >= 0.87");
        $result['duplicateContent'] = $duplicates;

        //  Title Too Long
        // Title tags should be no longer than 570 pixels.
        /**
         * Your title tag is longer than 570 pixels. Title tags appear on the SERP as a preview of your page content; they help searchers understand quickly if your page is relevant to their search. Learn more about title issues.


Why and How to Fix

Why it's an issue:
If your title is too long, it will not display properly and may limit your ability to attract customers to your site. Google typically displays the first 50-60 characters of a page title depending on the width of the characters. The display actually maxes out at 600 pixels and indicates an ellipsis ("...") if the title is too long to fit in its entirety. We've taken those factors into account and set the maximum pixel threshold that triggers this issue at 570 in order to err on the safe side and help you create titles that are sure to show up the way you intend them to.

How to fix it:

Brian says:“We recommend limiting your title to between 10 and 60 characters or modifying the characters selected to keep it under 570 pixels. (Example: use less "W"s and more "i"s or "l"s) This should ensure customers see your full title on the SERP, in the browser tab, and in social channels.”
         */

        $longTitles = DB::select("select titles.url,titles.title,LENGTH(titles.title),crawl_depth from urls INNER JOIN titles ON titles.url = urls.url where LENGTH(titles.title) > 60 AND urls.site_id =  " . $siteId);
        $result['longTitles'] = $longTitles;

        // Redirect Chain
        /**
         * Your page is redirecting to a page that is redirecting to a page that is redirecting to a page... and so on. Learn more about redirection best practices.


Why and How to Fix

Why it's an issue:
Every redirect hop loses link equity and offers a poor user experience, which will negatively impact your rankings.

How to fix it:

Chiaryn says:“Redirect chains are often caused when multiple redirect rules pile up, such as redirecting a 'www' to non-www URL or a non-secure page to a secure/https: page. Look for any recurring chains that could be rewritten as a single rule. Be particularly careful with 301/302 chains in any combination, as the 302 in the mix could disrupt the ability of the 301 to pass link equity.”
         */

        $redirectChains = DB::select("select  a.url as url , a.redirect as redirect1 ,b.redirect as redirect2 from redirects a INNER JOIN redirects b ON b.url = a.redirect INNER JOIN urls ON a.url = urls.url where urls.site_id =  " . $siteId . " AND urls.status != 200");
        $result['redirectChains'] = $redirectChains;

        // Description Too Long

        /**
         * Your meta description is too long. The meta description provides the content that appears directly below the title tag on the SERP and encourages searchers to click. Learn more about meta descriptions.


Why and How to Fix

Why it's an issue:
When your meta description is too long, it may get cut off by search engines and your click-through-rate could suffer.

How to fix it:

Britney says:“Reduce the length of your meta description. The ideal length is 55-300 characters.”
         */

        $longDescription =  DB::select("select descriptions.url,titles.title, descriptions.description,LENGTH(descriptions.description),crawl_depth from urls INNER JOIN descriptions ON descriptions.url = urls.url INNER JOIN titles ON  titles.url = descriptions.url where  urls.site_id =  " . $siteId . " AND LENGTH(descriptions.description) > 300");
        $result['longDescription'] = $longDescription;

        // Missing H1 
        /**
         * Your page either is missing a headline or H1 (header tag).


Why and How to Fix

Why it's an issue:
Header tags help search engines and searchers quickly determine what your page is about. When search results are clicked on, the searcher expects to see a closely matching headline on the page they visit. Adding an H1 may decrease bounce-rate and improve rankings.

How to fix it:

Britney says:“Try to use at least one topically relevant H1 tag on every content page.”
         */

        $missingH1 = DB::select("select contents.url ,titles.title , urls.crawl_depth from contents INNER JOIN urls ON contents.url = urls.url INNER JOIN titles ON contents.url = titles.url where contents.is_h1_exist = false AND urls.site_id = " . $siteId);
        $result['missingH1'] = $missingH1;

        //  Multiple Titles
        /**
         * This means our crawler is finding more than one title tag on your page.

You can verify this by checking your source code for multiple sets of title tags identified with <title> It is recommended that you remove the additional title tag as having multiple titles may confuse crawlers.
         */

        $multipleTitles = DB::select("select a.url , a.title as title1 , b.title as title2 ,crawl_depth from titles a INNER JOIN titles b ON a.url = b.url INNER JOIN urls ON a.url = urls.url where a.title != b.title AND urls.site_id = " . $siteId);
        $result['multipleTitles'] = $multipleTitles;

        //  Title Too Short
        /**
         * Your title tag is too short. Title tags appear on the SERP as a preview of your page content; they help searchers understand quickly if your page is relevant to their search.
            Usually the issue of short title arises when you have titles lesser then 25 characters including spaces. 
Google typically displays the first 50-60 characters of your title tag. Write title tags that use these characters efficiently to ensure that search engines don't automatically generate a title for your page, which may not provide the same incentive to click as a custom-written tag.
         */


        $shortTitles = DB::select("select titles.url , titles.title , LENGTH(titles.title) ,crawl_depth from titles INNER JOIN urls ON urls.url = titles.url where LENGTH(titles.title) < 25 AND LENGTH(titles.title) > 0 AND urls.site_id = " . $siteId);
        $result['shortTitles'] = $shortTitles;

        // Thin content
        /**
         * Your page is considered to have "thin content" if it has less than 50 words
         */

        $thinContent =  DB::select("select contents.url ,titles.title , urls.crawl_depth , content_length from contents INNER JOIN urls ON contents.url = urls.url INNER JOIN titles ON contents.url = titles.url where content_length < 50 AND urls.site_id = " . $siteId);
        $result['thinContent'] = $thinContent;


        // Temporary Redirect
        /**
         * A 302 or 307 redirect is a way to temporarily send both users and search engines to a different URL from the one they originally requested. By using a temporary vs. a permanent redirect (301), you are suggesting that search engines shouldn't consider this a lasting change.

Consider replacing your temporary redirect with a permanent 301 redirect, which passes 90-99% of link equity (ranking power) to the target page. In most instances, a 301 redirect is the best strategy for implementing redirects on a website.
         */

        $temporaryRedirect = DB::select("select redirects.url , redirects.redirect, urls.status ,crawl_depth from redirects INNER JOIN urls ON urls.url = redirects.url where urls.site_id =  " . $siteId . " AND (urls.status = 302 OR urls.status = 307)");
        $result['temporaryRedirect'] = $temporaryRedirect;


        // Redirect to 4xx

        /**
         * A Redirect to 4xx means that there is a page on your site that is being redirected to a page that’s not accessible. This can affect your visitors experience and can reduce crawler efficiency.

To find 4xx Errors in Moz Pro Site Crawl head to Site Crawl > Critical Crawler Issues > Redirect to 4xx.

Start by looking at high authority pages, or pages with a lower crawl depth
Click on the headers in Moz Pro to sort the pages
Select the dropdown under Preview to view the associated pages
There are a few different options for fixing Redirect to 404 issues depending on the reason for the error. You may want to do the following:

Change the redirect the point to an active and relevant resource
Fix the 404 issue using the steps above
Once you've fixed this issue through your website CMS you can mark it as Fixed in Moz Pro and we'll check back next time we crawl.


         */

        $redirectTo4xx = DB::select("select redirects.url , redirects.redirect, urls.status , urls.crawl_depth  from redirects INNER JOIN urls ON urls.url = redirects.redirect where urls.site_id =  " . $siteId . " AND urls.status >= 400 AND urls.status < 500");
        $result['redirectTo4xx'] = $redirectTo4xx;


        // Overly Dynamic URL

        $dynamincURLs = DB::select("select contents.url, contents.url_query, crawl_depth ,titles.title from contents INNER JOIN urls ON urls.url = contents.url INNER JOIN titles ON titles.url = urls.url where urls.site_id =  " . $siteId . " AND contents.url_query != ''");
        foreach ($dynamincURLs as $key => &$url) {
            if (substr_count($url->url_query, '&') == 0) {
                unset($dynamincURLs[$key]);
            }
        }
        // unset url so it doesn't point to the last element of array
        unset($url);

        $result['dynamincUrls'] = $dynamincURLs;

        // Missing Title

        /**
         * Title tags appear on the SERP as a preview of your page content and may encourage searchers to click if the title is relevant to their search. Title tag elements are used by search engines to identify keywords and associate the page with a topic.

To add or edit a title, open the page in question in your HTML editor. Then find the title tag. When you are done creating a new page title it should look something like this:

<title>SEOar: Inbound Marketing and SEO Software, Made Easy</title>
         */

        $missingTitles = DB::select("select titles.url, urls.status , urls.crawl_depth from titles INNER JOIN urls ON urls.url = titles.url where urls.site_id =  " . $siteId . " AND titles.title = ''");
        $result['missingTitles'] = $missingTitles;

        // Missing Canonical Tag

        /**
         * The canonical tag should be located in the HTML head of your web pages. It tells search engines that a given page should be treated as though it were a copy of the intended URL and that all of the links and content metrics should actually be directed toward the provided URL.

We advise that each page have a canonical tag, even if it's self referring, just to prevent any possible duplicate content issues. That being said, implementing canonical tags for every page may not be part of your SEO strategy in which case you can ignore these issues in your Crawl Data so they won’t continue to flag them with each new crawl.
         */

        $missingCanonical = DB::select("select contents.url, crawl_depth ,titles.title from contents INNER JOIN urls ON urls.url = contents.url INNER JOIN titles ON titles.url = urls.url where urls.site_id =  " . $siteId . " AND contents.is_canonical_exist = false");
        $result['missingCanonical'] = $missingCanonical;

        // 5xx Error
        $errors5xx = DB::select("select urls.url , urls.status ,urls.crawl_depth from urls where urls.site_id =  " . $siteId . " AND (urls.status >= 500 AND urls.status < 600)");
        $result['errors5xx'] = $errors5xx;

        // 4xx Error
        $errors4xx = DB::select("select urls.url , urls.status ,urls.crawl_depth from urls where urls.site_id =  " . $siteId . " AND (urls.status >= 400 AND urls.status < 500)");
        $result['errors4xx'] = $errors4xx;

        // X-Robots Noindex
        /**
         * This tells search engines not to index your page, which prevents your page from being found in search engines. Depending on your page or circumstance, this may not be an issue that needs fixing.

If you determine that the links on this page should be indexed, remove “X-Robots-Tag: noindex” from your HTTP header. This can also appear as: “X-Robots-Tag: googlebot: noindex,” or “X-Robots-Tag: otherbot: noindex, nofollow.”
         */
        $xRobotsNoIndex = DB::select("select robots.url , titles.title, urls.status ,urls.crawl_depth from robots INNER JOIN urls ON urls.url = robots.url INNER JOIN titles ON titles.url = urls.url where urls.site_id =  " . $siteId . " AND robots.type = 'xRobots' AND (robots.content = 'noindex' OR robots.content = 'none')");
        $result['xRobotsNoIndex'] = $xRobotsNoIndex;

        // X-Robots Nofollow
        $xRobotsNoFollow = DB::select("select robots.url , titles.title, urls.status ,urls.crawl_depth from robots INNER JOIN urls ON urls.url = robots.url INNER JOIN titles ON titles.url = urls.url where urls.site_id =  " . $siteId . " AND robots.type = 'xRobots' AND (robots.content = 'nofollow' OR robots.content = 'none')");
        $result['xRobotsNoFollow'] = $xRobotsNoFollow;

        // Meta Refresh
        $metaRefresh = DB::select("select refreshes.url , refreshes.content , titles.title, urls.status ,urls.crawl_depth from refreshes INNER JOIN urls ON urls.url = refreshes.url INNER JOIN titles ON titles.url = urls.url where urls.site_id =  " . $siteId . " AND refreshes.type = 'MetaRefresh' ");
        $result['metaRefresh'] = $metaRefresh;

        // Header Refresh
        $headerRefresh = DB::select("select refreshes.url , refreshes.content,  titles.title, urls.status ,urls.crawl_depth from refreshes INNER JOIN urls ON urls.url = refreshes.url INNER JOIN titles ON titles.url = urls.url where urls.site_id =  " . $siteId . " AND refreshes.type = 'headerRefresh' ");
        $result['headerRefresh'] = $headerRefresh;

        // Meta Noindex
        $metaNoindex = DB::select("select robots.url , titles.title, urls.status ,urls.crawl_depth from robots INNER JOIN urls ON urls.url = robots.url INNER JOIN titles ON titles.url = urls.url where urls.site_id =  " . $siteId . " AND robots.type = 'metaTag' AND (robots.content = 'noindex'  OR  robots.content = 'none')");
        $result['metaNoindex'] = $metaNoindex;

        // Meta Nofollow
        $metaNofollow = DB::select("select robots.url , titles.title, urls.status ,urls.crawl_depth from robots INNER JOIN urls ON urls.url = robots.url INNER JOIN titles ON titles.url = urls.url where urls.site_id =  " . $siteId . " AND robots.type = 'metaTag' AND (robots.content = 'nofollow' OR  robots.content = 'none')");
        $result['metaNofollow'] = $metaNofollow;

        // Duplicate Titles
        $duplicateTitles = DB::select("select a.url as src_url , a.title as src_title, b.url as dest_url , b.title as dest_title ,urls.crawl_depth from titles a INNER JOIN titles b ON a.title = b.title AND a.url < b.url INNER JOIN urls ON urls.url = a.url where urls.site_id =  " . $siteId);
        $result['duplicateTitles'] = $duplicateTitles;

        // Description Too Short
        $shortDescription =  DB::select("select descriptions.url,titles.title, LENGTH(descriptions.description) ,crawl_depth from urls INNER JOIN descriptions ON descriptions.url = urls.url INNER JOIN titles ON  titles.url = descriptions.url where  urls.site_id =  ".$siteId." AND LENGTH(descriptions.description) < 55 AND LENGTH(descriptions.description) > 0");
        $result['shortDescription'] = $shortDescription;

        return json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    // public function distributeJobs(){
    //     // distrbute Crawling jobs to nodes 
    //     // Premature Optimization Is the Root of All Evil
    //     // Use load balancer instead
    // }
}
