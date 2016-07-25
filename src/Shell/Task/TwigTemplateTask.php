<?php

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
use Cake\Core\Configure;
use Cake\Utility\Inflector;

/**
 * Task class for creating and updating twig view template files.
 *
 */
class TwigTemplateTask extends TemplateTask
{

    public function name()
    {
        return 'twig_template';
    }

    /**
     * Assembles and writes bakes the twig view file.
     *
     * @param string $action Action to bake.
     * @param string $content Content to write.
     * @return string Generated file content.
     */
    public function bake($action, $content = '')
    {
        if ($content === true) {
            $content = $this->getContent($action);
        }
        if (empty($content)) {
            $this->err("<warning>No generated content for '{$action}.ctp', not generating template.</warning>");

            return false;
        }
        $this->out("\n" . sprintf('Baking `%s` view twig template file...', $action), 1, Shell::QUIET);
        $path = $this->getPath();
        $filename = $path . Inflector::underscore($action) . '.twig';
        $this->createFile($filename, $content);

        return $content;
    }
}
