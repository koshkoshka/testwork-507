FROM php:8.1-fpm
ARG user
ARG uid

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev nano apt-utils htop\
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

WORKDIR /var/www

RUN git config --global user.email "andreykosh000@mail.ru" && git config --global user.name "koshkoshka"

USER $user
CMD /bin/bash -c "composer install && php artisan migrate && php artisan db:seed && php-fpm"
