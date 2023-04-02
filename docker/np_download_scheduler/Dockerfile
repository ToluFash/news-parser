FROM news-parser/php-fpm

USER root

RUN apt-get update && apt-get -y cronie && crond

COPY ../php7.4-fpm/cron.d/crontab /etc/crontab
RUN chmod 0644 /etc/crontab
RUN chmod 775 /var/www/html
RUN crontab /etc/crontab
RUN touch /var/log/crontest.log && chmod 777 /var/log/crontest.log

CMD ["crond", "-n", "-s"]
