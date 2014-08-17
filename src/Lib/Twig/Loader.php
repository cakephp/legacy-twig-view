<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\CakePHP\TwigView\Lib\Twig;

use Cake\Core\App;
use Cake\Core\Plugin;
use WyriHaximus\CakePHP\TwigView\View\TwigView;

/**
 * Class Loader
 * @package WyriHaximus\CakePHP\TwigView\Lib\Twig
 */
class Loader implements \Twig_LoaderInterface {

    /**
     * @param string $name
     * @return string
     */
    public function getSource($name) {
        $name = $this->resolveFileName($name);
        return file_get_contents($name);
    }

    /**
     * @param string $name
     * @return string
     */
    public function getCacheKey($name) {
        return $this->resolveFileName($name);
    }

    /**
     * @param string $name
     * @param \timestamp $time
     * @return bool
     */
    public function isFresh($name, $time) {
        $name = $this->resolveFileName($name);
        return filemtime($name) < $time;
    }

    /**
     * @param $name
     * @return string
     * @throws \Twig_Error_Loader
     */
    private function resolveFileName($name) {
        if (file_exists($name)) {
			return $name;
        }

		list($plugin, $file) = pluginSplit($name);
		if ($plugin === null || !Plugin::loaded($plugin)) {
            $paths = App::path('Template');
            foreach ($paths as $path) {
                $filePath = $path . $file . TwigView::EXT;
                if (file_exists($filePath)) {
			        return $filePath;
                }
            }

            throw new \Twig_Error_Loader(sprintf('Template "%s" is not defined.', $name));
		}

        $filePath = Plugin::path($plugin) . 'Template' . DS . $file . TwigView::EXT;
        if (file_exists($filePath)) {
            return $filePath;
        }

        throw new \Twig_Error_Loader(sprintf('Template "%s" is not defined.', $name));
    }
}
