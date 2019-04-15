<?php

namespace App\Core;

require 'vendor/autoload.php';

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * 
 **/

// require './PageConnector.php';
// $keyword = "شركة تصميم مواقع";
// $connector = new PageConnector("https://is.net.sa");
// $connector->connectPage();
// if (!$connector->isGoodUrl) {
//     return "Not Valid URL";
// }
// $connector->setIsGoodStatus();

// $optimizer = new PageOptimization($connector->url, $keyword, $connector->parsedUrl, end($connector->httpCodes), $connector->header, $connector->doc);
// $class_methods = get_class_methods($optimizer);

// foreach ($class_methods as $method_name) {
//     if ($method_name != "__construct")
//         $optimizer->$method_name();
// }
// var_dump(get_object_vars($optimizer));


class PageOptimization
{

    // Page URL
    public $url;

    private $parsedUrl;

    private $httpCode;

    private $header;

    private $doc;

    private $keyword;

    //Page Title
    public $pageTitle;

    //Page Description
    public $pageDescription;

    //Page Score
    public $score;

    //How many the keyword is found in the page
    public $keywordFound;

    //How many the keyword is found in the title
    public $keywordInTitleCount;

    //How many the keyword is found in the Body Tag
    public $keywordInBodyCount;

    //How many the keyword is found in the description meta Tag
    public $keywordInDescriptionCount;

    //How many the keyword is found in the URL
    public $keywordInUrlCount;

    //How many the keyword is found in IMG Alt attribute
    public $keywordInImgAltCount;

    //Accessible to Search Engines
    public $isAccessible;

    //Avoid Keyword Stuffing in Page Title
    public $isNotKeywordStuffTitle;

    //Avoid Multiple Page Title Elements
    public $isSingleTitle;

    //Only One Canonical URL
    public $isOneCanonical;

    //Broad Keyword Use in Page Title
    public $isBroadKeywordTitle;

    //Optimal Page Title Length
    public $isGoodTitleLength;

    //Exact Keyword is Used in Page Title
    public $isKeywordInTitle;

    //Exact Keyword Used in Document at Least Once
    public $isExactKeywordInDoc;

    //Avoid Keyword Stuffing in Document
    public $isNotKeywordStuffDoc;

    //Sufficient Characters in Content
    public $isSufficientCharInContent;

    //Sufficient Words in Content
    public $isSufficientWordsInContent;

    //Use Keywords in your URL
    public $isKeywordInUrl;

    //Optimal Use of Keywords in Header Tags
    public $isGoodKeywordInHeader;

    //Keywords in Image Alt Attribute
    public $isKeywordInAlt;

    //Avoid Too Many External Links
    public $isNotManyExternal;

    //Avoid Too Many Internal Links
    public $isNotManyInternal;

    //Use Static URLs
    public $isStaticUrl;

    //URL Uses Only Standard Characters
    public $useStandardChar;

    //Avoid Keyword Stuffing in the URL
    public $isNotKeywordStuffUrl;

    //Minimize URL Length
    public $isGoodUrlLength;

    //Use Meta Descriptions
    public $isUseDescription;

    //Keywords in the Meta Description
    public $isKeywordInDescription;

    //Use External Links
    public $isUseExternal;

    //Only One Meta Description
    public $isOneDescription;

    //Optimal Meta Description Length
    public $isGoodDescriptionLength;

    //Includes a Rel Canonical Tag
    public $isUseCanonical;

    function __construct($url, $keyword, $parsedUrl, $httpCode, $header, $body)
    {
        $this->url = $url;
        $this->keyword = $keyword;
        $this->parsedUrl = $parsedUrl;
        $this->httpCode =  $httpCode;
        $this->header = $header;
        $this->doc = $body;
    }

    private function makeConnection($url)
    {
        // Use Curl to send off your request.
        $options = array(
            CURLOPT_RETURNTRANSFER => true
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        curl_close($ch);
        if ($content === false)
            return false;
        else
            return $content;
    }

    private function getRobots()
    {
        if (isset($this->parsedUrl["scheme"]) && isset($this->parsedUrl["host"])) {
            $robotsUrl = $this->parsedUrl["scheme"] . '://' . $this->parsedUrl["host"] . '/robots.txt';
            return $this->makeConnection($robotsUrl);
        }
        return false;
    }

    private function isAllowedFromRobots()
    {
        $robotsContent = $this->getRobots();
        if ($robotsContent) {
            $parser = new \RobotsTxtParser($robotsContent);
            $agents = ['*', 'Googlebot', 'Bingbot', 'Slurp', 'DuckDuckBot', 'Baiduspider', 'YandexBot'];
            $pathToPage = isset($this->parsedUrl["path"]) ? $this->parsedUrl["path"] : '/';
            foreach ($agents as $agent) {
                $parser->setUserAgent($agent);
                if ($parser->isDisallowed($pathToPage)) {
                    return false;
                }
            }
            return true;
        } else
            return true;
    }

    private function isAllowedFromPage()
    {
        if (isset($this->header['X-Robots-Tag'])) {
            foreach ($this->header['X-Robots-Tag'] as $value) {
                if (stripos($value, 'noindex') !== false || stripos($value, 'none') !== false) {
                    return false;
                }
            }
        }
        if (isset($this->header['Refresh'])) {
            foreach ($this->header['Refresh'] as $value) {
                if (stripos($value, 'url=') !== false) {
                    return false;
                }
            }
        }
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->doc);
        libxml_use_internal_errors(false);
        $metas = $doc->getElementsByTagName('head')->item(0)->getElementsByTagName('meta');
        foreach ($metas as $meta) {
            if ($meta->getAttribute('name') == "robots") {
                $content = $meta->getAttribute('content');
                if (stripos($content, 'noindex') !== false || stripos($content, 'none') !== false) {
                    return false;
                }
            }
            if ($meta->getAttribute('http-equiv') == "refresh") {
                $content = $meta->getAttribute('content');
                if (!empty($content)) {
                    return false;
                }
            }
        }
        $links = $doc->getElementsByTagName('head')->item(0)->getElementsByTagName('link');
        $pathOfUrl =  isset($this->parsedUrl["path"]) ? $this->parsedUrl["path"] : '/';
        foreach ($links as $link) {
            if ($link->getAttribute('rel') == "canonical") {
                $href = $link->getAttribute('href');
                $pathOfCanonical = parse_url($href, PHP_URL_PATH);
                if ($pathOfCanonical !== $pathOfUrl) {
                    return false;
                }
            }
        }
        return true;
    }

    public function setAccessibilityChecks()
    {
        $this->isAccessible = ($this->httpCode == 200) && $this->isAllowedFromRobots() && $this->isAllowedFromPage();
    }

    public function setCanonicalChecks()
    {
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->doc);
        libxml_use_internal_errors(false);
        $links = $doc->getElementsByTagName('head')->item(0)->getElementsByTagName('link');
        $canonicalCount = 0;
        foreach ($links as $link) {
            if ($link->getAttribute('rel') == "canonical") {
                $canonicalCount++;
            }
        }
        $this->isOneCanonical = $canonicalCount == 1;
        $this->isUseCanonical = $canonicalCount > 0;
    }

    public function setTitleChecks()
    {
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->doc);
        libxml_use_internal_errors(false);
        $titles = $doc->getElementsByTagName('head')->item(0)->getElementsByTagName('title');
        $firstTitle = $titles->item(0)->nodeValue;
        $this->pageTitle = $firstTitle;
        $this->keywordInTitleCount = substr_count(strtolower($firstTitle), strtolower($this->keyword));
        $this->isNotKeywordStuffTitle = $this->keywordInTitleCount <= 2;
        $this->isSingleTitle =  $titles->length == 1;
        $this->isBroadKeywordTitle = stripos($firstTitle, $this->keyword) === 0;
        $this->isGoodTitleLength = mb_strlen($firstTitle, 'utf8') <= 60;
        $this->isKeywordInTitle = stripos($firstTitle, $this->keyword) !== false;
    }

    public function setContentChecks()
    {
        $countOfKeywordInDoc = substr_count(strtolower($this->doc), strtolower($this->keyword));
        $this->keywordInBodyCount = $countOfKeywordInDoc;
        $this->isExactKeywordInDoc = $countOfKeywordInDoc > 1;
        $this->isNotKeywordStuffDoc = $countOfKeywordInDoc <= 15;
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->doc);
        libxml_use_internal_errors(false);
        $body = $doc->getElementsByTagName('body')->item(0)->nodeValue;
        $countOfBodyNoSpaces =  mb_strlen($body, 'utf8') - substr_count($body, ' ');
        $this->isSufficientCharInContent = $countOfBodyNoSpaces >= 300;
        $word_count = str_word_count($body, 0);
        $this->isSufficientWordsInContent = $word_count >= 50;
    }

    public function setUrlChecks()
    {
        $this->keywordInUrlCount = substr_count(strtolower($this->url), strtolower($this->keyword));
        $this->isKeywordInUrl = stripos( $this->url ,$this->keyword) !== false;
        $this->isStaticUrl = empty($this->parsedUrl["query"]);
        preg_match_all("/([^a-zA-Z\d\s,!.#+-:&])+/", $this->url, $output_array);
        $this->useStandardChar = empty($output_array[0]);
        $this->isNotKeywordStuffUrl = $this->keywordInUrlCount <= 1;
        $path = isset($this->parsedUrl["path"]) ? $this->parsedUrl["path"] : '/';
        $formattedPath = rtrim($path, '/');
        $folder_depth = substr_count($formattedPath, "/");
        $this->isGoodUrlLength = mb_strlen($this->url, 'utf8') < 75 && $folder_depth < 4;
    }

    public function setHeaderChecks()
    {
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->doc);
        libxml_use_internal_errors(false);
        $heading1 = $doc->getElementsByTagName('body')->item(0)->getElementsByTagName('h1');
        if ($heading1->length != 0) {
            $countOfUse = 0;
            foreach ($heading1 as $tag) {
                if (stripos($tag->nodeValue, $this->keyword) === 0) {
                    $countOfUse++;
                }
            }
            $this->isGoodKeywordInHeader =  $countOfUse > 0 && $countOfUse < 3;
        } else {
            $this->isGoodKeywordInHeader = false;
        }
    }

    public function setImagesChecks()
    {
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->doc);
        libxml_use_internal_errors(false);
        $imageElements = $doc->getElementsByTagName('body')->item(0)->getElementsByTagName('img');
        $this->isKeywordInAlt = false;
        $this->keywordInImgAltCount = 0;
        if ($imageElements->length != 0) {
            foreach ($imageElements as $tag) {
                if (stripos($tag->getAttribute('alt'), $this->keyword) !== false) {
                    $this->isKeywordInAlt = true;
                    $this->keywordInImgAltCount++;
                }
            }
        }
    }

    public function setDescriptionChecks()
    {

        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->doc);
        libxml_use_internal_errors(false);
        $metas = $doc->getElementsByTagName('head')->item(0)->getElementsByTagName('meta');
        $descriptionCount = 0;
        $description = '';
        foreach ($metas as $meta) {
            if ($meta->getAttribute('name') == "description") {
                $descriptionCount++;
                if ($descriptionCount == 1) {
                    $description = $meta->getAttribute('content');
                }
            }
        }
        $this->pageDescription = $description;
        $this->isUseDescription = $descriptionCount != 0 && !empty($description);
        $keywordCountInDescription = substr_count(strtolower($description), strtolower($this->keyword));
        $this->keywordInDescriptionCount = $keywordCountInDescription;
        $this->isKeywordInDescription = $keywordCountInDescription > 0 && $keywordCountInDescription < 4;
        $this->isOneDescription = $descriptionCount == 1;
        $descriptionLength = mb_strlen($description, 'utf8');
        $this->isGoodDescriptionLength = $descriptionLength > 54 && $descriptionLength < 300;
    }

    private function isExternal($url, $host)
    {
        $site = parse_url($url, PHP_URL_HOST);
        // we will treat url like '/relative.php' as relative
        if (empty($site)) return false;
        // url host looks exactly like the local host
        if (strcasecmp($site, $host) === 0) return false;
        // check if the url host is a subdomain
        return strrpos(strtolower($site), '.' . $host) !== strlen($site) - strlen('.' . $host);
    }

    public function setLinksChecks()
    {
        $doc = new \DOMDocument();
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->doc);
        libxml_use_internal_errors(false);
        $ahrefs = $doc->getElementsByTagName('body')->item(0)->getElementsByTagName('a');
        if ($ahrefs->length != 0 && isset($this->parsedUrl["host"])) {
            $host = $this->parsedUrl["host"];
            $externals = 0;
            foreach ($ahrefs as $ahref) {
                if ($this->isExternal($ahref->getAttribute('href'), $host)) {
                    $externals++;
                }
            }
            $internals = $ahrefs->length - $externals;
            $this->isNotManyExternal = $externals < 100;
            $this->isUseExternal = $externals > 0;
            $this->isNotManyInternal = $internals < 100;
        }
    }

    public function countKeywords()
    {
        $this->keywordFound = $this->keywordInBodyCount + $this->keywordInDescriptionCount + $this->keywordInImgAltCount + $this->keywordInTitleCount + $this->keywordInUrlCount;
    }

    public function calculateScore()
    {
        $scoreChunk = 100 / 26;
        $score = 0;
        foreach ($this as $check) {
            if (gettype($check) == "boolean" && $check) {
                $score += $scoreChunk;
            }
        }
        $this->score = round($score);
    }
}