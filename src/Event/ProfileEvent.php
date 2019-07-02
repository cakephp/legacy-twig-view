<?php
declare(strict_types=1);

/**
 * This file is part of TwigView.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\TwigView\Event;

use Cake\Event\Event;
use Twig\Profiler\Profile;

final class ProfileEvent extends Event
{
    public const EVENT = 'TwigView.TwigView.profile';

    /**
     * @param  \Twig\Profiler\Profile $profile
     * @return static
     */
    public static function create(Profile $profile): ProfileEvent
    {
        return new static(static::EVENT, $profile);
    }

    /**
     * @return \Twig\Profiler\Profile
     */
    public function getLoader(): Profile
    {
        return $this->getSubject();
    }
}
