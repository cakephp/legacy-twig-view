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
 * Class I18n.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
class I18n extends AbstractExtension
{
    /**
     * Get declared functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('__', '__'),
            new \Twig\TwigFunction('__d', '__d'),
            new \Twig\TwigFunction('__n', '__n'),
            new \Twig\TwigFunction('__x', '__x'),
            new \Twig\TwigFunction('__dn', '__dn'),
        ];
    }

    /**
     * Get extension name.
     *
     * @return string
     */
    public function getName()
    {
        return 'i18n';
    }
}
