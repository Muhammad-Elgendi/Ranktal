package seocrawler;


import com.github.s3curitybug.similarityuniformfuzzyhash.UniformFuzzyHash;
import com.github.s3curitybug.similarityuniformfuzzyhash.UniformFuzzyHashes;
import com.mchange.v2.c3p0.ComboPooledDataSource;
import edu.uci.ics.crawler4j.crawler.CrawlConfig;
import edu.uci.ics.crawler4j.crawler.CrawlController;
import edu.uci.ics.crawler4j.fetcher.PageFetcher;
import edu.uci.ics.crawler4j.robotstxt.RobotstxtConfig;
import edu.uci.ics.crawler4j.robotstxt.RobotstxtServer;
import io.github.cdimascio.dotenv.Dotenv;
import java.net.MalformedURLException;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import seocrawler.crawler.PostgresCrawlerFactory;
import seocrawler.crawler.Similarities;
import seocrawler.db.PostgresDBService;
import seocrawler.db.impl.PostgresDBServiceImpl;
import java.net.URL;
import java.sql.Timestamp;
import java.util.Map;

public class SampleLauncher {

    private static final Logger logger = LoggerFactory.getLogger(SampleLauncher.class);

    public static  String mainUrl;
    public static Integer siteId;
    public static String matchPattern;
    public static boolean exactMatch;
    public static void main(String[] args) throws Exception{

        if (args.length != 5) {
            logger.info("Needed parameters: ");
            logger.info("\t Seed URL (start crawling with this URL)");
            logger.info("\t maxPagesToFetch (number of pages to be fetched)");
            logger.info("\t nuberOfCrawlers (number of crawlers)");
            logger.info("\t site id (id of site that being crawled)");
            logger.info("\t Exact match (Crawling Exact match url or the same host)");
            return;
        }

        // Handle arguments
        URL url = new URL(args[0]);
        mainUrl= args[0];
        int maxPages = Integer.valueOf(args[1]);
        int numberOfCrawlers = Integer.valueOf(args[2]);
        siteId = Integer.valueOf(args[3]);
        exactMatch = Boolean.valueOf(args[4]);

//        URL url = new URL("http://7loll.net");
//        mainUrl= url.toString();
//        siteId = 2;
//        int maxPages = 10000;
//        int numberOfCrawlers = 4;
//        exactMatch = false;

        matchPattern = exactMatch ? mainUrl : url.getHost();

        logger.info("Crawler Started : ");
        logger.info("\t Seed URL : "+mainUrl);
        logger.info("\t maxPagesToFetch : "+maxPages);
        logger.info("\t nuberOfCrawlers : "+numberOfCrawlers);
        logger.info("\t site id : "+siteId);

        Dotenv dotenv = Dotenv.configure().directory("/usr/local/tomcat/webapps/").load();

        CrawlConfig config = new CrawlConfig();

        config.setPolitenessDelay(200);

        config.setCrawlStorageFolder(dotenv.get("SEO_CRAWLER_STORAGE_DIR")+"/"+url.getHost());

        config.setMaxPagesToFetch(maxPages);

        config.setRespectNoFollow(false);

        config.setRespectNoIndex(false);

        config.setUserAgentString(dotenv.get("SEO_CRAWLER_FULL_AGENT"));

        /*
         * Instantiate the controller for this crawl.
         */
        RobotstxtConfig robotstxtConfig = new RobotstxtConfig();

        robotstxtConfig.setUserAgentName(dotenv.get("SEO_CRAWLER_AGENT"));

        PageFetcher pageFetcher = new PageFetcher(config);
        RobotstxtServer robotstxtServer = new RobotstxtServer(robotstxtConfig, pageFetcher);
        CrawlController controller = new CrawlController(config, pageFetcher, robotstxtServer);

        /*
         * For each crawl, you need to add some seed urls. These are the first
         * URLs that are fetched and then the crawler starts following links
         * which are found in these pages
         */
        controller.addSeed(mainUrl);

        ComboPooledDataSource comboPooledDataSource = new ComboPooledDataSource();
        comboPooledDataSource.setDriverClass("org.postgresql.Driver");
        comboPooledDataSource.setJdbcUrl(dotenv.get("SEO_CRAWLER_JDBC_URL"));
        comboPooledDataSource.setUser(dotenv.get("SEO_CRAWLER_DB_USER_NAME"));
        comboPooledDataSource.setPassword(dotenv.get("SEO_CRAWLER_DB_PASSWORD"));
        comboPooledDataSource.setMaxPoolSize(numberOfCrawlers);
        comboPooledDataSource.setMinPoolSize(numberOfCrawlers);

        logger.info("Starting Crawling Process ... ");

        // notify backend that crawling is started
        notifyBackendofStart(comboPooledDataSource,"Crawling", getCurrentTimeStamp());
        
        /*
         * Start the crawl. This is a blocking operation, meaning that your code
         * will reach the line after this only when crawling is finished.
         */

        controller.start(new PostgresCrawlerFactory(comboPooledDataSource), numberOfCrawlers);


        logger.info("Crawling Process Has Finished ... ");


        logger.info("Check Duplicate Content and Store Similarities Process Has Started ... ");

        /**
         * Check Duplicate Content and Store Similarities
         */
        checkForDuplicateContent(comboPooledDataSource);


        logger.info("Inform backend that crawling is finished ... ");

        /**
         * Inform backend
         */
        notifyBackendofFinish(comboPooledDataSource,"Finished", getCurrentTimeStamp());

        logger.info("Closing pool ... ");

        comboPooledDataSource.close();

        logger.info("The End");
    }


    private static void checkForDuplicateContent(ComboPooledDataSource comboPooledDataSource) throws Exception{
        PostgresDBService postgresDBService = new PostgresDBServiceImpl(comboPooledDataSource);
        Map<String,String> hashesStrings = postgresDBService.getHashes(mainUrl);
        Map<String, UniformFuzzyHash>  map = UniformFuzzyHashes.computeHashesFromStrings(hashesStrings,61);
        Map similarities= UniformFuzzyHashes.computeAllHashesSimilarities(map);
        Similarities.saveAllHashesSimilarities(similarities,postgresDBService);
    }
    
        private static void notifyBackendofStart(ComboPooledDataSource comboPooledDataSource, String status, Timestamp startTime) throws Exception{
        PostgresDBService postgresDBService = new PostgresDBServiceImpl(comboPooledDataSource);
        postgresDBService.startJob(status,startTime,siteId);
    }

    private static void notifyBackendofFinish(ComboPooledDataSource comboPooledDataSource, String status, Timestamp finishTime) throws Exception{
        PostgresDBService postgresDBService = new PostgresDBServiceImpl(comboPooledDataSource);
        postgresDBService.finishJob(status,finishTime,siteId);
    }

    public static java.sql.Timestamp getCurrentTimeStamp() {
        return new java.sql.Timestamp(new java.util.Date().getTime());
    }

}