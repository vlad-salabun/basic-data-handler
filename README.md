# Basic data handler

This application contain basic CRUD operations with your Eloquent models. It is intended for testing purposes. Do not use this in a production mode.

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
Specify in your request which model you want to interact with and request type:
```js
model: 'App\\Models\\Post',
request_type: 'create' // [create, read, update, delete]
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
### Update request
### Delete request
