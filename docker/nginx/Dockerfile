# Offical Docker Image for Nginx
# https://hub.docker.com/_/nginx
FROM nginx

# Set Current Directory
WORKDIR /var/www/vhost/

# Vhost Config
COPY ./config/vhost.conf /etc/nginx/conf.d/vhost.conf

# Self-signed SSL Certificates (see README.md)
COPY ./ssl/self-signed.crt /etc/nginx/ssl/self-signed.crt
COPY ./ssl/self-signed.key /etc/nginx/ssl/self-signed.key
