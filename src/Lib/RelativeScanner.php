<?php
declare(strict_types=1);

namespace WyriHaximus\TwigView\Lib;

use Cake\Core\App;
use Cake\Core\Plugin;

/**
 * Class RelativeScanner.
 * @package WyriHaximus\TwigView\Lib
 */
final class RelativeScanner
{
    /**
     * Return all sections (app & plugins) with an Template directory.
     *
     * @return array
     */
    public static function all(): array
    {
        return static::strip(Scanner::all());
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
        return static::strip([
            $plugin => Scanner::plugin($plugin),
        ])[$plugin];
    }

    /**
     * Strip the absolute path of template's paths for all given sections.
     *
     * @param string $sections Sections to iterate over.
     *
     * @return array
     */
    protected static function strip($sections): array
    {
        foreach ($sections as $section => $paths) {
            $sections[$section] = static::stripAbsolutePath($paths, $section == 'APP' ? null : $section);
        }

        return $sections;
    }

    /**
     * Strip the absolute path of template's paths.
     *
     * @param array       $paths  Paths to strip.
     * @param string|null $plugin Hold plugin name or null for App.
     *
     * @return array
     */
    protected static function stripAbsolutePath(array $paths, $plugin = null): array
    {
        if ($plugin === null) {
            $allPaths = App::path('templates');
        } else {
            $allPaths = [Plugin::templatePath($plugin)];
        }

        foreach ($allPaths as $templatesPath) {
            array_walk($paths, function (&$path) use ($templatesPath) {
                if (substr($path, 0, strlen($templatesPath)) == $templatesPath) {
                    $path = substr($path, strlen($templatesPath));
                }
            });
        }

        return $paths;
    }
}
