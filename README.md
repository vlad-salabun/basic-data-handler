# Basic data handler

This application contain basic CRUD operations with your Eloquent models. It is intended for testing purposes. Do not use this in a production mode.

## Instalation
```php
composer require salabun/bdh
```
Create new folder and controller for BDH:
```php
namespace App\Http\Controllers\MS_BDH;
use BDH; // <- thisn is main library class
```
And extend library:
```php
class MS_BDH extends BDH
{
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
In routes/api.php add new route:
```php
use App\Http\Controllers\TestController;
Route::post('/food-track', [TestController::class, 'foodtrackApi']);
```


## Configuration

## Usage
