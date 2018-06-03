# Lumberjack
A framework for making WordPress theme development more sane & easier to maintain.

The framework has been designed to be as un-intrusive as possible and you're free to use as little or as much of it as you'd like.

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

## Requirements
- PHP >=7.0
- Installation via Composer (e.g. Bedrock)

## Installing
This repository is a starter theme. To get started you should **download this and add it to your `themes/` directory**.

_(Note: Currently using a child-theme to extend this theme is unsupported.)_

The theme depends on the core Lumberjack framework. Install this via composer, like so:

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

Lumberjack comes with a selection of config files out-of-the-box. These live in the `config/` directory and are simple `.php` files that return an `array`.

### Accessing Configuration Values

Let's take a look at `config/app.php`:

```php
return [
    /**
     * The current application environment
     */
    'environment' => getenv('WP_ENV'),

    // ...etc
];
```

Here we are proxying an environment variable defined in the `.env` file that Bedrock provides. We'd recommend following this pattern, where you should only see `getenv` called in your config files.

You can easily access the environment variable using the `Rareloop\Lumberjack\Facades\Config` facade.

```php
use Rareloop\Lumberjack\Facades\Config;

$env = Config::get('app.environment');
```

You can provide a default value too, incase the configuration option does not exist.

```php
$env = Config::get('app.environment', 'production');
```

If you need to update a config option, you can use the `set` method, like so:

```php
Config::set('app.debug', false);
```

### Adding your own config files

Chances are, you're going to need to add your own config files at some point. All you need to do is create a new `.php` file in the `config/` directory, and have it return an array.

This works because Lumberjack will look for all files in the `config/` directory that have a `.php` extention and automatically registers all the data to the application's config.

## Post Types

Typically in WordPress when you're querying posts you get [`WP_Post`](https://codex.wordpress.org/Class_Reference/WP_Post) objects back. Timber have taken this a step further and return a `Timber/Post` object instead. This [has a ton of great helper methods and properties](https://timber.github.io/docs/reference/timber-post/) which makes it easier and more expressive to use.

```php
use Timber\Post;

$post = new Post(1);
$posts = Timber::get_posts($wpQueryArray);
```

Lumberjack has its own Post object which makes it easier and more expressive to run queries.

```php
use Rareloop\Lumberjack\Post;

$post = new Post(1);
$collection = Post::query($wpQueryArray);
```

This becomes especially powerful when you start registering **Custom Post Types**.


```php
use App\PostTypes\Product;

$post = new Product(1);
$collection = Product::query($wpQueryArray);
```

In this example `$collection` contains `App\PostType\Product` objects. That allows you to add your own methods to a product and encapsulate logic in one place.

```php
use App\PostTypes\Product;

$collection = Product::query($wpQueryArray);

foreach ($collection as $product) {
    echo $product->price();
}
```

```php
namespace App\PostTypes;

use Rareloop\Lumberjack\Post;

class Product extends Post
{
    // ...

    public function price()
    {
        // Get the price from the ACF field for this product
        return get_field('price', $this->id);
    }
}
```

### Register Custom Post Types

First, create a new file in `app/PostTypes/`. We recommend using singular names. For this example, lets add a `Product.php` file there.

You can use this boilerplate to get you started:

```php
<?php

namespace App\PostTypes;

use Rareloop\Lumberjack\Post;
use Rareloop\Lumberjack\QueryBuilder\Post as QueryBuilderPost;

class Product extends Post
{
    /**
     * Return the key used to register the post type with WordPress
     * First parameter of the `register_post_type` function:
     * https://codex.wordpress.org/Function_Reference/register_post_type
     *
     * @return string
     */
    public static function getPostType()
    {
        return 'products';
    }

    /**
     * Return the config to use to register the post type with WordPress
     * Second parameter of the `register_post_type` function:
     * https://codex.wordpress.org/Function_Reference/register_post_type
     *
     * @return array|null
     */
    protected static function getPostTypeConfig()
    {
        return [
            'labels' => [
                'name' => __('Products'),
                'singular_name' => __('Product'),
                'add_new_item' => __('Add New Product'),
            ],
        ];
    }
}
```

Lumberjack will handle the registering of the post type for you. In order to do that, it requires 2 methods (documented above):

- `getPostType()`
- `getPostTypeConfig()`

In order for Lumberjack to register your post type, you need to add the class name to the `config/posttypes.php` config file.

```php
return [
    /**
     * List all the sub-classes of Rareloop\Lumberjack\Post in your app that you wish to
     * automatically register with WordPress as part of the bootstrap process.
     */
    'register' => [
        App\PostTypes\Product::class,
    ],
];
```

And that's it! You can now start using your new Custom Post Type.

#### Tip:

Try and avoid using ACF's `get_field` outside of a Post Type class. This will help make your application easy to change.

```php
$product = new Product;

// Bad
echo get_field('price', $product->id);

// Good: The knowledge of how to get the price is encapsulated within the Product class
echo $product->price();
```

### Available Methods for `Rareloop\Lumberjack\Post`

Lumberjack's `Post` class extends `Timber\Post`, and adds some convenient methods for you:

```php
use Rareloop\Lumberjack\Post;
use Rareloop\Lumberjack\Product;

// Get all published posts, ordered by ascending title
$posts = Post::all(10, 'title', 'asc');

// Accepts the WP_Query args as an array. By default it will filter by published posts for the correct post type too
$products = Product::query(['s' => 'Toy Car']);
```

## Actions & Filters
TODO

## Router
The Lumberjack Router is based on the standalone [Rareloop Router](https://github.com/Rareloop/router) but utilised a Facade to make setup and access simpler.

Note: Route closures and controller functions are automatically dependency injected from the container.

### HTTP Request/Response Messages

// TODO

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
