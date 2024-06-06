FROM dockerhub.greensight.ru/ensi-tech/php-base-image:8.2-master-2023sep11-1-swoole

WORKDIR /var/www/html

COPY . /var/www/html

COPY enter-container.sh /usr/local/bin/enter-container.sh
RUN chmod +x /usr/local/bin/enter-container.sh

ENTRYPOINT ["enter-container.sh"]