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
use Twig\TwigFunction;

/**
 * Class Strings.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
final class Strings extends AbstractExtension
{
    /**
     * Get declared filters.
     *
     * @return \Twig\TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('substr', 'substr'),
            new TwigFilter('tokenize', 'Cake\Utility\Text::tokenize'),
            new TwigFilter('insert', 'Cake\Utility\Text::insert'),
            new TwigFilter('cleanInsert', 'Cake\Utility\Text::cleanInsert'),
            new TwigFilter('wrap', 'Cake\Utility\Text::wrap'),
            new TwigFilter('wrapBlock', 'Cake\Utility\Text::wrapBlock'),
            new TwigFilter('wordWrap', 'Cake\Utility\Text::wordWrap'),
            new TwigFilter('highlight', 'Cake\Utility\Text::highlight'),
            new TwigFilter('tail', 'Cake\Utility\Text::tail'),
            new TwigFilter('truncate', 'Cake\Utility\Text::truncate'),
            new TwigFilter('excerpt', 'Cake\Utility\Text::excerpt'),
            new TwigFilter('toList', 'Cake\Utility\Text::toList'),
            new TwigFilter('isMultibyte', 'Cake\Utility\Text::isMultibyte'),
            new TwigFilter('utf8', 'Cake\Utility\Text::utf8'),
            new TwigFilter('ascii', 'Cake\Utility\Text::ascii'),
            new TwigFilter('parseFileSize', 'Cake\Utility\Text::parseFileSize'),
            new TwigFilter('none', function ($string) {
                return;
            }),
        ];
    }

    /**
     * Get declared functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('uuid', 'Cake\Utility\Text::uuid'),
            new TwigFunction('sprintf', 'sprintf'),
        ];
    }

    /**
     * Get extension name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'string';
    }
}
