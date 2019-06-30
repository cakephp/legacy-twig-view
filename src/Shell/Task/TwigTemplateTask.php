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

namespace WyriHaximus\TwigView\Shell\Task;

use Bake\Shell\Task\TemplateTask;
use Cake\Console\Shell;
use Cake\Utility\Inflector;

final class TwigTemplateTask extends TemplateTask
{
    /**
     * @return string Task name.
     */
    public function name(): string
    {
        return 'twig_template';
    }

    /**
     * Assembles and writes bakes the twig view file.
     *
     * @param  string $action     Action to bake.
     * @param  string $content    Content to write.
     * @param  string $outputFile The destination action name. If null, will fallback to $template.
     * @return string Generated file content.
     */
    public function bake($action, $content = '', $outputFile = null): string
    {
        if ($outputFile === null) {
            $outputFile = $action;
        }
        if ($content === true) {
            $content = $this->getContent($action);
        }
        if (empty($content)) {
            $this->err("<warning>No generated content for '{$action}.php', not generating template.</warning>");

            return false;
        }
        $this->out("\n" . sprintf('Baking `%s` view twig template file...', $outputFile), 1, Shell::QUIET);
        $path = $this->getPath();
        $filename = $path . Inflector::underscore($outputFile) . '.twig';
        $this->createFile($filename, $content);

        return $content;
    }
}
