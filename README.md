[![framework](https://img.shields.io/github/release/rareloop/lumberjack-core.svg)](https://github.com/Rareloop/lumberjack/releases)
[![GitHub license](https://img.shields.io/github/license/rareloop/lumberjack.svg)](https://github.com/Rareloop/lumberjack/blob/master/LICENSE.txt)
![Downloads](https://img.shields.io/packagist/dt/rareloop/lumberjack-core.svg)


# [![Lumberjack Logo](https://lumberjack.rareloop.com/app/themes/lumberjack/assets/img/logo.svg?ver=1554110589)](http://lumberjack.rareloop.com)

**Supercharge your WordPress Development**

Lumberjack is a powerful MVC framework for the modern WordPress developer. Write better, more expressive and easier to maintain code.

## Who is Lumberjack for?

Coming from another PHP framework such as Laravel, have experience using Timber with WordPress but want more, or are just getting started with modern WordPress? Then Lumberjack is for you.

Use as little or as much as you need, it's beginner friendly!

## Documentation

The Lumberjack documentation can be found here:

[https://docs.lumberjack.rareloop.com](https://docs.lumberjack.rareloop.com)

For more information, check out the website:

[https://lumberjack.rareloop.com](https://lumberjack.rareloop.com)

## Getting Started

See the documentation for details on how to get started: [https://docs.lumberjack.rareloop.com/getting-started/installation](https://docs.lumberjack.rareloop.com/getting-started/installation)

## Built on strong foundations

Standing on the shoulders of giants, Lumberjack proudly builds on the great work of other open source WordPress projects.

- [Bedrock](https://roots.io/bedrock/docs/installing-bedrock/)
- [Timber](https://timber.github.io/docs/)

## Beautiful code. Easy to maintain

Object orientated and MVC patterns help keep your code structured and DRY.

**index.php**

```php
class IndexController
{
    public function handle()
    {
        $context = Timber::get_context();
        $context['posts'] = Post::whereStatus('publish')
            ->limit(5)
            ->get();

        return new TimberResponse('index.twig', $context);
    }
}
```

**index.twig**

```html
{% if posts is not empty %}
    <h4>Recent Articles</h4>
    <ul>
        {% for post in posts %}
            <li class="article">
                <h3>{{ $post->title }}</h3>
                {{ $post->preview }}
                <a href="{{ $post->link }}">Read the full story</a>
            </li>
        {% endfor %}
    </ul>
{% endif %}
```

## You're in good company

> Lumberjack is the deluxe version of what Modern WordPress should look like today. The team has done a great job of making it easy to build complicated custom applications while taking advantage of the best parts of WordPress.
>
> **_- Jared Novack - Timber creator_**

## Made by [Rareloop](https://rareloop.com)

We're a Digital Product Studio based in Southampton (UK) with many years experience working on modern WordPress websites. We design and build digital products for a range of clients, take a look at what else we can do.

[Find out more](https://rareloop.com)
