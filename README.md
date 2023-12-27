to create project:
composer create-project laravel/laravel project10

make the database in xampp and update the name of database in .env file
DB_DATABASE=project10
then run migration
php artisan migrate


make migration file for table , add the required attribute in the file dn 
php artisan make:migration create_admins_table

php artisan migrate

php artisan make:model Admin



