# Lumberjack
A framework for making WordPress theme development more sane & easier to maintain.

Written & maintained by the team at [Rareloop](https://www.rareloop.com).

## Features
- Dependency Injection Container (PSR11)
- Configuration
- Post Types
- Actions & Filters
- Router
  - HTTP Request/Response Messages (PSR7)
  - Middleware (PSR15)
- Controllers
- Logging (PSR3)
- Service Providers
- Facades
- Exceptions

The framework has been designed to be as un-intrusive as possible and you're free to use as little or as much of it as you'd like.

## Requirements
- PHP >=7.0
- Installation via Composer (e.g. Bedrock)

## Installing
Download this theme to your Composer powered WordPress setup and then install the core framework dependency:

```shell
composer require rareloop/lumberjack-core
```

## Dependency Injection Container
Lumberjack features a PSR11 compatible container, powered by the popular open source [PHPDI](http://php-di.org). If this is a new term for you checkout this [great intro](http://php-di.org/doc/understanding-di.html) and don't worry, you don't have to make use of it if you don't want to.

## Accessing the container
In the default Lumberjack `functions.php` you'll find the following code:

```php
$app = new Application(__DIR__);
```

This creates the Application and the `$app` variable becomes your reference to the container.

### Setting entries in the container
To add something to the container you simply call `bind()`, e.g.:

```php
$app->bind('foo', 'bar');
```

### Retrieving entries from the container
To retrieve an entry from the container you can use `get()`, e.g.:

```php
$foo = $app->get('foo');
```

### Use the container to create an object
You can use the container to create an object from any class that your application can autoload using `make()`, e.g.:

```php
$comment = $app->make('\MyNamespace\Comment');
```

When creating an object using `make`, all the dependencies required by it's `__construct()` function will be automatically resolved from the container using type hinting. If your object requires additional parameters that can not resolved by type hinting you can pass them as a second param, e.g.:

```php
namespace MyNamespace;

class Comment
{
  public function __construct(ClassInContainer $resolvable, $param1, $param2) {}
}

...

$comment = $app->make('\MyNamespace\Comment', [
  'param1' => 123,
  'param2' => 'abc',
]);
```

### Set concrete implementations for interfaces
You can also tell the container what concrete class to use when resolving a certain type hinted interface. This allows you to write your app code against contracts and then use the container to switch in the correct implementation at runtime.

```php
namespace MyNamespace;

interface PaymentGateway {}

class StripePaymentGateway implements PaymentGateway{}

$app->set('\MyNamespace\PaymentGateway', '\MyNamespace\StripePaymentGateway');

$gateway = $app->make('\MyNamespace\PaymentGateway');
// $gateway is instance of '\MyNamespace\StripePaymentGateway'
```


## Configuration
TODO

## Post Types
TODO

## Actions & Filters
TODO

## Router
The Lumberjack Router is based on the standalone [Rareloop Router](https://github.com/Rareloop/router) but utilised a Facade to make setup and access simpler.

Note: Route closures and controller functions are automatically dependency injected from the container.

### HTTP Request/Response Messages
### Creating Routes

#### Map

Creating a route is done using the `map` function:

```php
use Rareloop\Lumberjack\Facades\Router;

// Creates a route that matches the uri `/posts/list` both GET
// and POST requests.
Router::map(['GET', 'POST'], 'posts/list', function () {
    return 'Hello World';
});
```

`map()` takes 3 parameters:

- `methods` (array): list of matching request methods, valid values:
    + `GET`
    + `POST`
    + `PUT`
    + `PATCH`
    + `DELETE`
    + `OPTIONS`
- `uri` (string): The URI to match against
- `action`  (function|string): Either a closure or a Controller string

#### Route Parameters
Parameters can be defined on routes using the `{keyName}` syntax. When a route matches that contains parameters, an instance of the `RouteParams` object is passed to the action.

```php
Router::map(['GET'], 'posts/{id}', function(RouteParams $params) {
    return $params->id;
});
```

#### Named Routes
Routes can be named so that their URL can be generated programatically:

```php
Router::map(['GET'], 'posts/all', function () {})->name('posts.index');

$url = Router::url('posts.index');
```

If the route requires parameters you can be pass an associative array as a second parameter:

```php
Router::map(['GET'], 'posts/{id}', function () {})->name('posts.show');

$url = Router::url('posts.show', ['id' => 123]);
```

#### HTTP Verb Shortcuts
Typically you only need to allow one HTTP verb for a route, for these cases the following shortcuts can be used:

```php
Router::get('test/route', function () {});
Router::post('test/route', function () {});
Router::put('test/route', function () {});
Router::patch('test/route', function () {});
Router::delete('test/route', function () {});
Router::options('test/route', function () {});
```

### Creating Groups
It is common to group similar routes behind a common prefix. This can be achieved using Route Groups:

```php
Router::group('prefix', function ($group) {
    $group->map(['GET'], 'route1', function () {}); // `/prefix/route1`
    $group->map(['GET'], 'route2', function () {}); // `/prefix/route2§`
});
```

### Middleware
TODO

#### Route based middleware
#### Global middleware

## Controllers

### WordPress Controllers
TODO

### Route Controllers
If you'd rather use a class to group related route actions together you can pass a Controller String to `map()` instead of a closure. The string takes the format `{name of class}@{name of method}`. It is important that you use the complete namespace with the class name.

Example:

```php
// TestController.php
namespace \MyNamespace;

class TestController
{
    public function testMethod()
    {
        return 'Hello World';
    }
}

// routes.php
Router::map(['GET'], 'route/uri', '\MyNamespace\TestController@testMethod');
```

## Sessions
The HTTP protocol is inherently stateless. If you want to maintain some data between requests, you will need to use the Session.

### Configuration
The Session is configured using the `config/session.php` file. By default Lumberjack is configured to store all session data as files on the disk.

### Usage

#### Retrieving Data
The primary way to work with session data is via the `Session` Facade:

```php
use Rareloop\Lumberjack\Facades\Session;

$value = Session::get('key');
```

You can also pass an optional second parameter to use as a default in the instance the requested key doesn't exist:

```php
use Rareloop\Lumberjack\Facades\Session;

$value = Session::get('key', 'default');
```

##### Retrieving All Session Data
You can use the `all()` function if you wish to retrieve all the session data:

```php
use Rareloop\Lumberjack\Facades\Session;

$data = Session::all();
```

##### Determine If An Item Exists In The Session
You can check if a specific key is stored in the session using the `has()` function:

```php
use Rareloop\Lumberjack\Facades\Session;

if (Session::has('key')) {
    // Do something
}
```

##### Retrieve and remove
If you wish to remove an item from the session but also retrieve it's current value, you can use the `pull()` function:

```php
use Rareloop\Lumberjack\Facades\Session;

$value = Session::pull('key');
```

#### Storing Data
To store data into the session you use the `put()` function:

```php
use Rareloop\Lumberjack\Facades\Session;

Session::put('key', 'default');
```

##### Adding Data to Array Session Values
If you have an array in your session, you can add new data to it by using the `push()` function:

```php
use Rareloop\Lumberjack\Facades\Session;

Session::push('key', 'default');
```

#### Flash Data
There are times when you only want to keep session data for the next request, e.g. form values when a validation error occurs.

You can achieve this easily in Lumberjack using the `flash()` function:

```php
use Rareloop\Lumberjack\Facades\Session;

Session::flash('key', 'default');
```

If you later decide that you need the data to persist in the session you can do this in two ways. Use the `keep()` to select specific keys to retain or `reflash()` to store all flash data for an additional request.

```php
use Rareloop\Lumberjack\Facades\Session;

Session::keep('key');

// or

Session::reflash();
```

#### Deleting Data
To remove data from the session you use the `forget()` function:

```php
use Rareloop\Lumberjack\Facades\Session;

Session::forget('key');
```

### Adding Custom Storage Drivers
Lumberjack is capable of using multiple different drivers for session storage. The default and only driver provided in the core is the `file` driver, which saves all session data to disk.

It is simple to implement and register a new driver though.

#### Implement the driver
Start by creating a class that implements the standard PHP [SessionHandlerInterface](http://php.net/manual/en/class.sessionhandlerinterface.php) that provides the storage functionality you require:

```php
namespace App\Session\Drivers;

class DatabaseSessionDriver implements \SessionHandlerInterface
{
    /**
     * Perform and opening/initialisation required for this driver
     * Note: In most cases this can be empty
     */
    public function open ($save_path, $session_name) {}

    /**
     * Perform and closing/shutdown required for this driver
     * Note: In most cases this can be empty
     */
    public function close () {}

    /**
     * Return a string of the data associated with $session_id
     */
    public function read ($session_id) {}

    /**
     * Save the provided string data against $session_id
     */
    public function write ($session_id, $session_data) {}

    /**
     * Remove any data associated with $session_id
     */
    public function destroy ($session_id) {}

    /**
     * Remove all session data that is older than $maxlifetime
     * Note: $maxlifetime is provided as a Unix timestamp
     */
    public function gc ($maxlifetime) {}
}
```

#### Register the driver
To register the new driver you need to use a Service Provider. If you don't want to create a new provider you can use the `AppServiceProvider` which can be found in `app\Providers\AppServiceProvider.php`.

Registration is done by calling `extend()` on the Session facade:

```php
<?php

namespace App\Providers;

use Rareloop\Lumberjack\Facades\Session;
use Rareloop\Lumberjack\Providers\ServiceProvider;
use App\Session\Drivers\DatabaseSessionDriver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any app specific items into the container
     */
    public function register()
    {

    }

    /**
     * Perform any additional boot required for this application
     */
    public function boot()
    {
        Session::extend('database', function($app) {
            return new DatabaseSessionDriver;
        });
    }
}

```

After this it's just a matter of updating the `driver`  value in `config/session.php` to match the key you passed to `extend()`, in this instance this would be `database`.

## Logging (PSR3)
TODO

## Service Providers
TODO

## Facades
Lumberjack uses the [Blast Facades](https://github.com/phpthinktank/blast-facades) library.

### Creating a Facade
Facades provide a simple static API to an object that has been registered into the container. For example to setup a facade you would first use a Service Provider to register an instance of your class into the container:

```php
namespace Rareloop\Lumberjack\Providers;

use Monolog\Logger;
use Rareloop\Lumberjack\Application;

class LogServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Create object instance and bind into container
        $this->app->bind('logger', new Logger('app'));
    }
}
```

Then create a Facade subclass and tell it which key to use to retrieve your class instance:

```php
<?php

namespace Rareloop\Lumberjack\Facades;

use Blast\Facades\AbstractFacade;

class Log extends AbstractFacade
{
    protected static function accessor()
    {
        return 'logger';
    }
}
```

## Exceptions
TODO
