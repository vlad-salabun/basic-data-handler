# Basic data handler

This application contain basic CRUD operations with your Eloquent models. It is intended for testing purposes. Do not use this in a production mode.

## Instalation and configuration
```php
composer require salabun/bdh
```
Add new aliase in config/app.php:
```php
'aliases' => [
    'BDH' => Salabun\Bdh\BaseDataHandler::class,
],
```

Create new folder **app\Http\Controllers\MS_BDH** and controller for BDH ex. **MS_BDH.php** and extend library::
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
