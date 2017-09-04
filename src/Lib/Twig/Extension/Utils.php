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
 * Class Utils.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
class Utils extends AbstractExtension
{
    /**
     * Get declared filters.
     *
     * @return \Twig\TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new \Twig\TwigFilter('serialize', 'serialize'),
            new \Twig\TwigFilter('unserialize', 'unserialize'),
            new \Twig\TwigFilter('md5', 'md5'),
            new \Twig\TwigFilter('base64_encode', 'base64_encode'),
            new \Twig\TwigFilter('base64_decode', 'base64_decode'),
            new \Twig\TwigFilter('nl2br', 'nl2br'),
            new \Twig\TwigFilter('string', function ($str) {
                return (string)$str;
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
        return 'utils';
    }
}
