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

## Elements ##

```twig
{% element 'Plugin.Element' {
    dataName: 'dataValue'
} {
    optionName: 'optionValue'
} %}
```
