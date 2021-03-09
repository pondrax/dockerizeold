FROM hermsi/alpine-fpm-php:7.4


RUN wget https://getcomposer.org/installer \
	&& php installer --install-dir=/usr/local/bin --filename=composer
