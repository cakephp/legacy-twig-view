<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\TwigView\Console\Command;

use Cake\Console\ConsoleIo;
use Cake\Console\Shell;
use Cake\Core\Plugin;
use WyriHaximus\TwigView\View\TwigView;

/**
 * Class CompileTemplatesShell
 * @package WyriHaximus\TwigView\Console\Command
 */
class CompileTemplatesShell extends Shell {

    /**
     * @var TwigView
     */
    private $twigView;

    /**
     * @param ConsoleIo $io
     */
    public function __construct(ConsoleIo $io = null) {
        parent::__construct($io);
        
        $this->twigView = new TwigView();
    }

    /**
     * @param TwigView $twigView
     */
    public function setTwigview(TwigView $twigView) {
        $this->twigView = $twigView;
    }

    public function all() {
        $this->out('<info>Compiling all templates</info>');

        $plugins = Plugin::loaded();
        if (is_array($plugins)) {
            foreach ($plugins as $plugin) {
                $this->processPlugin($plugin);
            }
        }
    }

    /**
     * @param string $plugin
     */
    public function plugin($plugin) {
        $this->out('<info>Compiling one plugin\'s templates</info>');
        $this->processPlugin($plugin);
    }

    /**
     * @param string $fileName
     */
    public function file($fileName) {
        $this->out('<info>Compiling one template</info>');
        $this->compileTemplate($fileName);
    }

    /**
     * @param string $plugin
     */
    protected function processPlugin($plugin) {
        if (!is_dir(Plugin::path($plugin) . 'Template' . DS)) {
            return;
        }

        $this->walkIterator($this->setupIterator($plugin));
    }

    /**
     * @param string $plugin
     * @return \RegexIterator
     */
    protected function setupIterator($plugin) {
        return new \RegexIterator(new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                Plugin::path($plugin) . 'Template' . DS,
                \FilesystemIterator::KEY_AS_PATHNAME | \FilesystemIterator::CURRENT_AS_FILEINFO | \FilesystemIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::CHILD_FIRST,
            \RecursiveIteratorIterator::CATCH_GET_CHILD
        ), '/.*?.tpl$/', \RegexIterator::GET_MATCH);
    }

    /**
     * @param \Iterator $iterator
     */
    protected function walkIterator(\Iterator $iterator) {
        foreach ($iterator as $paths) {
            foreach ($paths as $path) {
                $this->compileTemplate($path);
            }
        }
    }

    /**
     * @param string $fileName
     */
    protected function compileTemplate($fileName) {
        try {
            $this->twigView->getTwig()->loadTemplate($fileName);
            $this->out('<success>' . $fileName . '</success>');
        } catch (\Exception $e) {
            $this->out('<error>' . $fileName . '</error>');
            $this->out('<error>' . $e->getMessage() . '</error>');
        }
    }

    /**
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser() {
        return parent::getOptionParser()->addSubcommand('all', array(
            'short' => 'a',
            'help' => __('Searches and precompiles all twig templates it finds.')
        ))->description(__('TwigView templates precompiler'));
    }
}
