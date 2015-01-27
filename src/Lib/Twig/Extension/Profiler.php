<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\TwigView\Lib\Twig\Extension;

use DebugKit\DebugTimer;

/**
 * Class Basic
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
class Profiler extends \Twig_Extension_Profiler
{
    public function enter(\Twig_Profiler_Profile $profile)
    {
        $name = 'twig.template.' . $profile->getName();
        DebugTimer::start($name, __d('TwigView', $name));

        parent::enter($profile);
    }

    public function leave(\Twig_Profiler_Profile $profile)
    {
        parent::leave($profile);

        $name = 'twig.template.' . $profile->getName();
        DebugTimer::stop($name);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'twigview_profiler';
    }
}
