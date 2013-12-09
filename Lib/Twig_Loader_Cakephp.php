<?php

class Twig_Loader_Cakephp implements Twig_LoaderInterface {

/**
 * @{inheritDoc}
 */
    public function getSource($name) {
        return file_get_contents($this->resolveFileName($name));
    }

/**
 * @{inheritDoc}
 */
    public function getCacheKey($name) {
        return $this->resolveFileName($name);
    }

/**
 * @{inheritDoc}
 */
    public function isFresh($name, $time) {
        return filemtime($this->resolveFileName($name)) < $time;
    }

/**
 * @{inheritDoc}
 */
    private function resolveFileName($name) {
        if (file_exists($name)) {
			return $name;
        }

		list($plugin, $file) = pluginSplit($name);
		if ($plugin === null || !CakePlugin::loaded($plugin)) {
			return APP . 'View' . DS . $file . TwigView::EXT;
		}

		return CakePlugin::path($plugin) . 'View' . DS . $file . TwigView::EXT;
    }
}