

# VS Challenger

A project of Veus Tecnology Challenger.

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
For create migrations run and populate a faker database.
```bash
php artisan migrate
php artisan db:seed
```
Finally, start the server
```bash
php artisan serve
```

Generally, the project will be available in route http://localhost:8000.

## Usage
For all requests, we need to pass the parameter `api_token` for user authentication.

All faker users are configurated with:
`api_token=kxBDR7b01xC4VNg2o97F5SSs4XCcJyn9y6dxkaYkwF5odjeL9OpQDAMjW7cS`

## Available routes

 **List all products**
 ```bash
GET  /api/v1/products
 ```
*Advanced Search*

You can use advanced search like:
`?q=seringa&filter=brand:BUNZL,stock:340&sort=name:asc,created_at:desc`

*Pagination*

For change the page result, use:

    page=3

 **Show product**
  ```bash
GET  /api/v1/products/{$id}
 ```
  **Create Product**

  Use `enctype=multipart/form-data`
  ```bash
POST  /api/v1/products
 ```
 *Parameters*

| Name | Description | Type |
|--|--|--|
| name | The product name. Eg: "Estetoscópio Littmann Classic III Black Edition" | required |
| type | The product type. Eg: "estetoscopio, seringa, luva"|  required |
| brand | The brand of the product. Eg: "BUNZL"|  required |
| stock | The quantity of the product in stock. Eg: "30"|  required |
| amount | The price of the product. Eg: "759.90"|  required |

 **Update product**

Use `enctype=application/x-www-form-urlencoded`
  ```bash
PUT  /api/v1/products/{$id}
 ```

*Parameters*

| Name | Description | Type |
|--|--|--|
| id | The product id. Eg: "18" | required |
| name | The product name. Eg: "Estetoscópio Littmann Classic III Black Edition" | optional |
| type | The product type. Eg: "estetoscopio, seringa, luva"|  optional |
| brand | The brand of the product. Eg: "BUNZL"|  optional |
| stock | The quantity of the product in stock. Eg: "30"|  optional |
| amount | The price of the product. Eg: "759.90"|  optional |

## Testing

Just run the following code on terminal:

    npm run phpunit

## License
[MIT](https://choosealicense.com/licenses/mit/)
