FROM wyveo/nginx-php-fpm:latest

RUN apt-get update && apt-get install -y \
    vim \
    curl

WORKDIR /usr/share/nginx
RUN rm -rf /usr/share/nginx/html
RUN ln -s public html