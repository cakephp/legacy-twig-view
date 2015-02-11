<?php

namespace WyriHaximus\TwigView\Lib;

use Cake\Core\Plugin;

/**
 * Class Scanner
 * @package WyriHaximus\TwigView\Lib
 */
class Scanner
{
    /**
     * Return all sections (app & plugins) with an Template directory.
     *
     * @return array
     */
    public static function all()
    {
        $sections = [];

        if (is_dir(APP . 'Template' . DIRECTORY_SEPARATOR)) {
            $sections['APP'] = static::iteratePath(APP);
        }

        foreach (static::pluginsWithTemplates() as $plugin) {
            $sections[$plugin] = static::iteratePath(Plugin::classPath($plugin));
        }

        return $sections;
    }

    /**
     * Finds all plugins with a Template directory.
     *
     * @return array
     */
    protected static function pluginsWithTemplates()
    {
        $plugins = Plugin::loaded();

        array_walk($plugins, function ($plugin, $index) use (&$plugins) {
            if (!is_dir(Plugin::classPath($plugin) . 'Template' . DIRECTORY_SEPARATOR)) {
                unset($plugins[$index]);
            }
        });

        return $plugins;
    }

    /**
     * Return all templates for a given plugin.
     *
     * @param string $plugin The plugin to find all templates for.
     *
     * @return mixed
     *
     * @throws \Exception Throws exception when the plugin doesn't contain a Template directory.
     */
    public static function plugin($plugin)
    {
        if (!is_dir(Plugin::classPath($plugin) . 'Template' . DIRECTORY_SEPARATOR)) {
            throw new \Exception('No Template directory found for plugin ' . $plugin);
        }

        return static::iteratePath(Plugin::classPath($plugin));
    }

    /**
     * Iterage over the given path and return all matching .tpl files in it.
     *
     * @param string $path Path to iterate over.
     *
     * @return array
     */
    protected static function iteratePath($path)
    {
        return static::walkIterator(static::setupIterator($path . 'Template' . DIRECTORY_SEPARATOR));
    }

    /**
     * Setup iterator for given path.
     *
     * @param string $path Path to setup iterator for.
     *
     * @return \Iterator
     */
    protected static function setupIterator($path)
    {
        return new \RegexIterator(new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                $path,
                \FilesystemIterator::KEY_AS_PATHNAME |
                \FilesystemIterator::CURRENT_AS_FILEINFO |
                \FilesystemIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::CHILD_FIRST,
            \RecursiveIteratorIterator::CATCH_GET_CHILD
        ), '/.*?.tpl$/', \RegexIterator::GET_MATCH);
    }

    /**
     * Walk over the iterator and compile all templates.
     *
     * @param \Iterator $iterator Iterator to walk.
     *
     * @return array
     */
    // @codingStandardsIgnoreStart
    protected static function walkIterator(\Iterator $iterator)
    {
        $paths = [];

        foreach ($iterator as $paths) {
            foreach ($paths as $path) {
                $paths[] = $path;
            }
        }

        return $paths;
    }
    // @codingStandardsIgnoreEnd
}
