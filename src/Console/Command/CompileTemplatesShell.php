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
class CompileTemplatesShell extends Shell
{

    /**
     * @var TwigView
     */
    protected $twigView;

    /**
     * Constructor
     *
     * @param ConsoleIo $io An IO instance
     */
    public function __construct(ConsoleIo $io = null)
    {
        parent::__construct($io);

        $this->twigView = new TwigView();
    }

    /**
     * Set TwigView
     *
     * @param TwigView $twigView TwigView instance
     * @return void
     */
    public function setTwigview(TwigView $twigView)
    {
        $this->twigView = $twigView;
    }

    /**
     * Compile all templates
     *
     * @return void
     */
    public function all()
    {
        $this->out('<info>Compiling all templates</info>');

        $plugins = Plugin::loaded();
        if (is_array($plugins)) {
            foreach ($plugins as $plugin) {
                $this->processPlugin($plugin);
            }
        }
    }

    /**
     * Compile only this plugin
     *
     * @param string $plugin Plugin name
     * @return void
     */
    public function plugin($plugin)
    {
        $this->out('<info>Compiling one plugin\'s templates</info>');
        $this->processPlugin($plugin);
    }

    /**
     * Only compile one file
     *
     * @param string $fileName File to compile
     * @return void
     */
    public function file($fileName)
    {
        $this->out('<info>Compiling one template</info>');
        $this->compileTemplate($fileName);
    }

    /**
     * Process plugin
     *
     * @param string $plugin Plugin to process
     * @return void
     */
    protected function processPlugin($plugin)
    {
        if (!is_dir(Plugin::path($plugin) . 'Template' . DS)) {
            return;
        }

        $this->walkIterator($this->setupIterator($plugin));
    }

    /**
     * Setup iterator for plugin
     *
     * @param string $plugin Plugin to setup iterator
     * @return \RegexIterator
     */
    protected function setupIterator($plugin)
    {
        return new \RegexIterator(new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator(
                Plugin::path($plugin) . 'Template' . DS,
                \FilesystemIterator::KEY_AS_PATHNAME |
                \FilesystemIterator::CURRENT_AS_FILEINFO |
                \FilesystemIterator::SKIP_DOTS
            ),
            \RecursiveIteratorIterator::CHILD_FIRST,
            \RecursiveIteratorIterator::CATCH_GET_CHILD
        ), '/.*?.tpl$/', \RegexIterator::GET_MATCH);
    }

    /**
     * Walk over the iterator and compile all templates
     *
     * @param \Iterator $iterator Iterator to walk
     * @return void
     */
    protected function walkIterator(\Iterator $iterator)
    {
        foreach ($iterator as $paths) {
            foreach ($paths as $path) {
                $this->compileTemplate($path);
            }
        }
    }

    /**
     * Compile a template
     *
     * @param string $fileName Template to compile
     * @return void
     */
    protected function compileTemplate($fileName)
    {
        try {
            $this->twigView->getTwig()->loadTemplate($fileName);
            $this->out('<success>' . $fileName . '</success>');
        } catch (\Exception $e) {
            $this->out('<error>' . $fileName . '</error>');
            $this->out('<error>' . $e->getMessage() . '</error>');
        }
    }

    /**
     * Set options for this console
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser()
    {
        return parent::getOptionParser()->addSubcommand(
            'all',
            [
                'short' => 'a',
                'help' => __('Searches and precompiles all twig templates it finds.')
            ]
        )->description(__('TwigView templates precompiler'));
    }
}
