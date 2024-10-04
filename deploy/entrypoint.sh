#!/bin/sh

cd /var/www/fantom-ls/


# Checking if the database has already been initialized
if [ ! -f /var/www/fantom-ls/.initialized ]; then

    # first: change group (nginx)
    chown -R :81 ./storage/app

    # second: change permissions
    chmod -R 775 ./storage/app

    # Generate an application key. Re-cache.
    php artisan key:generate
    php artisan config:clear
    php artisan config:cache

    # Run database migrations.
    php artisan migrate:fresh --seed

    # Run database seed
    php artisan storage:link
    php artisan optimize:clear


    # Create a marker file to mark the database as initialized
    touch /var/www/fantom-ls/.initialized

    #for nginx
    openrc
    touch /run/openrc/softlevel
    rc-service nginx start
    php-fpm &
fi

# Run Laravel server
php artisan serve --host=0.0.0.0 --port=8001
