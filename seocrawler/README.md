A SEO Spider in Java

How can I create an executable JAR with dependencies using Maven?
mvn clean compile assembly:single

maven war plugin assembling webapp
mvn compile war:war

-----------------------------
How to rebuild the crawler ?
-----------------------------
0-First install maven excutable
sudo apt update
sudo apt install maven
Update: After installation is complete, run in the terminal mvn -v to see if package was installed.
1- remove all files in production folder
2- remove target folder
3- change directory to  seocrawler folder
4- run    mvn compile war:war

----------
-- Note --
----------
Make sure to place required env variables 
in laravel .env file
Currently required env variables are

SEO_CRAWLER_DB_USER_NAME=
SEO_CRAWLER_DB_PASSWORD=
SEO_CRAWLER_JDBC_URL=jdbc:postgresql://host:port/db
SEO_CRAWLER_FULL_AGENT=SEO-spider(https://github.com/Muhammad-Elgendi/SEO-spider/)
SEO_CRAWLER_AGENT=SEO-spider

laravel needs these two variable to connect with crawler
SEO_CRAWLER_HOST=tomcat
SEO_CRAWLER_PORT=8080

laravel can access crawler endpoint through "For example"
  $requestUrl = 'http://' . env('SEO_CRAWLER_HOST') . ':' . env('SEO_CRAWLER_PORT') . '/audit?url=' . $siteUrl . '&pages='.$pages.'&crawlers='.$crawlers.'&siteId=' . $siteId . '&match=' . $converted_exact;
------------------------------------------------------------

run crawler
java -jar SEO-crawler/target/SEO-crawler-1.0-SNAPSHOT-jar-with-dependencies.jar https://is.net.sa 10000 20 1 1 true

drop connections
SELECT pg_terminate_backend(pg_stat_activity.pid)
FROM pg_stat_activity
WHERE pg_stat_activity.datname = 'TARGET_DB' -- ← change this to your DB
  AND pid <> pg_backend_pid();
  
Current problems :-
