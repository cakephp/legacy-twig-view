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
 * Class Strings.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
class Strings extends AbstractExtension
{
    /**
     * Get declared filters.
     *
     * @return \Twig\TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new \Twig\TwigFilter('substr', 'substr'),
            new \Twig\TwigFilter('tokenize', 'Cake\Utility\Text::tokenize'),
            new \Twig\TwigFilter('insert', 'Cake\Utility\Text::insert'),
            new \Twig\TwigFilter('cleanInsert', 'Cake\Utility\Text::cleanInsert'),
            new \Twig\TwigFilter('wrap', 'Cake\Utility\Text::wrap'),
            new \Twig\TwigFilter('wrapBlock', 'Cake\Utility\Text::wrapBlock'),
            new \Twig\TwigFilter('wordWrap', 'Cake\Utility\Text::wordWrap'),
            new \Twig\TwigFilter('highlight', 'Cake\Utility\Text::highlight'),
            new \Twig\TwigFilter('tail', 'Cake\Utility\Text::tail'),
            new \Twig\TwigFilter('truncate', 'Cake\Utility\Text::truncate'),
            new \Twig\TwigFilter('excerpt', 'Cake\Utility\Text::excerpt'),
            new \Twig\TwigFilter('toList', 'Cake\Utility\Text::toList'),
            new \Twig\TwigFilter('stripLinks', 'Cake\Utility\Text::stripLinks'),
            new \Twig\TwigFilter('isMultibyte', 'Cake\Utility\Text::isMultibyte'),
            new \Twig\TwigFilter('utf8', 'Cake\Utility\Text::utf8'),
            new \Twig\TwigFilter('ascii', 'Cake\Utility\Text::ascii'),
            new \Twig\TwigFilter('parseFileSize', 'Cake\Utility\Text::parseFileSize'),
            new \Twig\TwigFilter('none', function ($string) {
                return;
            }),
        ];
    }

    /**
     * Get declared functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('uuid', 'Cake\Utility\Text::uuid'),
        ];
    }

    /**
     * Get extension name.
     *
     * @return string
     */
    public function getName()
    {
        return 'string';
    }
}
