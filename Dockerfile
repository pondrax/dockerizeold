FROM hermsi/alpine-fpm-php:7.4

RUN apk update
RUN apk add nodejs npm
#RUN apk add openjdk11

RUN wget https://getcomposer.org/installer \
	&& php installer --install-dir=/usr/local/bin --filename=composer
