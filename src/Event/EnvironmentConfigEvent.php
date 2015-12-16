<?php

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

class EnvironmentConfigEvent extends Event
{
    const EVENT = 'TwigView.TwigView.environment';

    /**
     * @param array $config
     *
     * @return static
     */
    public static function create(array $config)
    {
        return new static(static::EVENT, null, [
            'config' => $config,
        ]);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->data()['config'];
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->data['config'] = array_replace_recursive($this->data['config'], $config);
    }
}
