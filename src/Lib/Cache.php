<?php
declare(strict_types=1);

namespace WyriHaximus\TwigView\Lib;

use Asm89\Twig\CacheExtension\CacheProviderInterface;
use Cake\Cache\Cache as CakeCache;

final class Cache implements CacheProviderInterface
{
    public const CACHE_PREFIX = 'twig-view-in-template-item-';

    /**
     * Retrieve data from the cache.
     *
     * @param string $identifier Identifier for this bit of data to read.
     *
     * @return mixed The cached data, or false if the data doesn't exist, has expired, or on error while fetching.
     */
    public function fetch($identifier)
    {
        [$config, $key] = $this->configSplit($identifier);

        return CakeCache::read(static::CACHE_PREFIX . $key, $config);
    }

    /**
     * Save data to the cache.
     *
     * @param string $identifier Identifier for this bit of data to write.
     * @param string $data       Data to cache.
     * @param int    $lifeTime   Time to life inside the cache.
     *
     * @return bool
     */
    public function save($identifier, $data, $lifeTime = 0): bool
    {
        [$config, $key] = $this->configSplit($identifier);

        return CakeCache::write(static::CACHE_PREFIX . $key, $data, $config);
    }

    /**
     * Extract $configName and $key from $name and $config.
     *
     * @param string $name   Name.
     * @param string $config Cache configuration name to used.
     *
     * @return array
     */
    protected function configSplit($name, $config = 'default'): array
    {
        if (strpos($name, ':') !== false) {
            $parts = explode(':', $name, 2);

            return $parts;
        }

        return [$config, $name];
    }
}
