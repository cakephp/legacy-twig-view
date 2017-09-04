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
 * Class Number.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
class Number extends AbstractExtension
{
    /**
     * Get declared functions.
     *
     * @return \Twig\TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new \Twig\TwigFilter('toReadableSize', 'Cake\I18n\Number::toReadableSize'),
            new \Twig\TwigFilter('fromReadableSize', 'Cake\I18n\Number::fromReadableSize'),
            new \Twig\TwigFilter('toPercentage', 'Cake\I18n\Number::toPercentage'),
            new \Twig\TwigFilter('format', 'Cake\I18n\Number::format'),
            new \Twig\TwigFilter('formatDelta', 'Cake\I18n\Number::formatDelta'),
            new \Twig\TwigFilter('currency', 'Cake\I18n\Number::currency'),
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
            new \Twig\TwigFunction('defaultCurrency', 'Cake\I18n\Number::defaultCurrency'),
            new \Twig\TwigFunction('number_formatter', 'Cake\I18n\Number::formatter'),
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
