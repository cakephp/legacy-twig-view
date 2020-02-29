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

namespace Cake\TwigView\Lib\Twig;

use Cake\Core\App;
use Cake\Core\Plugin;
use Cake\TwigView\View\TwigView;
use Twig\Error\LoaderError;
use Twig\Loader\LoaderInterface;
use Twig\Source;

/**
 * Class Loader.
 */
final class Loader implements LoaderInterface
{
    /**
     * Get the file contents of a template.
     *
     * @param string $name Template.
     * @return string
     */
    public function getSource(string $name): string
    {
        $name = $this->resolveFileName($name);

        return file_get_contents($name);
    }

    /**
     * Returns the source context for a given template logical name.
     *
     * @param string $name The template logical name.
     * @return \Twig\Source
     */
    public function getSourceContext(string $name): Source
    {
        $code = $this->getSource($name);
        $path = $this->getFilename($name);

        return new Source($code, $name, $path);
    }

    /**
     * Get cache key for template.
     *
     * @param string $name Template.
     * @return string
     */
    public function getCacheKey(string $name): string
    {
        return $this->resolveFileName($name);
    }

    /**
     * Check if template is still fresh.
     *
     * @param string $name Template.
     * @param int $time Timestamp.
     *
     * @return bool
     */
    public function isFresh(string $name, int $time): bool
    {
        $name = $this->resolveFileName($name);

        return filemtime($name) < $time;
    }

    /**
     * Check if we have the source code of a template, given its name.
     *
     * @param string $name The name of the template to check if we can load.
     * @return bool If the template source code is handled by this loader or not.
     */
    public function exists(string $name): bool
    {
        $filename = $this->getFilename($name);
        if ($filename === '') {
            return false;
        }

        return true;
    }

    /**
     * Resolve template name to filename.
     *
     * @param string $name Template.
     * @throws \Twig\Error\LoaderError Thrown when template file isn't found.
     * @return string
     */
    private function resolveFileName(string $name): string
    {
        $filename = $this->getFilename($name);
        if ($filename === '') {
            throw new LoaderError(sprintf('Template "%s" is not defined.', $name));
        }

        return $filename;
    }

    /**
     * Get template filename.
     *
     * @param string $name Template.
     * @return string
     */
    private function getFilename(string $name): string
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

        return '';
    }

    /**
     * Check if $plugin is active and return it's template paths or return the aps template paths.
     *
     * @param string|null $plugin The plugin in question.
     * @return array
     */
    private function getPaths(?string $plugin): array
    {
        if ($plugin === null || !Plugin::isLoaded($plugin)) {
            return App::path('templates');
        }

        return [Plugin::templatePath($plugin)];
    }
}
