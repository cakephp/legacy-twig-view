<?php

class Twig_Loader_Cakephp implements Twig_LoaderInterface {

/**
 * @{inheritDoc}
 */
    public function getSource($name) {
        $name = $this->resolveFileName($name);
        
        if(file_exists( $name ) !== false) {
            return file_get_contents($name);
        }
        
        throw new Twig_Error_Loader(sprintf('Template "%s" is not defined.', $name));
    }

/**
 * @{inheritDoc}
 */
    public function getCacheKey($name) {
        $name = $this->resolveFileName($name);
        
        if(file_exists( $name ) !== false) {
            return $name;
        }
        
        throw new Twig_Error_Loader(sprintf('Template "%s" is not defined.', $name));
    }

/**
 * @{inheritDoc}
 */
    public function isFresh($name, $time) {
        $name = $this->resolveFileName($name);
        
        if(file_exists( $name ) !== false) {
            return filemtime($name) < $time;
        }
        
        throw new Twig_Error_Loader(sprintf('Template "%s" is not defined.', $name));
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