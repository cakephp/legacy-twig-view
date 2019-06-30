<?php
declare(strict_types=1);

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\TwigView\Lib\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class Inflector.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
final class Inflector extends AbstractExtension
{
    /**
     * Get filters for this extension.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('pluralize', 'Cake\Utility\Inflector::pluralize'),
            new TwigFilter('singularize', 'Cake\Utility\Inflector::singularize'),
            new TwigFilter('camelize', 'Cake\Utility\Inflector::camelize'),
            new TwigFilter('underscore', 'Cake\Utility\Inflector::underscore'),
            new TwigFilter('humanize', 'Cake\Utility\Inflector::humanize'),
            new TwigFilter('tableize', 'Cake\Utility\Inflector::tableize'),
            new TwigFilter('classify', 'Cake\Utility\Inflector::classify'),
            new TwigFilter('variable', 'Cake\Utility\Inflector::variable'),
            new TwigFilter('dasherize', 'Cake\Utility\Inflector::dasherize'),
            new TwigFilter('slug', 'Cake\Utility\Text::slug'),
        ];
    }

    /**
     * Get extension name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'inflector';
    }
}
