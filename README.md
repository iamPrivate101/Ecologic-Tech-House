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


//issue in 28 video subadmin password while adding subadmin and updating
the hash of the password is change need to resolve it



2023/11/26

category image update unlink issue in front/images/categories



2023/12/17
issue in  product filter size by ajax in #94  Product Controller line no 61   // ->groupBy('products_attributes.product_id'); //issue in size filter



//add to cart without the product attribute data returns error

//
issue in mini cart display as new product added to cart is not dispayed in mini cart via ajax
