<?php

namespace WyriHaximus\TwigView\Lib;

use Asm89\Twig\CacheExtension\CacheProviderInterface;
use Cake\Cache\Cache as CakeCache;

class Cache implements CacheProviderInterface
{
    const CACHE_PREFIX = 'twig-view-in-template-item-';

    public function fetch($id)
    {
        list($config, $key) = $this->configSplit($id);
        return CakeCache::read(static::CACHE_PREFIX . $key, $config);
    }

    protected function configSplit($name, $config = 'default')
    {
        if (strpos($name, ':') !== false) {
            $parts = explode(':', $name, 2);
            return $parts;
        }
        return [$config, $name];
    }

    public function save($id, $data, $lifeTime = 0)
    {
        list($config, $key) = $this->configSplit($id);
        return CakeCache::write(static::CACHE_PREFIX . $key, $data, $config);
    }
}
