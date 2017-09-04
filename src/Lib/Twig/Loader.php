<?php declare(strict_types=1);
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
 * Class Loader.
 * @package WyriHaximus\TwigView\Lib\Twig
 */
class Loader implements \Twig_LoaderInterface, \Twig_SourceContextLoaderInterface
{
    /**
     * Get the file contents of a template.
     *
     * @param string $name Template.
     *
     * @return string
     */
    public function getSource($name)
    {
        $name = $this->resolveFileName($name);

        return file_get_contents($name);
    }

    /**
     * Returns the source context for a given template logical name.
     *
     * @param string $name The template logical name.
     *
     * @throws Twig_Error_Loader When $name is not found
     * @return Twig_Source
     *
     */
    public function getSourceContext($name)
    {
        $code = $this->getSource($name);
        $path = $this->getFilename($name);

        return new \Twig_Source($code, $name, $path);
    }

    /**
     * Get cache key for template.
     *
     * @param string $name Template.
     *
     * @return string
     */
    public function getCacheKey($name)
    {
        return $this->resolveFileName($name);
    }

    /**
     * Check if template is still fresh.
     *
     * @param string $name Template.
     * @param int    $time Timestamp.
     *
     * @return bool
     */
    public function isFresh($name, $time)
    {
        $name = $this->resolveFileName($name);

        return filemtime($name) < $time;
    }

    /**
     * Check if we have the source code of a template, given its name.
     *
     * @param string $name The name of the template to check if we can load.
     *
     * @return bool If the template source code is handled by this loader or not.
     */
    public function exists($name)
    {
        $filename = $this->getFilename($name);
        if ($filename === false) {
            return false;
        }

        return true;
    }

    /**
     * Resolve template name to filename.
     *
     * @param string $name Template.
     *
     * @throws \Twig_Error_Loader Thrown when template file isn't found.
     * @return string
     *
     */
    protected function resolveFileName($name)
    {
        $filename = $this->getFilename($name);
        if ($filename === false) {
            throw new \Twig_Error_Loader(sprintf('Template "%s" is not defined.', $name));
        }

        return $filename;
    }

    /**
     * Get template filename.
     *
     * @param string $name Template.
     *
     * @return string|false
     *
     */
    protected function getFilename($name)
    {
        if (file_exists($name)) {
            return $name;
        }

        list($plugin, $file) = pluginSplit($name);
        foreach ([null, $plugin] as $scope) {
            $paths = $this->getPaths($scope);
            foreach ($paths as $path) {
                $filePath = $path . $file;
                if (file_exists($filePath)) {
                    return $filePath;
                }

                $filePath = $path . $file . TwigView::EXT;
                if (file_exists($filePath)) {
                    return $filePath;
                }
            }
        }

        return false;
    }

    /**
     * Check if $plugin is active and return it's template paths or return the aps template paths.
     *
     * @param string|null $plugin The plugin in question.
     *
     * @return array
     */
    protected function getPaths($plugin)
    {
        if ($plugin === null || !Plugin::loaded($plugin)) {
            return App::path('Template');
        }

        return App::path('Template', $plugin);
    }
}
