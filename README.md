# Laravel-lightspeed-sync

## done
* GET product/variant resources and store in database (prototype)

## todo

* GET order/customer/billing resources and store in database
* Sync trough webhooks

## to do later

* a lot.

# Installation
php artisan vendor:publish

php artisan queue:table
php artisan queue:failed-table
php artisan migrate

php artisan lightspeedsync:init

start queue worker