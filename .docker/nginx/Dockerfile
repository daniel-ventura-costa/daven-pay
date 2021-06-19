FROM nginx:latest
WORKDIR /usr/share

RUN apt update
RUN apt install vim -y
RUN apt install libnss3-tools -y
RUN apt install wget -y

COPY ./nginx.conf /etc/nginx/conf.d/default.conf

RUN cd ~

RUN wget https://github.com/FiloSottile/mkcert/releases/download/v1.4.3/mkcert-v1.4.3-linux-amd64
RUN mv mkcert-v1.4.3-linux-amd64 mkcert
RUN chmod +x mkcert
RUN cp mkcert /usr/local/bin/

RUN mkcert -install
RUN mkcert localhost