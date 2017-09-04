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
 * Class Arrays.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
class Arrays extends AbstractExtension
{
    /**
     * Get declared functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('in_array', 'in_array'),
            new \Twig\TwigFunction('explode', 'explode'),
            new \Twig\TwigFunction('array', function ($array) {
                return (array)$array;
            }),
            new \Twig\TwigFunction('array_push', 'push'),
            new \Twig\TwigFunction('array_add', 'add'),
            new \Twig\TwigFunction('array_prev', 'prev'),
            new \Twig\TwigFunction('array_next', 'next'),
            new \Twig\TwigFunction('array_current', 'current'),
            new \Twig\TwigFunction('array_each', 'each'),
        ];
    }

    /**
     * Get extension name.
     *
     * @return string
     */
    public function getName()
    {
        return 'array';
    }
}
