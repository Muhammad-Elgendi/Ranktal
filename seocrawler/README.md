A SEO Spider in Java

How can I create an executable JAR with dependencies using Maven?
mvn clean compile assembly:single

maven war plugin assembling webapp
mvn compile war:war

How to rebuild the crawler ?
1- remove all files in production Except .env files
2- remove target folder
3- change directory to  seocrawler folder
4- run    mvn compile war:war


run crawler
java -jar SEO-crawler/target/SEO-crawler-1.0-SNAPSHOT-jar-with-dependencies.jar https://is.net.sa 10000 20 1 1 true

drop connections
SELECT pg_terminate_backend(pg_stat_activity.pid)
FROM pg_stat_activity
WHERE pg_stat_activity.datname = 'TARGET_DB' -- ← change this to your DB
  AND pid <> pg_backend_pid();
  
Current problems :-
