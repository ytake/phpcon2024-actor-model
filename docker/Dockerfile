FROM php:8.4-cli-bullseye

RUN set -eux; \
	\
	sed -i'.bak' 's/$/ contrib/' /etc/apt/sources.list; \
	apt-get update && apt-get -y upgrade; \
	apt-get install -y libaio1 wget unzip \
		libicu-dev \
        libzip-dev \
        libyaml-dev \
        gettext graphviz \
        libmagickwand-dev \
        librabbitmq-dev \
        libpq-dev  \
        imagemagick \
        libxslt1-dev \
        \
        libjpeg62-turbo \
        libpng16-16

RUN apt install libgmp-dev -y;

RUN pecl install apcu; \
           pecl install yaml; \
           pecl install igbinary; \
  docker-php-ext-enable apcu yaml igbinary; \
  docker-php-ext-install -j$(nproc) iconv; \
  docker-php-ext-configure intl; \
  docker-php-ext-install -j$(nproc) intl; \
  docker-php-ext-install -j$(nproc) \
        exif \
        bcmath \
        xsl \
        gettext \
        opcache \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        soap \
        zip \
        pcntl \
        gmp;

RUN pecl install swoole-6.0.0
RUN docker-php-ext-enable swoole
RUN  apt-get install -y supervisor

RUN pecl install opentelemetry; \
  docker-php-ext-enable opentelemetry;

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

ENV COMPOSER_ALLOW_SUPERUSER=1

WORKDIR /var/app

ENTRYPOINT ["/usr/bin/supervisord"]
CMD ["-c", "/etc/supervisor/supervisord.conf", "-n"]
