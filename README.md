# Settings
### To install the dependencies run
composer install
### Set your connections
In the .env file set the database connection
### Run the next command to generate your key 
php artisan key:generate
### Create the database
create database 'wishlist';
### Migrate the database
php artisan migrate
### To get the rows for the filters execute the next commans
php artisan db:seed --class=CategoryTableSeeder

php artisan db:seed --class=SortTableSeeder

php artisan db:seed --class=SearchTableSeeder

### Postman collection
To make request to the backend system you can use the next url to add the postman collection.
https://www.getpostman.com/collections/be084f2ed08143e6c67b