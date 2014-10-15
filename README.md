# TwigView plugin for CakePHP #

[![Build Status](https://travis-ci.org/WyriHaximus/TwigView.png)](https://travis-ci.org/WyriHaximus/TwigView)
[![Latest Stable Version](https://poser.pugx.org/WyriHaximus/Twig-View/v/stable.png)](https://packagist.org/packages/WyriHaximus/Twig-View)
[![Total Downloads](https://poser.pugx.org/WyriHaximus/Twig-View/downloads.png)](https://packagist.org/packages/WyriHaximus/Twig-View)
[![Coverage Status](https://coveralls.io/repos/WyriHaximus/TwigView/badge.png)](https://coveralls.io/r/WyriHaximus/TwigView)
[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/WyriHaximus/twigview/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

This plugin for version 3 the [CakePHP Framework](http://cakephp.org) allows you to use the [Twig Templating Language](http://twig.sensiolabs.org) for your views.

In addition to enabling the use of most of Twig's features, the plugin is tightly integrated with the CakePHP view renderer giving you full access to helpers, objects and elements.

## Installation ##

Running the following composer command will install the TwigView to your project.

```bash
composer require "wyrihaximus/twig-view:dev-master"
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

(Note that you also have to do this for every Cell, a [PR](https://github.com/cakephp/app/pull/118) has been made to address that.)

## Elements ##

```jinja
{% element 'Plugin.Element' {
    dataName: 'dataValue'
} {
    optionName: 'optionValue'
} %}
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
* `debug` maps to `debug`
* `pr` maps to `pr`
* `low` maps to `low`
* `up` maps to `up`
* `env` maps to `env`
* `count` maps to `count`
* `pluralize` maps to `Cake\Utility\Inflector::pluralize`
* `singularize` maps to `Cake\Utility\Inflector::singularize`
* `camelize` maps to `Cake\Utility\Inflector::camelize`
* `underscore` maps to `Cake\Utility\Inflector::underscore`
* `humanize` maps to `Cake\Utility\Inflector::humanize`
* `tableize` maps to `Cake\Utility\Inflector::tableize`
* `classify` maps to `Cake\Utility\Inflector::classify`
* `variable` maps to `Cake\Utility\Inflector::variable`
* `slug` maps to `Cake\Utility\Inflector::slug`
* `toReadableSize` maps to `Cake\Utility\Number::toReadableSize`
* `fromReadableSize` maps to `Cake\Utility\Number::fromReadableSize`
* `toPercentage` maps to `Cake\Utility\Number::toPercentage`
* `format` maps to `Cake\Utility\Number::format`
* `formatDelta` maps to `Cake\Utility\Number::formatDelta`
* `currency` maps to `Cake\Utility\Number::currency`
* `substr` maps to `substr`
* `tokenize` maps to `Cake\Utility\String::tokenize`
* `insert` maps to `Cake\Utility\String::insert`
* `cleanInsert` maps to `Cake\Utility\String::cleanInsert`
* `wrap` maps to `Cake\Utility\String::wrap`
* `wordWrap` maps to `Cake\Utility\String::wordWrap`
* `highlight` maps to `Cake\Utility\String::highlight`
* `tail` maps to `Cake\Utility\String::tail`
* `truncate` maps to `Cake\Utility\String::truncate`
* `excerpt` maps to `Cake\Utility\String::excerpt`
* `toList` maps to `Cake\Utility\String::toList`
* `stripLinks` maps to `Cake\Utility\String::stripLinks`
* `isMultibyte` maps to `Cake\Utility\String::isMultibyte`
* `utf8` maps to `Cake\Utility\String::utf8`
* `ascii` maps to `Cake\Utility\String::ascii`
* `serialize` maps to `serialize`
* `unserialize` maps to `unserialize`
* `md5` maps to `md5`
* `base64_encode` maps to `base64_encode`
* `base64_decode` maps to `base64_decode`
* `nl2br` maps to `nl2br`
* `string` cast to `string`

## Functions ##
* `in_array` maps to `in_array`
* `explode` maps to `explode`
* `array` cast to array
* `array_push` maps to `push`
* `array_add` maps to `add`
* `array_prev` maps to `prev`
* `array_next` maps to `next`
* `array_current` maps to `current`
* `array_each` maps to `each`
* `__` maps to `__`
* `__d` maps to `__d`
* `__n` maps to `__n`
* `__dn` maps to `__dn`
* `defaultCurrency` maps to `Cake\Utility\Number::defaultCurrency`
* `number_formatter` maps to `Cake\Utility\Number::formatter`
* `uuid` maps to `Cake\Utility\String::uuid`
* `time` passed the first and optional second argument into `new \Cake\Utility\Time()`
* `timezones` maps to `Cake\Utility\Time::listTimezones`
* `elementExists` maps to `Cake\View\View::elementExists`,
* `getVars` maps to `Cake\View\View::getVars`
* `get` maps to `Cake\View\View::get`