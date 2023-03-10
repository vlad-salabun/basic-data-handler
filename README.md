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

Create models specifying which connection to use
```php
class Order extends Model
{

    protected $connection = 'foodtrack';
    public $timestamps = false;

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
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
Data object keys must match the field names in the database.
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
```js
axios.post('/api/food-track', {
    model: 'App\\Models\\FoodTrack\\OrderItem',
    request_type: 'delete',
    data: {},
    where: [
        ["id", "=", 1],
        //["deleted_at", "=", null]
    ]
})
.then(function (response) {
    console.log(response.data);
})
.catch(function (error) {
    console.log(error);
});
```

## Backend methods
In your controller **App\Http\Controllers\MS_BDH** you can reload methods:
```php
public function beforeCreation() {}
public function afterCreation() {}

public function beforeRead() {}
public function afterRead() {}

public function beforeUpdate() {}
public function afterUpdate() {}

public function beforeDelete() {}
public function afterDelete() {}

public function afterReturn() {}
public function beforeResponse() {}
```
You have access to this variables:
```php
public $request = null;
public $response = [
    "status" => 0,
    "response" => [],
    "execution_time" => 0,
];
```
## Responses
The basic response contains the following fields:
```js
{
    "status": 200,
    "status_message": "Object created!"
    "response": {
        "data": []
    },
    "execution_time": 0.00
}
```

Add a field **debug** to add request fields into response.
```js
{
    "status": 200,
    "status_message": "Object created!"
    "response": {
        "data": []
    },
    "request": []
    "execution_time": 0.00
}
```
If request fails field **status** will have code 400 or 500. Two new fields will also be added. **errors** contains a textual explanation of the essence of the error.
```js
{
    "status": 500,
    "error_code": 1,
    "errors": 1,
    "response": {
        "data": []
    },
    "execution_time": 0.00
}
```
