#!/usr/bin/env bash

set -e

php /var/www/vhost/artisan queue:work --queue=register-interest,email --verbose --tries=3 --timeout=90
