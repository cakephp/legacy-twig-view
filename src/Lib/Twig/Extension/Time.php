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
 * Class Time.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
class Time extends AbstractExtension
{
    /**
     * Get declared functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions()
    {
        return [
            new \Twig\TwigFunction('time', function ($time = null, $timezone = null) {
                return new \Cake\I18n\Time($time, $timezone);
            }),
            new \Twig\TwigFunction('timezones', 'Cake\I18n\Time::listTimezones'),
        ];
    }

    /**
     * Get extension name.
     *
     * @return string
     */
    public function getName()
    {
        return 'time';
    }
}
