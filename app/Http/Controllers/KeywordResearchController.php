<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\PageOptimization;
use App\Core\PageConnector;
use App\Core\simple_html_dom;

class KeywordResearchController extends Controller{

    /**
     * ---------------------
     * Suggestions
     * ---------------------
     * 1- Google Auto complete
     * 2- Bing
     * 3- Answer The Public https://answerthepublic.com/
     * 4- https://soovle.com/
     * 
     * ---------------------
     * Metrics
     * ---------------------
     * Get PA for first Five Competetors
     * Assign Each Competetor On-Page SEO score
     * Show BackLinks Count for Each Competetor
     * 
     * Get search volume rank from google trends
     * Calculate Keyword Diffeculty 
     * 
     * --------------------------------------
     * Get on page difficulty score from bing
     * -------------------------------------- 
     * is keyword exist in title , description , url , domain
     * title-keyword relevance score (how much chars in title after we remove keyword)
     * 
     * 
     * Get seo difficulty from bing
     * operators like allinurl, allintitle and allintext with your researched keyword and look how many results are there for your keyword:
     * total amount of results 
     * The less total results you’ll get for a keyword, the better. This especially concerns results in title. But this kind of research is utterly incomplete if you do not research the top raking pages for your researched keyword and consider important ranking factors of these pages. 
     *
     * Fill the columns as Keyword, Total Results, Results with allinurl, Results with allintitle and lastly Results with allintext. (Refer image below)
     * Now do a basic search (in incognito mode) for the keyword ‘protein rich foods’ and write the total returned results under ‘Total Results’ column in your spreadsheet.
     * Once you fill the first two column, we’re now going to use special operators to make the best use of Google as a Keyword Difficulty Tool. These special operators are

allinurl – Displays all results with keyword appearing in URL.
allintitle – Displays all results with keyword appearing in Title.
allintext – Displays all results with keyword appearing inside the article.
Search now using these special search operators one by one as shown below:
• ‘allinurl: protein rich foods’, note the number of results containing ‘protein rich foods’ in URL and enter in into the spreadsheet under ‘Results with allinurl’ column.
• ‘allintitle: protein rich foods’, note the number of results containing ‘protein rich foods’ in Title and enter it into the spreadsheet under ‘Results with allintitle’ column.
• ‘allintext: protein rich foods’, note the number of results containing ‘protein rich foods’ inside article and enter it into the spreadsheet under ‘Results with allintext’ column.
What’s the purpose of our collected data?

According to my experience, keywords with than or nearby ‘Total Results’ of 1,000,000 has good possibility for ranking on the 1st Page.
If ‘Results with allinurl’ and ‘Results with allintitle’ are less than or nearby 1000 then you have high chances of ranking on the 1st page with a 2000+ words in-depth blog post, proper image optimization, High Flesch Reading Score, Quick Load Speed, Good Social Shares, Efficient Inter Linking and several high DA, PA Backlinks.
I’d suggest to not try for a keyword where ‘Results with allintext’ is 50% more than the ‘Total Results’. In our case the percentage is 460%, so it’s better to avoid working on this keyword.



     * All keywords can be checked within US database. If there’s no data for your keyword, there’s no need to wait. As soon as the tool parses all the tops and estimates the difficulty of your keyword(s), you’ll receive a notification via email:
     * It also considers more parameters to calculate the KD more efficiently:
     * 1. # of Backlinks for each URL in top-10

2. trust flow / citation flow of domains from the top-10

3. Numer of main pages in the top-10

4. Number of domains where the exact match keyword is used in Title

5. Number of URLs where the exact match keyword is used in Title

------------------------------------

Tools like Ahrefs analyze backlinks of top domains where keword difficulty (KD) is an average value of the number of backlinks every domain in top 10 has.

The main disadvantage here is that the entire domain is analyzed instead of a specific page. Thus if some not influential and not relevant page of such trustworthy domain as Wikipedia or Amazon, e.x. is in top-10 of Google SERP, the KD for this keyword will increase.

To improve KD accuracy, Serpstat uses a more advanced method analyzing backlinks of top URLs. Of course, backlinks are the crucial ranking factor, but not the only one. That's why this method cannot be considered as a perfect so on top of this more advanced approach Sersptat also considers crucial ranking parameters of these URLs like:

Referring Domains — shows the number of domains that refer to the pages of Google top 10;
External Backlinks — the number of backlinks pointing to the pages of Google top 10;
Serpstat Page Rank — refers to the number of backlinks your site got;
Serpstat Trust Rank — refers to the number of trustworthy and quality backlinks your site got;
Domains with the keyword in title — the number of domains that contain the requested keyword in title;
URLs with the keyword in title — the number of pages that contain the requested keyword in title;
Main pages in SERP — shows how many main pages are in top-10 of SERP.

        * another technique

        *Keyword difficulty score measure the existence of the keyword in title, description, URL and content of the first 20 results in Google for each region and language.
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // View Method
    public function index()
    {
        return view('dashboard.keywordResearch');
    }



    // Endpoint
    public function check(Request $request)
    {
        $inputUrl = $request->get('u');
        $keyword = rawurldecode($request->get('k'));
        if (empty($keyword)) {
            return "Empty keyword";
        }
        $connector = new PageConnector($inputUrl);
        $connector->connectPage();
        if (!$connector->isGoodUrl) {
            return "Not Valid URL";
        }
        $connector->setIsGoodStatus();
        $connector->httpCodes;
        $connector->urlRedirects;

        $optimizer = new PageOptimization($connector->url, $keyword, $connector->parsedUrl, end($connector->httpCodes), $connector->header, $connector->doc);
        $class_methods = get_class_methods($optimizer);

        foreach ($class_methods as $method_name) {
            if ($method_name != "__construct")
                $optimizer->$method_name();
        }

        return json_encode($optimizer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    // Ajax for view
    public function viewkeywordResearchUsingAjax(Request $request)
    {
        // if ($request->ajax()) {   
            $keyword = $request->get('keyword');
            $country = $request->get('country');
            $language = $request->get('language');
            // TODO check for suggests in DB first if not proceed
            $suggests = [];
            while(empty($suggests)){
                $suggests = $this->getSoolve($keyword);
            }
            // TODO save suggest to database
            return $suggests;
        // } else
        //     return "This page isn't for you ! ^_^";
    }

    // Get soolve html from browser then parse it
    public function getSoolve($keyword){
        $html = BrowserController::getSoovleSuggests($keyword);
        $suggests = [];
        // Create a DOM object
        $dom = new simple_html_dom();
        // Load HTML from a string
        $dom->load($html);
        $ids = ['overstockcomplete','googlecomplete','yahoocomplete','livecomplete',
                'youtubecomplete','answerscomplete','wikipediacomplete'];
        // Get divs content
        foreach($ids as $id){
            $divs = $dom->find('div[id='.$id.'] div');
            foreach($divs as $item){
                $suggests[] = $item->plaintext;
            }
        }
        return $suggests;
    }
}
