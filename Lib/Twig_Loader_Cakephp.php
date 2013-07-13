<?php

class Twig_Loader_Cakephp implements Twig_LoaderInterface {

    public function getSource($name) {
        return file_get_contents($this->resolveFileName($name));
    }

    public function getCacheKey($name) {
        return $this->resolveFileName($name);
    }

    public function isFresh($name, $time) {
        return filemtime($this->resolveFileName($name)) < $time;
    }
    
    private function resolveFileName($name) {
        if (!file_exists($name)) {
            list($plugin, $file) = pluginSplit($name);
            return CakePlugin::path($plugin) . 'View' . DS . $file . TwigView::EXT;
        }
        return $name;
    }
}