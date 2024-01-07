# TwigView plugin for CakePHP #

![Build Status](https://github.com/cakephp/legacy-twig-view/actions/workflows/ci.yml/badge.svg?branch=master)
[![Latest Stable Version](https://img.shields.io/github/v/release/cakephp/legacy-twig-view?sort=semver&style=flat-square)](https://packagist.org/packages/wyrihaximus/twig-view)
[![Total Downloads](https://img.shields.io/packagist/dt/wyrihaximus/twig-view?style=flat-square)](https://packagist.org/packages/wyrihaximus/twig-view/stats)
[![Code Coverage](https://img.shields.io/coveralls/cakephp/legacy-twig-view/master.svg?style=flat-square)](https://coveralls.io/r/cakephp/legacy-twig-view?branch=master)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)

This plugin allows you to use the [Twig Templating Language](http://twig.sensiolabs.org) for your views.

In addition to enabling the use of most of Twig's features, the plugin is tightly integrated with the CakePHP view renderer giving you full access to helpers, objects and elements.

DEPRECATED: Use [cakephp/twig-view](https://github.com/cakephp/twig-view) instead.

## Installation ##

To install via [Composer](https://getcomposer.org/), use the command below.

```bash
composer require wyrihaximus/twig-view
```

## Configuration ##

### Load Plugin
Run the following CLI command:

```sh
bin/cake plugin load WyriHaximus/TwigView
```

### Use View class
Instead of extending from the `View` let `AppView` extend `TwigView`:

```php
namespace App\View;

use WyriHaximus\TwigView\View\TwigView;

class AppView extends TwigView
{
}
```

## Quick Start

TwigView will look for its templates with the extension `.twig`.

### Layout
Replace `templates/layout/default.php` by this `templates/layout/default.twig`

``` twig
<!DOCTYPE html>
<html>
<head>
    {{ Html.charset()|raw }}

    <title>
        {{ __('myTwigExample') }}
        {{ _view.fetch('title')|raw }}
    </title>

    {{ Html.meta('icon')|raw }}

    {{ Html.css('default.app.css')|raw }}
    {{ Html.script('app')|raw }}

    {{ _view.fetch('meta')|raw }}
    {{ _view.fetch('css')|raw }}
    {{ _view.fetch('script')|raw }}
</head>
<body>
    <header>
        {{ _view.fetch('header')|raw }}
    </header>

    {{ Flash.render()|raw }}

    <section>

        <h1>{{ _view.fetch('title')|raw }}</h1>

        {{ _view.fetch('content')|raw }}
    </section>

    <footer>
        {{ _view.fetch('footer')|raw }}
    </footer>
</body>
</html>
```

### Template View
Create a template, for example `templates/Users/index.twig` like this
```Twig
{{ _view.assign('title', __("I'm title")) }}

{{ _view.start('header') }}
    <p>I'm header</p>
{{ _view.end() }}

{{ _view.start('footer') }}
    <p>I'm footer</p>
{{ _view.end() }}

<p>I'm content</p>
```

## Usage

### Use `$this`
With twig `$this` is replaced by `_view`

For example, without using Twig writing
```php
<?= $this->fetch('content') ?>
```
But with Twig
```twig
{{ _view.fetch('content')|raw }}
```
### Helpers

Any helper can be access by their CamelCase name, for example:

```twig
{{ Html.link('Edit user', {'controller':'Users', 'action': 'edit' ~ '/' ~ user.id}, {'class':'myclass'})|raw }}
```

### Elements
Basic
```Twig
{% element 'Element' %}
```
With variables or options
```Twig
{% element 'Plugin.Element' {
    dataName: 'dataValue'
} {
    optionName: 'optionValue'
} %}
```

### Cells

Store in context then echo it
```twig
{% cell cellObject = 'Plugin.Cell' {
    dataName: 'dataValue'
} {
    optionName: 'optionValue'
} %}

{{ cellObject|raw }}
```

Fetch and directly echo it
```twig
{% cell 'Plugin.Cell' {
    dataName: 'dataValue'
} {
    optionName: 'optionValue'
} %}
```

### Extends
If i want extend to `Common/demo.twig`
```twig
<div id="sidebar">
    {% block sidebar %}{% endblock %}
</div>

<div id="content">
    {% block body %}{% endblock %}
</div>
```
We can write in a view
```twig
{% extends 'Common/demo' %}

{% block sidebar %}
    <ul>
        <li>Item 1</li>
        <li>Item 2</li>
        <li>Item 3</li>
    </ul>
{% endblock %}

{% block body %}

    {{ _view.assign('title', __("I'm title")) }}

    {{ _view.start('header') }}
        <p>I'm header</p>
    {{ _view.end() }}

    {{ _view.start('footer') }}
        <p>I'm footer</p>
    {{ _view.end() }}

    <p>I'm content</p>
{% endblock %}
```

**Note : the block `body` is required, it's equivalent to `<?= $this->fetch('content') ?>`**

### Filters
* `debug` maps to [`debug`](https://book.cakephp.org/4/en/development/debugging.html#basic-debugging)
* `pr` maps to `pr`
* `low` maps to [`strtolower`](https://php.net/strtolower)
* `up` maps to [`strtoupper`](https://php.net/strtoupper)
* `env` maps to [`env`](https://book.cakephp.org/4/en/core-libraries/global-constants-and-functions.html#global-functions)
* `count` maps to [`count`](https://php.net/count)
* `pluralize` maps to [`Cake\Utility\Inflector::pluralize`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::pluralize)
* `singularize` maps to [`Cake\Utility\Inflector::singularize`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::singularize)
* `camelize` maps to [`Cake\Utility\Inflector::camelize`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::camelize)
* `underscore` maps to [`Cake\Utility\Inflector::underscore`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::underscore)
* `humanize` maps to [`Cake\Utility\Inflector::humanize`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::humanize)
* `tableize` maps to [`Cake\Utility\Inflector::tableize`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::tableize)
* `classify` maps to [`Cake\Utility\Inflector::classify`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::classify)
* `variable` maps to [`Cake\Utility\Inflector::variable`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::variable)
* `slug` maps to [`Cake\Utility\Inflector::slug`](https://book.cakephp.org/4/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::slug)
* `toReadableSize` maps to [`Cake\I18n\Number::toReadableSize`](https://book.cakephp.org/4/en/core-libraries/number.html#Cake\\I18n\\Number::toReadableSize)
* `toPercentage` maps to [`Cake\I18n\Number::toPercentage`](https://book.cakephp.org/4/en/core-libraries/number.html#Cake\\I18n\\Number::toPercentage)
* `number_format` maps to [`Cake\I18n\Number::format`](https://book.cakephp.org/4/en/core-libraries/number.html#Cake\\I18n\\Number::format)
* `formatDelta` maps to [`Cake\I18n\Number::formatDelta`](https://book.cakephp.org/4/en/core-libraries/number.html#Cake\\I18n\\Number::formatDelta)
* `currency` maps to [`Cake\I18n\Number::currency`](https://book.cakephp.org/4/en/core-libraries/number.html#Cake\\I18n\\Number::currency)
* `substr` maps to [`substr`](https://php.net/substr)
* `tokenize` maps to [`Cake\Utility\Text::tokenize`](https://book.cakephp.org/4/en/core-libraries/text.html#simple-string-parsing)
* `insert` maps to [`Cake\Utility\Text::insert`](https://book.cakephp.org/4/en/core-libraries/text.html#formatting-strings)
* `cleanInsert` maps to [`Cake\Utility\Text::cleanInsert`](https://book.cakephp.org/4/en/core-libraries/text.html#formatting-strings)
* `wrap` maps to [`Cake\Utility\Text::wrap`](https://book.cakephp.org/4/en/core-libraries/text.html#wrapping-text)
* `wrapBlock` maps to [`Cake\Utility\Text::wrapBlock`](https://book.cakephp.org/4/en/core-libraries/text.html#wrapping-text)
* `wordWrap` maps to [`Cake\Utility\Text::wordWrap`](https://book.cakephp.org/4/en/core-libraries/text.html#wrapping-text)
* `highlight` maps to [`Cake\Utility\Text::highlight`](https://book.cakephp.org/4/en/core-libraries/text.html#highlighting-substrings)
* `tail` maps to [`Cake\Utility\Text::tail`](https://book.cakephp.org/4/en/core-libraries/text.html#truncating-the-tail-of-a-string)
* `truncate` maps to [`Cake\Utility\Text::truncate`](https://book.cakephp.org/4/en/core-libraries/text.html#truncating-text)
* `excerpt` maps to [`Cake\Utility\Text::excerpt`](https://book.cakephp.org/4/en/core-libraries/text.html#extracting-an-excerpt)
* `toList` maps to [`Cake\Utility\Text::toList`](https://book.cakephp.org/4/en/core-libraries/text.html#converting-an-array-to-sentence-)
* `stripLinks` maps to [`Cake\Utility\Text::stripLinks`](https://book.cakephp.org/4/en/core-libraries/text.html#removing-links)
* `isMultibyte` maps to `Cake\Utility\Text::isMultibyte`
* `utf8` maps to `Cake\Utility\Text::utf8`
* `ascii` maps to `Cake\Utility\Text::ascii`
* `parseFileSize` maps to [`Cake\Utility\Text::parseFileSize`](https://book.cakephp.org/4/en/core-libraries/text.html#simple-string-parsing)
* `serialize` maps to [`serialize`](https://php.net/serialize)
* `unserialize` maps to [`unserialize`](https://php.net/unserialize)
* `md5` maps to [`md5`](https://php.net/md5)
* `base64_encode` maps to [`base64_encode`](https://php.net/base64_encode)
* `base64_decode` maps to [`base64_decode`](https://php.net/base64_decode)
* `nl2br` maps to [`nl2br`](https://php.net/nl2br)
* `string` cast to [`string`](https://php.net/manual/en/language.types.type-juggling.php)

### Functions
* `in_array` maps to [`in_array`](https://php.net/in_array)
* `explode` maps to [`explode`](https://php.net/explode)
* `array` cast to [`array`](https://php.net/manual/en/language.types.type-juggling.php)
* `array_push` maps to [`push`](https://php.net/array_push)
* `array_prev` maps to [`prev`](https://php.net/prev)
* `array_next` maps to [`next`](https://php.net/next)
* `array_current` maps to [`current`](https://php.net/current)
* `__` maps to [`__`](https://book.cakephp.org/4/en/core-libraries/internationalization-and-localization.html)
* `__d` maps to [`__d`](https://book.cakephp.org/4/en/core-libraries/internationalization-and-localization.html)
* `__n` maps to [`__n`](https://book.cakephp.org/4/en/core-libraries/internationalization-and-localization.html)
* `__x` maps to [`__x`](https://book.cakephp.org/4/en/core-libraries/internationalization-and-localization.html)
* `__dn` maps to [`__dn`](https://book.cakephp.org/4/en/core-libraries/internationalization-and-localization.html)
* `defaultCurrency` maps to [`Cake\I18n\Number::defaultCurrency`](https://book.cakephp.org/4/en/core-libraries/number.html#Cake\\I18n\\Number::defaultCurrency)
* `number_formatter` maps to [`Cake\I18n\Number::formatter`](https://book.cakephp.org/4/en/core-libraries/number.html#Cake\\I18n\\Number::formatter)
* `uuid` maps to [`Cake\Utility\Text::uuid`](https://book.cakephp.org/4/en/core-libraries/text.html#generating-uuids)
* `time` passed the first and optional second argument into [`new \Cake\I18n\Time()`](https://book.cakephp.org/4/en/core-libraries/time.html#creating-time-instances)
* `timezones` maps to `Cake\I18n\Time::listTimezones`
* `elementExists` maps to `Cake\View\View::elementExists`,
* `getVars` maps to `Cake\View\View::getVars`
* `get` maps to `Cake\View\View::get`

### Twig
Visite [Twig Documentaion](http://twig.sensiolabs.org/documentation) for more tips

### Extra included extensions

* [jasny/twig-extensions](https://github.com/jasny/twig-extensions)
* [twig/markdown-extra](https://github.com/twigphp/markdown-extra)

## Events ##

This plugin emits several events.

### Loaders ###

The default loader can be replace by listening to the `WyriHaximus\TwigView\Event\LoaderEvent::EVENT`, for example with [twital](https://github.com/goetas/twital):

```php
<?php

use Cake\Event\EventListenerInterface;
use Goetas\Twital\TwitalLoader;
use WyriHaximus\TwigView\Event\ConstructEvent;
use WyriHaximus\TwigView\Event\LoaderEvent;

class LoaderListener implements EventListenerInterface
{
    public function implementedEvents(): array
    {
        return [
            LoaderEvent::EVENT => 'loader',
            ConstructEvent::EVENT => 'construct',
        ];
    }

    public function loader(LoaderEvent $event): void
    {
        $event->result = new TwitalLoader($event->getLoader());
    }

    /**
     * We've also listening in on this event so we can add the needed extensions to check for to the view
     */
    public function construct(ConstructEvent $event): void
    {
        $event->getTwigView()->unshiftExtension('.twital.html');
        $event->getTwigView()->unshiftExtension('.twital.xml');
        $event->getTwigView()->unshiftExtension('.twital.xhtml');
    }
}


```

### Extensions ###

Extensions can be added to the twig environment by listening to the `WyriHaximus\TwigView\Event\ConstructEvent::EVENT`, for example:

```php
<?php

use Cake\Event\EventListenerInterface;
use WyriHaximus\TwigView\Event\ConstructEvent;

class LoaderListener implements EventListenerInterface
{
    public function implementedEvents(): array
    {
        return [
            ConstructEvent::EVENT => 'construct',
        ];
    }

    public function construct(ConstructEvent $event): void
    {
        $event->getTwig()->addExtension(new YourTwigExtension);
    }
}

```

## Bake

You can use Bake to generate your basic CRUD views using the `theme` option.
Let's say you have a `TasksController` for which you want to generate twig templates.
You can use the following command to generate your index, add, edit and view file formatted
using Twig :

```bash
bin/cake bake twig_template Tasks all -t WyriHaximus/TwigView
```

## Screenshots ##

### Profiler ###

![Profiler](/docs/images/profiler.png)

### Templates found ###

![Templates found](/docs/images/templates-found.png)

## License ##

Copyright 2015 [Cees-Jan Kiewiet](https://wyrihaximus.net/)

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the "Software"), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.
