<?php

namespace WyriHaximus\TwigView\Lib\Doctrine;

use Cake\Cache\Cache;
use Doctrine\Common\Cache\Cache as DoctrineCache;

class CakeCache implements DoctrineCache
{
    const CACHE_PREFIX = '';

    public function fetch($id)
    {
        list($config, $key) = $this->configSplit($id);
        return Cache::read(static::CACHE_PREFIX . $key, $config);
    }

    public function contains($id)
    {
        list($config, $key) = $this->configSplit($id);
        return (bool) Cache::read(static::CACHE_PREFIX . $key, $config);
    }


    public function save($id, $data, $lifeTime = 0)
    {
        list($config, $key) = $this->configSplit($id);
        return Cache::write(static::CACHE_PREFIX . $key, $data, $config);
    }


    public function delete($id)
    {
        list($config, $key) = $this->configSplit($id);
        return Cache::delete(static::CACHE_PREFIX . $key, $config);
    }

    public function getStats()
    {
        //
    }

    protected function configSplit($name, $config = 'default') {
        if (strpos($name, ':') !== false) {
            $parts = explode(':', $name, 2);
            return $parts;
        }
        return [$config, $name];
    }
}