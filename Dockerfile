FROM alpine:latest

EXPOSE 443

COPY . /var/www/dd-fundraiser 

RUN apk update
RUN apk add php82 php82-mbstring php82-mysqlnd php82-mysqli php82-opcache php82-pdo php82-xml php82-apache2 php82-session php82-simplexml apache2-ssl
RUN rm -f /etc/apache2/httpd.conf /etc/apache2/conf.d/ssl.conf
RUN mv /var/www/dd-fundraiser/docker/config/httpd.conf /etc/apache2/ 
RUN mv /var/www/dd-fundraiser/docker/config/dd-fundraiser.conf /etc/apache2/conf.d/


ENTRYPOINT ["/usr/sbin/httpd", "-D", "FOREGROUND"]
