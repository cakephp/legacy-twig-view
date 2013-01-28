<?php

class Twig_Loader_Cakephp implements Twig_LoaderInterface {

    public function getSource($name) {
        return file_get_contents($name);
    }

    public function getCacheKey($name) {
        return $name;
    }

    public function isFresh($name, $time) {
        return filemtime($name) < $time;
    }
}