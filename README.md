# TwigView plugin for CakePHP #

[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/WyriHaximus/twigview/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

This plugin for the [CakePHP Framework](http://cakephp.org) allows you to use the [Twig Templating Language](http://twig.sensiolabs.org) for your views.

In addition to enabling the use of most of Twig's features, the plugin is tightly integrated with the CakePHP view renderer giving you full access to helpers, objects and elements.

## Installation ##

Download the repository, create a folder called `TwigView` in your `plugins` folder. Extract.

Alternatively: Just clone the repository directly into your app.

```bash
$ cd app/Plugin
$ git clone git://github.com/WyriHaximus/TwigView.git TwigView
```

### Vendor Files ###

Download the [Twig Library](http://twig.sensiolabs.org/) and move `(archive)/*` to `APP/Plugin/TwigView/Vendor/Twig`.

Alternatively: Just init the submodules of this repository. This will grab the latest version.

```bash
$ git submodule update --init
```

### Cache Permissions ###

Make the default view-cache folder writeable.

	APP/Plugin/TwigView/tmp/views

Alternatively: Set where you want cache files to be stored.

```php
define('TWIG_VIEW_CACHE', APP . 'tmp');
```

## Using the View Class ##

To make CakePHP aware of TwigView edit your `APP/Controller/AppController.php` file and add the following:

```php
class AppController extends Controller  {
	public $viewClass = 'TwigView.Twig';
}
```

Be sure to load the TwigView plugin in your bootstrap.php file with:

```php
CakePlugin::load('TwigView', array('bootstrap' => true));
```

or:

```php
CakePlugin::loadAll();
```

Now start creating view files using the `.tpl` extension.

## Default Layouts ##

This plugin comes with all default layouts converted to Twig. Examples can be found in:

	APP/Plugin/TwigView/examples

## Themes ##

The plugin has support for themes and works just like the `Theme` view. Simply add the `$theme` property to your controller and you're set.

```php
class AppController extends Controller  {
	public $viewClass = 'TwigView.Twig';
	public $theme = 'Rockstar';
}
```

This will cause the view to also look in the `Themed` folder for templates. In the above example templates in the following directory are favored over their non-themed version.

	APP/View/Themed/Rockstar/

If you, for example, want to overwrite the `Layouts/default.tpl` file in the `Rockstar` theme, then create this file:

	APP/View/Themed/Rockstar/Layouts/default.tpl

## Using Helpers inside Templates ##

All helper objects are available inside a view and can be used like any other variable inside Twig.

```jinja
{{ time.nice(user.created) }}
```

... where ...

```jinja
{{ time.nice(user.created) }}
    ^    ^    ^    ^____key
    |    |    |____array (from $this->set() or loop)
    |    |_____ method
    |______ helper
```

Which is the equivalent of writing:

```php
<?php echo $this->Time->nice($user['created']); ?>
```

A more complex example, FormHelper inputs:

```jinja
{{
  form.input('message', {
    'label': 'Your message',
    'error': {
      'notempty': 'Please enter a message'
    }
  })
}}
```

## Referencing View Elements ##

Elements must be `.tpl` files and are parsed as Twig templates. Using `.ctp` is not possible.

In exchange for this limitation you can import elements as easy as this:

```jinja
{{ _view.element('Plugin.element') }}
```

## Translating Strings ##

The `trans` filter can be used on any string and simply takes the preceding string and passes it through the `__()` function.

```jinja
{{
  form.input('email', {
    'label': 'Your E-Mail Address'| trans
  })
}}
````

This is the equivalent of writing:

```php
<?php echo $this->Form->input('email', array(
   'label' => __("Your E-Mail Address")
)); ?>
```

## Translating multiple lines ##

The trans-block element will help you with that. This is especially useful when writing email templates using Twig.

```jinja
{% trans %}
Hello!

This is my mail body and i can translate it in X languages now.
We love it!
{% endtrans %}
```

## Accessing View Instance ##

In some cases it is useful to access `$this`, for example to build a DOM id from the current controller and action name.

The object is accessible through `_view`.

```jinja
<div class="default" id="{{ _view.name|lower ~ '_' ~ _view.action|lower }}">
```

## Precompiling all templates ##

Twig has to compile all the templates before they can be used. This adds a one time per template delay to the loading of a page. This can be countered by using the Compile Templates shell command. This commands scans for all the templates and compiles them with Twig for caching and performence gains.

```bash
./cake TwigView.compile_templates all
```

