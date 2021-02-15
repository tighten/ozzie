#!/usr/bin/env bash

set -e

 while [ true ]
    do
      php /var/www/vhost/artisan schedule:run --verbose --no-interaction &
      sleep 60
    done
