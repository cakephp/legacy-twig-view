<?php

use Twig\Extra\Markdown\DefaultMarkdown;

return [
    'WyriHaximus' => [
        'TwigView' => [
            'environment' => [
                // Anything you would pass into \Twig\Environment to overwrite the default settings, see: http://twig.sensiolabs.org/doc/api.html#environment-options
            ],
            'markdown' => [
                'engine' => 'engine', // See https://twig.symfony.com/doc/3.x/filters/markdown_to_html.html and then set to `new DefaultMarkdown()`
            ],
            'flags' => [
                'potentialDangerous' => false,
            ],
        ],
    ],
];
