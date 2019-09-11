package seocrawler.crawler;

import ch.qos.logback.classic.Level;
import ch.qos.logback.classic.Logger;
import ch.qos.logback.classic.LoggerContext;
import ch.qos.logback.classic.spi.LoggerContextListener;
import ch.qos.logback.core.Context;
import ch.qos.logback.core.spi.ContextAwareBase;
import ch.qos.logback.core.spi.LifeCycle;
import io.github.cdimascio.dotenv.Dotenv;

import java.text.SimpleDateFormat;
import java.util.Date;
import seocrawler.SampleLauncher;

/**
 * This listener to add the ability of  configuring LOG_HOME and LOG_FILE_NAME  *
 */

public class LoggerStartupListener extends ContextAwareBase implements LoggerContextListener, LifeCycle {

    private static final String DEFAULT_LOG_FILE_NAME = new SimpleDateFormat("yyyy-MMMM-dd__HH-mm-ss").format(new Date()) +".log" ;

    private static final String DEFAULT_LOG_HOME = "/root/crawlerData/logs";

    private boolean started = false;

    @Override
    public void start() {
        if (started) return;
        
        Dotenv dotenv = Dotenv.configure().directory("/usr/local/tomcat/webapps/").load();
        
        String logFile = SampleLauncher.matchPattern + "_"+ DEFAULT_LOG_FILE_NAME;

        String logHome = dotenv.get("SEO_CRAWLER_STORAGE_DIR")+"/logs";

        logFile = (logFile != null && logFile.length() > 0) ? logFile : DEFAULT_LOG_FILE_NAME;

        logHome = (logHome != null && logHome.length() > 0) ? logHome : DEFAULT_LOG_HOME;

        Context context = getContext();

        context.putProperty("LOG_HOME", logHome);
        
        context.putProperty("LOG_FILE_NAME", logFile);

        started = true;
    }

    @Override
    public void stop() {
    }

    @Override
    public boolean isStarted() {
        return started;
    }

    @Override
    public boolean isResetResistant() {
        return true;
    }

    @Override
    public void onStart(LoggerContext context) {
    }

    @Override
    public void onReset(LoggerContext context) {
    }

    @Override
    public void onStop(LoggerContext context) {
    }

    @Override
    public void onLevelChange(Logger logger, Level level) {
    }
}

