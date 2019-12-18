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
 * Class Number.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
final class Number extends AbstractExtension
{
    /**
     * Get declared functions.
     *
     * @return \Twig\TwigFilter[]
     */
    public function getFilters(): array
    {
        return [
            new TwigFilter('toReadableSize', 'Cake\I18n\Number::toReadableSize'),
            new TwigFilter('fromReadableSize', 'Cake\I18n\Number::fromReadableSize'),
            new TwigFilter('toPercentage', 'Cake\I18n\Number::toPercentage'),
            new TwigFilter('number_format', 'Cake\I18n\Number::format'),
            new TwigFilter('formatDelta', 'Cake\I18n\Number::formatDelta'),
            new TwigFilter('currency', 'Cake\I18n\Number::currency'),
            new TwigFilter('toReadableSize', 'Cake\I18n\Number::toReadableSize'),
            new TwigFilter('fromReadableSize', 'Cake\I18n\Number::fromReadableSize'),
            new TwigFilter('toPercentage', 'Cake\I18n\Number::toPercentage'),
            new TwigFilter('format', 'Cake\I18n\Number::format'),
            new TwigFilter('formatDelta', 'Cake\I18n\Number::formatDelta'),
            new TwigFilter('currency', 'Cake\I18n\Number::currency'),
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
            new TwigFunction('defaultCurrency', 'Cake\I18n\Number::defaultCurrency'),
            new TwigFunction('number_formatter', 'Cake\I18n\Number::formatter'),
        ];
    }

    /**
     * Get extension name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'number';
    }
}
