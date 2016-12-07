# Lumberjack Starter Theme

This is a Wordpress starter theme based on Timber's starter theme, which uses Twig for templating.

![Lumberjack Wordpress starter theme](http://www.adamtom.at/app/uploads/2015/10/lumberjack.jpg "Lumberjack Wordpress starter theme")

_By Adam Tomat ([@adamtomat](http://twitter.com/adamtomat)) and Joe Lambert ([@joelambert](http://twitter.com/joelambert)) at Rareloop ([@rareloop](twitter.com/rareloop)). Axe logo by Mete Eraydın from the Noun Project_

The theme works best when used with Bedrock.

- Timber: https://github.com/jarednova/timber/wiki/Timber-docs
- Twig: http://twig.sensiolabs.org/documentation
- Bedrock: https://roots.io/bedrock

When researching, we came across this awesome [Timber Starter Theme](https://github.com/Upstatement/timber-starter-theme) by [Upstatement](http://upstatement.com/). I want to give them credit and thanks as I used their controller logic (e.g. `page.php`) in Lumberjack. Cheers!

For more detailed information, see [Supercharging WordPress with Lumberjack](http://www.adamtom.at/articles/supercharging-wordpress-with-lumberjack/)

## Requirements

If upgrading from Timber 0.12 see Timber's upgrade guide here: [https://github.com/timber/timber/wiki/1.0-Upgrade-Guide](https://github.com/timber/timber/wiki/1.0-Upgrade-Guide)

- PHP >=5.4
- Timber >= 1.1

## Features

- Uses the Twig Templating Engine with Timber, which seperates data and logic from views.
- Everything under the `lumberjack/` directory is namespaced
- Provides a foundation with default configuration which does all the heavy lifting for you

## Coding Style

- 4 spaces
- use spaces around the variable in Twig: `{{ variable }}` not `{{variable}}`
- PHP arrays declared with `[]` not `array()`

## Directory Structure

Out the box, this theme should have everything you need to get up and running as quickly as possible.

### assets

Simply put, this is where your **css**, **javascript** and **images** live (& **fonts** too). We advice developing the frontend in isolation, so these directories should only contain production-ready scripts (e.g. minified & concatenated).

### lumberjack

This is where the magic happens. It comes bootstrapped with all sorts of goodies out the box, and can also be extended with ease.

The bootstrapping is triggered in `functions.php`, and from there it autoloads any classes under the `Lumberjack` namespace that are being referenced in our code.

**bootstrap.php**

This file sets up all of the base functionality, such as:

- Custom Post Types
- Custom Taxonomies
- Theme Support
- Adds useful fields to the default Timber `$context`
- Includes useful Wordpress functions

We see this file as a starting point, and can be changed depending on the site's requirements. The aim was to keep this file as close to vanilla PHP as possible with minimal 'magic'.

**autoload.php**

It's unlikely that you'll need to change this file. It's responsible for trying to load a namepsaced class. See [autoloader examples](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader-examples.md)

It will attempt to load a class under the `Lumberjack` namespace only. If you need a secondary namespace, you'll need to revisit the implementation.

**src/Core**

These classes are the bread and butter of Lumberjack and contain the base classes used throughout the theme. Typically, they’ll extend Timber too. The main file here is `Core/Site.php`, which extends `Timber\Site`. This lets us add our own data to the global context and bring in any Twig extensions if needed.

When creating new classes in this directory, ensure they are under the `Lumberjack\Core` namespace. We're using static methods on these classes for 1 main reason:

They're not really objects in their own right, and therefore instantiating it doesn't make any sense. For example:

```php
// Bad
$themeSupport = new \Lumberjack\Core\ThemeSupport;
$themeSupport->register();

// Good
\Lumberjack\Core\ThemeSupport::register();
```
**src/Config**

This is where you would register any configurations with WordPress, such as any custom post types, menus, taxonomies and theme support. These are just normal PHP classes, no fancy extending here.

Again, we do not care about state with these so every method is static.

Taking `CustomPostTypes` as an example, it has a `register()` method which simply hooks into the WordPress action `init`, and will run the `types()` method. This will then register any custom post types. This file has one already defined as an example.

**src/PostTypes**

If you have defined any custom post types in `Lumberjack\Config\CustomPostTypes`, you'll need to create a new class here. There's already a `Post.php` class which extends Timber's [Timber\Post](http://timber.github.io/timber/#timber-post).

These files act like **models**, in as much as they should be the single point of access when interacting with the post type.

Because we're using Timber and Twig, we need to ensure our custom post type is available to our views. Out of the box, Timber provides you with 2 ways to interact with posts:

```php
// Getting a single post
// You can optionally pass in a Post ID too, which will do a query
$context['post'] = new Timber\Post(); // Create a new object to work with an existing WordPress post. When inside the loop you can safely use no arguments. Timber will figure out what post you're talking about based on the magic of WordPress

// Getting posts (optionally pass in a WP_QUERY)
$context['posts'] = Timber\Timber::get_posts(); // Grab posts from the_loop
```

This works fine, but say you have a method on a custom post type that you want to use in your view (e.g. `getInitials()` that returns an employees initials). By default, `Timber\Post` available in every view. But we can overwrite this by telling `Timber\Timber::get_posts()` we want it to return a new class for each post returned. This means that we can use our **Employee** model in our view instead of **Timber\Post** - which has the `getInitials()` method available.

`Lumberjack\PostTypes\Post` is set up to do this for us already. We've also added methods which will get you all posts or let you search for posts. For example, we can now do this:

```php
<?php

// Getting a single post
$context['post'] = new Lumberjack\PostTypes\Post();

// Getting posts
$context['posts'] = Lumberjack\PostTypes\Post::all(); // Grab posts from the\_loop

// Looking for draft posts
$args = [
    'post_status'   => 'draft',
];

$context['posts'] = Lumberjack\PostTypes\Post::posts($args);

?>
```

Now anything related to a post goes through our `Post` model. We've abstracted away Timber to make it more maintainable.

Creating a new post type is extremely easy. Take a look at `Project.php`, which is just an example. We extend our `Post` model, and simply define what the custom post type is called. Everything else is already handled for us.

```php
<?php

namespace Lumberjack\PostTypes;

class Project extends Post {

    protected static $postType = 'lumberjack_project';

} ?>
```

And now we can use this like so:

```php
<?php

// Getting a single post
$context['post'] = new Lumberjack\PostTypes\Project();

// Getting posts
$context['posts'] = Lumberjack\PostTypes\Project::all(); // Grab posts from the\_loop

// Looking for draft posts
$args = [
    'post_status' => 'draft',
];

$context['posts'] = Lumberjack\PostTypes\Project::posts($args);

?>
```

**src/Functions**

You know how every Wordpress website has a +1000 line `functions.php` file, with a complete mix of functions in?

Well no more! Instead, you should create a new class here. This forces you to group your functions in some way, which is better for maintainability and re-use.

Adding filters to change the way Wordpress handles thumbnail dimensions? Use a `ThumbnailDimensions` class. If you want to remove dimensions, then add a static `remove()` method to this class.

Inside if your method, you can simply call `add_filter` or `add_action` and pass in an anonymous function. No more declaring named functions and passing them in.

Here's an example:

```php
<?php

namespace Lumberjack\Functions;

class Assets
{
    /**
     * En-queue required assets
     *
     * @param  string  $filter   The name of the filter to hook into
     * @param  integer $priority The priority to attach the filter with
     */
    public static function load($filter = 'wp_enqueue_scripts', $priority = 10)
    {
        // Register the filter
        add_filter($filter, function ($paths) {
            wp_deregister_script('jquery');

            // Load CDN jQuery in the footer
            wp_register_script('jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', false, '1.11.3', true);

            wp_enqueue_script('jquery');
        }, $priority);
    }
} ?>
```

### views

This is the home for all the twig templates. These should be void of any business logic and should only care about rendering HTML.

The top level `.php` files, such as `page.php` and `single.php` are typically responsible for all the template logic and HTML rendering for a page or post. But this is messy, and it's better to separate the concerns.

Now, those top level files act as **View Controllers**. It's responsible for 2 things:

1. Deciding what twig template to render
2. Setting the correct context (data) for the template. E.g. Getting a list of posts.

**Custom Page Templates**

To create a new page template, you can look at `page--custom.php` for reference. The double hyphen here is intentional. It stops Wordpress matching `page-<name>.php` to a page's slug.

All you need to do is:
- Duplicate `page--custom.php`
- Set the template name
- Set (and create) the twig template
