# TwigView plugin for CakePHP #

[![Build Status](https://travis-ci.org/WyriHaximus/TwigView.png)](https://travis-ci.org/WyriHaximus/TwigView)
[![Latest Stable Version](https://poser.pugx.org/WyriHaximus/Twig-View/v/stable.png)](https://packagist.org/packages/WyriHaximus/Twig-View)
[![Total Downloads](https://poser.pugx.org/WyriHaximus/Twig-View/downloads.png)](https://packagist.org/packages/WyriHaximus/Twig-View)
[![Code Coverage](https://scrutinizer-ci.com/g/WyriHaximus/TwigView/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/WyriHaximus/TwigView/?branch=master)
[![License](https://poser.pugx.org/wyrihaximus/Twig-View/license.png)](https://packagist.org/packages/wyrihaximus/Twig-View)

This plugin for version 3 the [CakePHP Framework](http://cakephp.org) allows you to use the [Twig Templating Language](http://twig.sensiolabs.org) for your views.

In addition to enabling the use of most of Twig's features, the plugin is tightly integrated with the CakePHP view renderer giving you full access to helpers, objects and elements.

## Installation ##

To install via [Composer](http://getcomposer.org/), use the command below, it will automatically detect the latest version and bind it with `~`.

```bash
composer require wyrihaximus/twig-view 
```

## Bootstrap ##

Add the following to your `config/bootstrap.php` to load the plugin.

```php
Plugin::load('WyriHaximus/TwigView', [
    'bootstrap' => true,
]);
```

## Application wide usage ##

```php
class AppController extends Controller {
    public $viewClass = '\WyriHaximus\TwigView\View\TwigView';
}
```

## Elements ##

```jinja
{% element 'Plugin.Element' {
    dataName: 'dataValue'
} {
    optionName: 'optionValue'
} %}
```

## Helpers ##

Any helper you defined in your controller.

```php
public $helpers = ['Form'];
```

Can be access by their CamelCase name, for example creating a form using the `FormHelper`:

```jinja
{{ Form.create()|raw }}
```

## Cells ##

### Store in context then echo it ###
```jinja
{% cell cellObject = 'Plugin.Cell' {
    dataName: 'dataValue'
} {
    optionName: 'optionValue'
} %}

{{ cellObject|raw }}
```

### Fetch and directly echo it ###
```jinja
{% cell 'Plugin.Cell' {
    dataName: 'dataValue'
} {
    optionName: 'optionValue'
} %}
```

## Filters ##
* `debug` maps to [`debug`](http://book.cakephp.org/3.0/en/development/debugging.html#basic-debugging)
* `pr` maps to `pr`
* `low` maps to [`low`](http://php.net/low)
* `up` maps to [`up`](http://php.net/up)
* `env` maps to [`env`](http://php.net/env)
* `count` maps to [`count`](http://php.net/count)
* `pluralize` maps to [`Cake\Utility\Inflector::pluralize`](http://book.cakephp.org/3.0/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::pluralize)
* `singularize` maps to [`Cake\Utility\Inflector::singularize`](http://book.cakephp.org/3.0/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::singularize)
* `camelize` maps to [`Cake\Utility\Inflector::camelize`](http://book.cakephp.org/3.0/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::camelize)
* `underscore` maps to [`Cake\Utility\Inflector::underscore`](http://book.cakephp.org/3.0/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::underscore)
* `humanize` maps to [`Cake\Utility\Inflector::humanize`](http://book.cakephp.org/3.0/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::humanize)
* `tableize` maps to [`Cake\Utility\Inflector::tableize`](http://book.cakephp.org/3.0/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::tableize)
* `classify` maps to [`Cake\Utility\Inflector::classify`](http://book.cakephp.org/3.0/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::classify)
* `variable` maps to [`Cake\Utility\Inflector::variable`](http://book.cakephp.org/3.0/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::variable)
* `slug` maps to [`Cake\Utility\Inflector::slug`](http://book.cakephp.org/3.0/en/core-libraries/inflector.html#Cake\\Utility\\Inflector::slug)
* `toReadableSize` maps to [`Cake\I18n\Number::toReadableSize`](http://book.cakephp.org/3.0/en/core-libraries/number.html#Cake\\I18n\\Number::toReadableSize)
* `fromReadableSize` maps to [`Cake\I18n\Number::fromReadableSize`](http://book.cakephp.org/3.0/en/core-libraries/number.html#Cake\\I18n\\Number::fromReadableSize)
* `toPercentage` maps to [`Cake\I18n\Number::toPercentage`](http://book.cakephp.org/3.0/en/core-libraries/number.html#Cake\\I18n\\Number::toPercentage)
* `format` maps to [`Cake\I18n\Number::format`](http://book.cakephp.org/3.0/en/core-libraries/number.html#Cake\\I18n\\Number::format)
* `formatDelta` maps to [`Cake\I18n\Number::formatDelta`](http://book.cakephp.org/3.0/en/core-libraries/number.html#Cake\\I18n\\Number::formatDelta)
* `currency` maps to [`Cake\I18n\Number::currency`](http://book.cakephp.org/3.0/en/core-libraries/number.html#Cake\\I18n\\Number::currency)
* `substr` maps to [`substr`](http://php.net/substr)
* `tokenize` maps to [`Cake\Utility\String::tokenize`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::tokenize)
* `insert` maps to [`Cake\Utility\String::insert`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::insert)
* `cleanInsert` maps to [`Cake\Utility\String::cleanInsert`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::cleanInsert)
* `wrap` maps to [`Cake\Utility\String::wrap`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::wrap)
* `wordWrap` maps to [`Cake\Utility\String::wordWrap`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::wordWrap)
* `highlight` maps to [`Cake\Utility\String::highlight`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::highlight)
* `tail` maps to [`Cake\Utility\String::tail`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::tail)
* `truncate` maps to [`Cake\Utility\String::truncate`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::truncate)
* `excerpt` maps to [`Cake\Utility\String::excerpt`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::excerpt)
* `toList` maps to [`Cake\Utility\String::toList`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::toList)
* `stripLinks` maps to [`Cake\Utility\String::stripLinks`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::stripLinks)
* `isMultibyte` maps to [`Cake\Utility\String::isMultibyte`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::isMultibyte)
* `utf8` maps to [`Cake\Utility\String::utf8`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::utf8)
* `ascii` maps to [`Cake\Utility\String::ascii`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::ascii)
* `serialize` maps to [`serialize`](http://php.net/serialize)
* `unserialize` maps to [`unserialize`](http://php.net/unserialize)
* `md5` maps to [`md5`](http://php.net/md5)
* `base64_encode` maps to [`base64_encode`](http://php.net/base64_encode)
* `base64_decode` maps to [`base64_decode`](http://php.net/base64_decode)
* `nl2br` maps to [`nl2br`](http://php.net/nl2br)
* `string` cast to [`string`](http://php.net/manual/en/language.types.type-juggling.php)

## Functions ##
* `in_array` maps to [`in_array`](http://php.net/in_array)
* `explode` maps to [`explode`](http://php.net/explode)
* `array` cast to [`array`](http://php.net/manual/en/language.types.type-juggling.php)
* `array_push` maps to [`push`](http://php.net/push)
* `array_add` maps to [`add`](http://php.net/add)
* `array_prev` maps to [`prev`](http://php.net/prev)
* `array_next` maps to [`next`](http://php.net/next)
* `array_current` maps to [`current`](http://php.net/current)
* `array_each` maps to [`each`](http://php.net/each)
* `__` maps to [`__`](http://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html)
* `__d` maps to [`__d`](http://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html)
* `__n` maps to [`__n`](http://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html)
* `__x` maps to [`__x`](http://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html)
* `__dn` maps to [`__dn`](http://book.cakephp.org/3.0/en/core-libraries/internationalization-and-localization.html)
* `defaultCurrency` maps to [`Cake\I18n\Number::defaultCurrency`](http://book.cakephp.org/3.0/en/core-libraries/number.html#Cake\\I18n\\Number::defaultCurrency)
* `number_formatter` maps to [`Cake\I18n\Number::formatter`](http://book.cakephp.org/3.0/en/core-libraries/number.html#Cake\\I18n\\Number::formatter)
* `uuid` maps to [`Cake\Utility\String::uuid`](http://book.cakephp.org/3.0/en/core-libraries/string.html#Cake\\Utility\\String::uuid)
* `time` passed the first and optional second argument into [`new \Cake\I18n\Time()`](http://book.cakephp.org/3.0/en/core-libraries/time.html#creating-time-instances)
* `timezones` maps to `Cake\I18n\Time::listTimezones`
* `elementExists` maps to `Cake\View\View::elementExists`,
* `getVars` maps to `Cake\View\View::getVars`
* `get` maps to `Cake\View\View::get`

## Screenshots ##

### Profiler ###

![Profiler](/docs/images/profiler.png)

### Templates found ###

![Templates found](/docs/images/templates-found.png)

## License ##

Copyright 2014 [Cees-Jan Kiewiet](http://wyrihaximus.net/)

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
