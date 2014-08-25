<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\TwigView\Lib\Twig;

use Cake\Core\App;
use Cake\Core\Plugin;
use WyriHaximus\TwigView\View\TwigView;

/**
 * Class Loader
 * @package WyriHaximus\TwigView\Lib\Twig
 */
class Loader implements \Twig_LoaderInterface {

/**
 * Get the file contents of a template
 *
 * @param string $name Template
 * @return string
 */
	public function getSource($name) {
		$name = $this->_resolveFileName($name);
		return file_get_contents($name);
	}

/**
 * Get cache key for template
 *
 * @param string $name Template
 * @return string
 */
	public function getCacheKey($name) {
		return $this->_resolveFileName($name);
	}

/**
 * Check if template is still fresh
 *
 * @param string $name Template
 * @param \timestamp $time Timestamp
 * @return bool
 */
	public function isFresh($name, $time) {
		$name = $this->_resolveFileName($name);
		return filemtime($name) < $time;
	}

/**
 * Resolve template name to filename
 *
 * @param string $name Template
 * @return string
 * @throws \Twig_Error_Loader
 */
	protected function _resolveFileName($name) {
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
