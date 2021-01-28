FROM tomcat:9.0-alpine

LABEL maintainer="deepak@softwareyoga.com"

EXPOSE 8080

# Add a non-root user to prevent files being created with root permissions on host machine.
ARG PUID=1000
ENV PUID ${PUID}
ARG PGID=1000
ENV PGID ${PGID}

USER root

RUN addgroup -g ${PGID} laradock && \
    adduser -u ${PUID} -G laradock -D laradock

RUN chown -R laradock:laradock /usr/local/tomcat

USER laradock

RUN mkdir -p ~/crawlerData/logs

CMD ["catalina.sh", "run"]
