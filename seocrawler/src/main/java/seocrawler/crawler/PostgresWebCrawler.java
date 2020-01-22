package seocrawler.crawler;

import edu.uci.ics.crawler4j.crawler.Page;
import edu.uci.ics.crawler4j.crawler.WebCrawler;
import edu.uci.ics.crawler4j.parser.HtmlParseData;
import edu.uci.ics.crawler4j.url.WebURL;
import org.apache.http.Header;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;
import org.slf4j.Logger;
import seocrawler.SampleLauncher;
import seocrawler.db.PostgresDBService;

import java.io.UnsupportedEncodingException;
import java.net.MalformedURLException;
import java.net.URL;
import java.net.URLDecoder;
import java.util.regex.Pattern;

public class PostgresWebCrawler extends WebCrawler {
    private static final Logger logger = org.slf4j.LoggerFactory.getLogger(PostgresWebCrawler.class);

    private static Pattern FILE_ENDING_EXCLUSION_PATTERN = Pattern.compile(".*(\\.(" +
            "css|js" +
            "|bmp|gif|jpe?g|JPE?G|png|tiff?|ico|nef|raw" +
            "|mid|mp2|mp3|mp4|wav|wma|flv|mpe?g" +
            "|avi|mov|mpeg|ram|m4v|wmv|rm|smil" +
            "|pdf|doc|docx|pub|xls|xlsx|vsd|ppt|pptx" +
            "|swf" +
            "|zip|rar|gz|bz2|7z|bin" +
            "|xml|txt|java|c|cpp|exe" +
            "))$");


    private final PostgresDBService postgresDBService;

    public PostgresWebCrawler(PostgresDBService postgresDBService) {
        this.postgresDBService = postgresDBService;
    }

    @Override
    public boolean shouldVisit(Page referringPage, WebURL url) {
        String href = url.getURL().toLowerCase();
        if(SampleLauncher.exactMatch) {
            return !FILE_ENDING_EXCLUSION_PATTERN.matcher(href).matches() && href.startsWith(SampleLauncher.matchPattern);
        }else
            return !FILE_ENDING_EXCLUSION_PATTERN.matcher(href).matches() && url.getDomain().equalsIgnoreCase(SampleLauncher.matchPattern);
    }

    /**
     * This function is called if the crawler encounters a page with a 3xx
     * status code
     *
     * @param page Partial page object
     */
    @Override
    public void onRedirectedStatusCode(Page page) {

        // decode Url
        String url;

        try {
            url = URLDecoder.decode(page.getWebURL().getURL(), "UTF-8");
        } catch (UnsupportedEncodingException e) {
            url = page.getWebURL().getURL();
            logger.error("Decoding url in onRedirectedStatusCode() failed", e);
        }

        // remove trailing slash
        if (url.endsWith("/")) {
            url = url.substring(0, url.length() - 1);
        }
        
        // remove old url
        try {
            postgresDBService.removeUrl(url);
        } catch (RuntimeException e) {
            logger.error("removing url in onRedirectedStatusCode() failed", e);
        }

        // store url
        try {
            postgresDBService.storeUrl(url,page.getStatusCode(), SampleLauncher.siteId , (int) page.getWebURL().getDepth());
        } catch (RuntimeException e) {
            logger.error("Storing url in onRedirectedStatusCode() failed", e);
        }

        // store redirect
        try {
            postgresDBService.storeRedirect(url,URLDecoder.decode(page.getRedirectedToUrl(), "UTF-8"));
        } catch (RuntimeException e) {
            logger.error("Storing redirect in onRedirectedStatusCode() failed", e);
        } catch (UnsupportedEncodingException e) {
            logger.error("Decoding getRedirectedToUrl in onRedirectedStatusCode() failed", e);
        }
        
        /*
        Temporary Redirect Problems
        Using HTTP header refreshes, 302, 303 or 307 redirects will cause search engine crawlers
        to treat the redirect as temporary and not pass any link juice (ranking power).
        We highly recommend that you replace temporary redirects with 301 redirects.
        handlePageStatusCode() and Search for HTTP header refreshes.
         */
    }

    /**
     * This function is called if the crawler encountered an unexpected http
     * status code ( a status code other than 3xx)
     *
     * @param urlStr URL in which an unexpected error was encountered while
     * crawling
     * @param statusCode Html StatusCode
     * @param contentType Type of Content
     * @param description Error Description
     */
    @Override
    public void onUnexpectedStatusCode(String urlStr, int statusCode, String contentType,
                                          String description) {
        // 4xx problems
        // 5xx problems

        // decode url
        String url ;
        try {
            url = URLDecoder.decode(urlStr, "UTF-8");
        } catch (UnsupportedEncodingException e) {
            url = urlStr;
            logger.error("Decoding url in onUnexpectedStatusCode() failed", e);
        }

        // remove trailing slash
        if (url.endsWith("/")) {
            url = url.substring(0, url.length() - 1);
        }
        
        // remove old url
        try {
            postgresDBService.removeUrl(url);
        } catch (RuntimeException e) {
            logger.error("removing url in onUnexpectedStatusCode() failed", e);
        }

        // store url
        try {
            postgresDBService.storeUrl(url,statusCode, SampleLauncher.siteId,null);
        } catch (RuntimeException e) {
            logger.error("Storing url in onUnexpectedStatusCode() failed", e);
        }

    }

    @Override
    public void visit(Page page) {
        if (page.getParseData() instanceof HtmlParseData) {
            HtmlParseData htmlParseData = (HtmlParseData) page.getParseData();
            Document doc = Jsoup.parse(htmlParseData.getHtml());

            // decode url
            String url;
            try {
                url = URLDecoder.decode(page.getWebURL().getURL(), "UTF-8");
            } catch (UnsupportedEncodingException e) {
                url = page.getWebURL().getURL();
                logger.error("Decoding url in visit() failed", e);
            }

            // remove trailing slash
            if (url.endsWith("/")) {
                url = url.substring(0, url.length() - 1);
            }
            
            // remove old url
            try {
                postgresDBService.removeUrl(url);
            } catch (RuntimeException e) {
                logger.error("removing url in visit() failed", e);
            }
            
            Elements canonicalTags = doc.selectFirst("head").select("link[rel=canonical]");
            boolean isCanonicalExist = true;

            if (canonicalTags.isEmpty()) {
                // Missing canonical Url Problem
                
                isCanonicalExist =false;
            }else{
                String canonicalUrl = canonicalTags.first().attr("href");
                
                // remove trailing slash
                if (canonicalUrl.endsWith("/")) {
                    canonicalUrl = canonicalUrl.substring(0, canonicalUrl.length() - 1);
                }
                
                // check if canonical is different than the url
                if(!canonicalUrl.equalsIgnoreCase(url)){
                    // The current page is probably a duplicate of another page                      
                    return;
                }
            }
            
            // store url
            try {
                postgresDBService.storeUrl(url,page.getStatusCode(), SampleLauncher.siteId, (int) page.getWebURL().getDepth());
            } catch (RuntimeException e) {
                logger.error("Storing url in vist() failed", e);
            }


            Header[] headers = page.getFetchResponseHeaders();
            for (Header header : headers) {
                if (header.getName().equals("X-Robots-Tag")) {
                    if (header.getValue().contains("noindex")) {
                        // X-Robots-Tag: noindex problem

                        // store xrobots
                        try {
                            postgresDBService.storeRobot(url,"xRobots","noindex");
                        } catch (RuntimeException e) {
                            logger.error("Storing xRobots noindex failed", e);
                        }

                    }
                    if (header.getValue().contains("nofollow")) {
                        // X-Robots-Tag: nofollow problem

                        // store xrobots
                        try {
                            postgresDBService.storeRobot(url,"xRobots","nofollow");
                        } catch (RuntimeException e) {
                            logger.error("Storing xRobots nofollow failed", e);
                        }


                    }
                    if (header.getValue().contains("none")) {
                        // X-Robots-Tag: noindex, nofollow problems

                        // store xrobots
                        try {
                            postgresDBService.storeRobot(url,"xRobots","none");
                        } catch (RuntimeException e) {
                            logger.error("Storing xRobots none failed", e);
                        }


                    }
                }
                if (header.getName().equals("Refresh")) {
                    // HTTP header refreshes Temporary Redirect Problems
                    /*
                       will cause search engine crawlers
                    to treat the redirect as temporary and not pass any link juice (ranking power).
                    We highly recommend that you replace temporary redirects with 301 redirects.
                    handlePageStatusCode() and Search for HTTP header refreshes.
                     */

                    // store header refresh
                    try {
                        postgresDBService.storeRefresh(url,"headerRefresh",header.getValue());
                    } catch (RuntimeException e) {
                        logger.error("Storing header refresh failed", e);
                    }
                }
            }


            Elements titleTags = doc.selectFirst("head").select("title");
            if (titleTags.isEmpty()) {
                // Missing Title Problem

                // store title
                try {
                    postgresDBService.storeTitle(url,"");
                } catch (RuntimeException e) {
                    logger.error("Storing empty title failed", e);
                }

            } else {

                if (titleTags.size() > 1) {
                    // Multiple Titles Problem
                    
                    for (Element titleTag : titleTags) {

                        // store title
                        try {
                            postgresDBService.storeTitle(url,titleTag.text());
                        } catch (RuntimeException e) {
                            logger.error("Storing multiple title failed", e);
                        }
                    }
                }else {

                    String title = doc.selectFirst("head").select("title").first().text();


                    // store title
                    try {
                        postgresDBService.storeTitle(url,title);
                    } catch (RuntimeException e) {
                        logger.error("Storing title failed", e);
                    }

                }
            }

            Elements descriptionTags = doc.selectFirst("head").select("meta[name=description]");
            if (descriptionTags.isEmpty()) {
                //Missing Description

                // store description
                try {
                    postgresDBService.storeDescription(url,"");
                } catch (RuntimeException e) {
                    logger.error("Storing empty description failed", e);
                }

            } else {

                String description = doc.selectFirst("head").selectFirst("meta[name=description]").attr("content");

                // store description
                try {
                    postgresDBService.storeDescription(url,description);
                } catch (RuntimeException e) {
                    logger.error("Storing description failed", e);
                }

            }

            Elements robotsTags = doc.selectFirst("head").select("meta[name=robots]");
            if (!robotsTags.isEmpty()) {
                for (Element tag : robotsTags) {
                    if (tag.attr("content").contains("noindex")) {
                        //Meta noindex problem

                        // store robot
                        try {
                            postgresDBService.storeRobot(url,"metaTag","noindex");
                        } catch (RuntimeException e) {
                            logger.error("Storing meta tag noindex failed", e);
                        }


                    }
                    if (tag.attr("content").contains("nofollow")) {
                        //Meta Nofollow problem

                        // store robot
                        try {
                            postgresDBService.storeRobot(url,"metaTag","nofollow");
                        } catch (RuntimeException e) {
                            logger.error("Storing meta tag nofollow failed", e);
                        }

                    }
                    if (tag.attr("content").contains("none")) {
                        //Meta Nofollow problem

                        // store robot
                        try {
                            postgresDBService.storeRobot(url,"metaTag","none");
                        } catch (RuntimeException e) {
                            logger.error("Storing meta tag robots none failed", e);
                        }

                    }
                }
            }

            Elements metaRefresh = doc.selectFirst("head").select("meta[http-equiv=refresh]");
            if (!metaRefresh.isEmpty()) {
                // Meta Refresh Problem

                // store refresh
                try {
                    postgresDBService.storeRefresh(url,"MetaRefresh",metaRefresh.first().attr("content"));
                } catch (RuntimeException e) {
                    logger.error("Storing meta refresh failed", e);
                }

            }

            boolean isH1Exit =true;

            Elements H1Tags = doc.selectFirst("body").select("h1");
            if (H1Tags.isEmpty()) {
                // Missing H1 Problem
                
                isH1Exit =false;
            }

            String bodyText = doc.selectFirst("body").text();
            String contentWithoutSpaces = bodyText.replaceAll("\\s+", "");

            Integer contentLength = contentWithoutSpaces.length();

            String urlQuery = "";

            try {
                URL pageUrl = new URL(url);
                if(pageUrl.getQuery() != null) {
                    urlQuery = pageUrl.getQuery();
                }
            } catch (MalformedURLException ex) {
                logger.error("Parsing URL failed", ex);
            }

            // calculate hash of the page
            String hash = Similarities.calculateHash(htmlParseData.getHtml());

            // store content
            try {
                postgresDBService.storeContent(url,isH1Exit,isCanonicalExist,urlQuery,contentLength,hash);
            } catch (RuntimeException e) {
                logger.error("Storing content failed", e);
            }

            // remove old backlinks
            try {
                postgresDBService.removeBacklink(url);
            } catch (RuntimeException e) {
                logger.error("Removing backlinks failed", e);
            }

            // Get Outbound links
            Elements links = doc.select("a[href]");
            // is this link external
            boolean isExternal;

            for (Element link : links) {
                isExternal = !link.attr("abs:href").isEmpty() && !link.attr("abs:href").contains(page.getWebURL().getSubDomain()+page.getWebURL().getDomain());

//                if(SampleLauncher.exactMatch) {
//                    isExternal = !link.attr("abs:href").toLowerCase().startsWith(SampleLauncher.matchPattern);
//                }else {
//                    URL myUrl = null;
//                    try {
//                        myUrl = new URL(link.attr("abs:href").toLowerCase());
//                    } catch (MalformedURLException e) {
//                        logger.error("Wrong backlink format", e);
//                    }
//                    isExternal = myUrl != null ? !myUrl.getHost().equalsIgnoreCase(SampleLauncher.matchPattern) : false;
//                }
                if (isExternal){
                    // decode url
                    String backlink;
                    try {
                        backlink = URLDecoder.decode(link.attr("abs:href").toLowerCase(), "UTF-8");
                        if (backlink.endsWith("/")) {
                            backlink = backlink.substring(0, backlink.length() - 1);
                        }
                    } catch (UnsupportedEncodingException e) {
                        backlink = link.attr("abs:href").toLowerCase();
                        if (backlink.endsWith("/")) {
                            backlink = backlink.substring(0, backlink.length() - 1);
                        }
                        logger.error("Decoding backlink in visit() failed", e);
                    }

                    boolean isDoFollow = !link.attr("rel").contains("nofollow");                    

                    // store new backlinks
                    try {
                        postgresDBService.storeBacklink(url,backlink,link.text(),isDoFollow);
                    } catch (RuntimeException e) {
                        logger.error("Storing backlinks failed", e);
                    }
                }
            }

            // Slow Load Time Problem
            // Search how to get load time of the page into visit()

        }
    }

    /**
     * This function is called just before the termination of the current
     * crawler instance. It can be used for persisting in-memory data or other
     * finalization tasks.
     */
//    public void onBeforeExit() {
//
//    }

}
