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

use DebugKit\DebugTimer;
use Twig\Extension\ProfilerExtension;
use Twig\Profiler\Profile;

/**
 * Class Basic.
 * @package WyriHaximus\TwigView\Lib\Twig\Extension
 */
final class Profiler extends ProfilerExtension
{
    /**
     * Enter $profile.
     *
     * @param \Twig\Profiler\Profile $profile Profile.
     */
    public function enter(Profile $profile)
    {
        $name = 'Twig Template: ' . substr($profile->getName(), strlen(ROOT) + 1);
        DebugTimer::start($name, __d('twig_view', $name));

        parent::enter($profile);
    }

    /**
     * Leave $profile.
     *
     * @param \Twig\Profiler\Profile $profile Profile.
     */
    public function leave(Profile $profile)
    {
        parent::leave($profile);

        $name = 'Twig Template: ' . substr($profile->getName(), strlen(ROOT) + 1);
        DebugTimer::stop($name);
    }
}
