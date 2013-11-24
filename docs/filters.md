Filters
=======

## TwigView Custom Filters ##

This plugin comes with a couple of handy filters, just like 'trans', piping some core CakePHP functions into Twig templates.

### `ago` ###

Shortcut to TimeHelper::timeAgoInWords
	
```jinja
{{ user.created|ago }}
```

### `low` ###

Convert a string to lower case

```jinja
{{ 'FOO'|low }}
```

### `up` ###

Convert a string to upper case

```jinja
{{ 'foo'|up }}
```

### `debug` ###

Display the debug (pre+print_r) output

```jinja
{{ user|debug }}
```

### `pr` ###

Display just the print_r output

```jinja
{{ user|pr }}
```

### `env` ###

Display the value from a environment variable

```jinja
{{ 'HTTP_HOST'|env }}
```

### `size` ###

Convert byte integer to a human readable size

```jinja
{{ '3535839525'|size }}    //=> 3.29 GB
```

### `p` ###

Formats a number with a level of precision.

```jinja
{{ '0.555'|p(2) }}    //=> 0.56
```

### `curr` ###

Display floating point value as currency value. USD, GBP and EUR only

```jinja
{{ '5999'|curr }}         // default, $5,999.00
{{ '5999'|curr('GBP') }}  // £5,999.00
{{ '5999'|curr('EUR') }}  // €5.999,00
```

### `pct` ###

Formats a number into a percentage string.

```jinja
{{ '2.3'|pct }}    //=> 2.30%
```

## Twig Built-In Filters ##

For a list of available filters please refer to the [Twig Manual](http://twig.sensiolabs.org/doc/filters/index.html)