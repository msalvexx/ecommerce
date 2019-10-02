
# Ecommerce Test Project

A test project for Veus Tecnology.

## Installation

Use the composer to install all dependency packages.

```bash
composer install
```
Configure the database connection located at .env.
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=user
DB_PASSWORD=password
```
Run the following code to set the application key.
```bash
php artisan key:generate
```
Now, let's save all changes at cache.
```bash
php artisan config:cache
```

## Usage



## License
[MIT](https://choosealicense.com/licenses/mit/)