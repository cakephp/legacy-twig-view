<?php
declare(strict_types=1);

namespace WyriHaximus\TwigView\Lib;

use Cake\Core\App;
use Cake\Core\Plugin;
use FilesystemIterator;
use Iterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use WyriHaximus\TwigView\View\TwigView;

/**
 * Class Scanner.
 * @package WyriHaximus\TwigView\Lib
 */
final class Scanner
{
    /**
     * Return all sections (app & plugins) with an Template directory.
     *
     * @return array
     */
    public static function all(): array
    {
        $sections = [];

        foreach (App::path('templates') as $path) {
            if (is_dir($path)) {
                $sections['APP'] = $sections['APP'] ?? [];
                $sections['APP'] = array_merge($sections['APP'], static::iteratePath($path));
            }
        }

        foreach (static::pluginsWithTemplates() as $plugin) {
            $path = Plugin::templatePath($plugin);
            if (is_dir($path)) {
                $sections[$plugin] = $sections[$plugin] ?? [];
                $sections[$plugin] = array_merge($sections[$plugin], static::iteratePath($path));
            }
        }

        return static::clearEmptySections($sections);
    }

    /**
     * Return all templates for a given plugin.
     *
     * @param string $plugin The plugin to find all templates for.
     *
     * @return mixed
     */
    public static function plugin($plugin)
    {
        $path = Plugin::templatePath($plugin);
        $templates = static::iteratePath($path);

        return $templates;
    }

    /**
     * Check sections a remove the ones without anything in them.
     *
     * @param array $sections Sections to check.
     *
     * @return array
     */
    protected static function clearEmptySections(array $sections): array
    {
        array_walk($sections, function ($templates, $index) use (&$sections) {
            if (count($templates) == 0) {
                unset($sections[$index]);
            }
        });

        return $sections;
    }

    /**
     * Finds all plugins with a Template directory.
     *
     * @return array
     */
    protected static function pluginsWithTemplates(): array
    {
        $plugins = Plugin::loaded();

        array_walk($plugins, function ($plugin, $index) use (&$plugins) {
            $path = Plugin::templatePath($plugin);

            if (!is_dir($path)) {
                unset($plugins[$index]);
            }
        });

        return $plugins;
    }

    /**
     * Iterage over the given path and return all matching .tpl files in it.
     *
     * @param string $path Path to iterate over.
     *
     * @return array
     */
    protected static function iteratePath($path): array
    {
        return static::walkIterator(static::setupIterator($path));
    }

    /**
     * Setup iterator for given path.
     *
     * @param string $path Path to setup iterator for.
     *
     * @return \Iterator
     */
    protected static function setupIterator($path): Iterator
    {
        return new RegexIterator(new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $path,
                FilesystemIterator::KEY_AS_PATHNAME |
                FilesystemIterator::CURRENT_AS_FILEINFO |
                FilesystemIterator::SKIP_DOTS
            ),
            RecursiveIteratorIterator::CHILD_FIRST,
            RecursiveIteratorIterator::CATCH_GET_CHILD
        ), '/.*?' . TwigView::EXT . '$/', RegexIterator::GET_MATCH);
    }

    /**
     * Walk over the iterator and compile all templates.
     *
     * @param \Iterator $iterator Iterator to walk.
     *
     * @return array
     */
    protected static function walkIterator(Iterator $iterator): array
    {
        $items = [];

        $array = iterator_to_array($iterator);
        uasort($array, function ($a, $b) {
            if ($a == $b) {
                return 0;
            }

            return $a < $b ? -1 : 1;
        });

        foreach ($array as $paths) {
            foreach ($paths as $path) {
                $items[] = $path;
            }
        }

        return $items;
    }
}
