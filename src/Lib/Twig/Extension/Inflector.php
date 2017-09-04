<?php declare(strict_types=1);
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

/**
 * Class Inflector.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
class Inflector extends AbstractExtension
{
    /**
     * Get filters for this extension.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFilters()
    {
        return [
            new \Twig\TwigFilter('pluralize', 'Cake\Utility\Inflector::pluralize'),
            new \Twig\TwigFilter('singularize', 'Cake\Utility\Inflector::singularize'),
            new \Twig\TwigFilter('camelize', 'Cake\Utility\Inflector::camelize'),
            new \Twig\TwigFilter('underscore', 'Cake\Utility\Inflector::underscore'),
            new \Twig\TwigFilter('humanize', 'Cake\Utility\Inflector::humanize'),
            new \Twig\TwigFilter('tableize', 'Cake\Utility\Inflector::tableize'),
            new \Twig\TwigFilter('classify', 'Cake\Utility\Inflector::classify'),
            new \Twig\TwigFilter('variable', 'Cake\Utility\Inflector::variable'),
            new \Twig\TwigFilter('slug', 'Cake\Utility\Text::slug'),
        ];
    }

    /**
     * Get extension name.
     *
     * @return string
     */
    public function getName()
    {
        return 'inflector';
    }
}
