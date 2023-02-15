# Basic data handler

This application contain basic CRUD operations with your Eloquent models. It is intended for testing purposes. Do not use this in a production mode.

toc::[]

## Instalation and configuration
```php
composer require salabun/bdh
```
Add new aliase in **config/app.php**:
```php
'aliases' => [
    'BDH' => Salabun\Bdh\BaseDataHandler::class,
],
```

Create new folder **app\Http\Controllers\MS_BDH** and controller for BDH ex. **MS_BDH.php** and extend library:
```php
namespace App\Http\Controllers\MS_BDH;
use BDH; // <- thisn is main library class

class MS_BDH extends BDH
{
    //
}
```
Now you can create your own CRUD controller, for example TestController:
```php
namespace App\Http\Controllers;

use App\Http\Controllers\MS_BDH\MS_BDH;

class TestController extends Controller
{
    public function foodtrackApi(Request $request)
    {
        $bdh = new MS_BDH($request);
        $bdh->handleRequest();
        return response()->json($bdh->getResponse());
    }
}
```
In **routes/api.php** add new route:
```php
use App\Http\Controllers\TestController;
Route::post('/food-track', [TestController::class, 'foodtrackApi']);
```

## Usage
Get library for HTTP requests:
```html
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
```
Specify in your request:
```js
model: 'App\\Models\\Post', // model you want to interact with
request_type: 'create' // [create, read, update, delete]
data: {} // object
```


### Create request
```js
axios.post('/api/food-track', {
    model: 'App\\Models\\FoodTrack\\OrderItem',
    request_type: 'create',
    data: {
        order_id: 1,
        product_id: 3,
        quantity: 3,
        price: 35.00,
    },
})
.then(function (response) {
    console.log(response.data);
})
.catch(function (error) {
    console.log(error);
});
```
### Read request
To get access to relations add parameter **with** which you can specify array of related models:
```js
axios.post('/api/food-track', {
    model: 'App\\Models\\FoodTrack\\Order',
    with: ['orderItems'], // not required, relation names are the same as in laravel model
    request_type: 'read',
    data: {}, // empty
    where: [
        ["id", "<=", 3],
        ["deleted_at", "=", null]
    ],
    order_by: [
        ["id", "desc"],
        ["name", "asc"]
    ],
    pagination: 3, // not required, add this to use pagination
    path: "http://your-site.com/food-track" // not required, add this to customize pagination link
})
.then(function (response) {
    console.log(response.data);
})
.catch(function (error) {
    console.log(error);
});
```

### Update request
```js
axios.post('/api/food-track', {
    model: 'App\\Models\\FoodTrack\\Product',
    request_type: 'update',
    data: {
        description: "Pizza",
        available_quantity: 999,
    },
    where: [
        ["id", "=", 1],
        ["deleted_at", "=", null]
    ]
})
.then(function (response) {
    console.log(response.data);
})
.catch(function (error) {
    console.log(error);
});
```
### Delete request
