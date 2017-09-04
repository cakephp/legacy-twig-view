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
 * Class Basic.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
class Basic extends AbstractExtension
{
    /**
     * Get declared filters.
     *
     * @return \Twig\TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new \Twig\TwigFilter('debug', 'debug'),
            new \Twig\TwigFilter('pr', 'pr'),
            new \Twig\TwigFilter('low', 'low'),
            new \Twig\TwigFilter('up', 'up'),
            new \Twig\TwigFilter('env', 'env'),
            new \Twig\TwigFilter('count', 'count'),
            new \Twig\TwigFilter('h', 'h'),
            new \Twig\TwigFilter('null', function () {
                return '';
            }),
        ];
    }

    /**
     * Get extension name.
     *
     * @return string
     */
    public function getName()
    {
        return 'basic';
    }
}
