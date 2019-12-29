<?php
declare(strict_types=1);

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
use Twig\Error\LoaderError;
use Twig\Loader\LoaderInterface;
use Twig\Source;
use WyriHaximus\TwigView\View\TwigView;

/**
 * Class Loader.
 * @package WyriHaximus\TwigView\Lib\Twig
 */
final class Loader implements LoaderInterface
{
    /**
     * Get the file contents of a template.
     *
     * @param string $name Template.
     *
     * @return string
     */
    public function getSource($name): string
    {
        $name = $this->resolveFileName($name);

        return file_get_contents($name);
    }

    /**
     * Returns the source context for a given template logical name.
     *
     * @param string $name The template logical name.
     *
     * @throws \WyriHaximus\TwigView\Lib\Twig\Twig\Error\Loader When $name is not found
     * @return \WyriHaximus\TwigView\Lib\Twig\Twig\Source
     *
     */
    public function getSourceContext($name): Source
    {
        $code = $this->getSource($name);
        $path = $this->getFilename($name);

        return new Source($code, $name, $path);
    }

    /**
     * Get cache key for template.
     *
     * @param string $name Template.
     *
     * @return string
     */
    public function getCacheKey($name): string
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
    public function isFresh($name, $time): bool
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
    public function exists($name): bool
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
     * @throws \Twig\Error\LoaderError Thrown when template file isn't found.
     * @return string
     *
     */
    private function resolveFileName($name): string
    {
        $filename = $this->getFilename($name);
        if ($filename === false) {
            throw new LoaderError(sprintf('Template "%s" is not defined.', $name));
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
    private function getFilename($name)
    {
        if (file_exists($name)) {
            return $name;
        }

        [$plugin, $file] = pluginSplit($name);
        foreach ([null, $plugin] as $scope) {
            $paths = $this->getPaths($scope);
            foreach ($paths as $path) {
                $filePath = $path . $file;
                if (is_file($filePath)) {
                    return $filePath;
                }

                $filePath = $path . $file . TwigView::EXT;
                if (is_file($filePath)) {
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
    private function getPaths($plugin): array
    {
        if ($plugin === null || !Plugin::loaded($plugin)) {
            return App::path('templates');
        }

        return [Plugin::templatePath($plugin)];
    }
}
