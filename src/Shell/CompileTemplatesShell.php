<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\TwigView\Shell;

use Cake\Console\ConsoleIo;
use Cake\Console\Shell;
use Cake\Core\Plugin;
use WyriHaximus\TwigView\View\TwigView;

/**
 * Class CompileTemplatesShell
 * @package WyriHaximus\TwigView\Console\Command
 */
// @codingStandardsIgnoreStart
class CompileTemplatesShell extends Shell
// @codingStandardsIgnoreEnd
{

    /**
     * Instance of TwigView to be used to compile templates.
     *
     * @var TwigView
     */
    protected $twigView;

    /**
     * Constructor.
     *
     * @param ConsoleIo $consoleIo An IO instance.
     */
    public function __construct(ConsoleIo $consoleIo = null)
    {
        parent::__construct($consoleIo);

        $this->twigView = new TwigView();
    }

    /**
     * Set TwigView.
     *
     * @param TwigView $twigView TwigView instance.
     *
     * @return void
     */
    public function setTwigview(TwigView $twigView)
    {
        $this->twigView = $twigView;
    }

    /**
     * Compile all templates.
     *
     * @return void
     */
    // @codingStandardsIgnoreStart
    public function all()
    {
        $this->out('<info>Compiling all templates</info>');

        $plugins = Plugin::loaded();
        if (is_array($plugins)) {
            foreach ($plugins as $plugin) {
                $this->out('<info>Compiling ' . $plugin . ' templates</info>');
                $this->processPlugin($plugin);
            }
        }

        if (is_dir(APP . 'Template' . DIRECTORY_SEPARATOR)) {
            $this->out('<info>Compiling app templates</info>');
            $this->walkIterator($this->setupIterator(APP . 'Template' . DIRECTORY_SEPARATOR));
        }
    }
    // @codingStandardsIgnoreEnd

    /**
     * Compile only this plugin.
     *
     * @param string $plugin Plugin name.
     *
     * @return void
     */
    public function plugin($plugin)
    {
        $this->out('<info>Compiling one plugin\'s templates</info>');
        $this->processPlugin($plugin);
    }

    /**
     * Only compile one file.
     *
     * @param string $fileName File to compile.
     *
     * @return void
     */
    public function file($fileName)
    {
        $this->out('<info>Compiling one template</info>');
        $this->compileTemplate($fileName);
    }

    /**
     * Process plugin.
     *
     * @param string $plugin Plugin to process.
     *
     * @return void
     */
    protected function processPlugin($plugin)
    {
        $path = Plugin::classPath($plugin) . 'Template' . DIRECTORY_SEPARATOR;
        if (!is_dir($path)) {
            return;
        }

        $this->walkIterator($this->setupIterator($path));
    }

    /**
     * Setup iterator for plugin.
     *
     * @param string $path Path to setup iterator for.
     *
     * @return \RegexIterator
     */
    protected function setupIterator($path)
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
     * @return void
     */
    // @codingStandardsIgnoreStart
    protected function walkIterator(\Iterator $iterator)
    {
        foreach ($iterator as $paths) {
            foreach ($paths as $path) {
                $this->compileTemplate($path);
            }
        }
    }
    // @codingStandardsIgnoreEnd

    /**
     * Compile a template.
     *
     * @param string $fileName Template to compile.
     *
     * @return void
     */
    protected function compileTemplate($fileName)
    {
        try {
            $this->
                twigView->
                getTwig()->
                loadTemplate($fileName);
            $this->out('<success>' . $fileName . '</success>');
        } catch (\Exception $exception) {
            $this->out('<error>' . $fileName . '</error>');
            $this->out('<error>' . $exception->getMessage() . '</error>');
        }
    }

    /**
     * Set options for this console.
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    // @codingStandardsIgnoreStart
    public function getOptionParser()
    {
        // @codingStandardsIgnoreEnd
        return parent::getOptionParser()->addSubcommand(
            'all',
            [
                'short' => 'a',
                // @codingStandardsIgnoreStart
                'help' => __('Searches and precompiles all twig templates it finds.')
                // @codingStandardsIgnoreEnd
            ]
        )->addSubcommand(
            'plugin',
            [
                'short' => 'p',
                // @codingStandardsIgnoreStart
                'help' => __('Searches and precompiles all twig templates for a specific plugin.')
                // @codingStandardsIgnoreEnd
            ]
        )->addSubcommand(
            'file',
            [
                'short' => 'f',
                // @codingStandardsIgnoreStart
                'help' => __('Precompile a specific file.')
                // @codingStandardsIgnoreEnd
            ]
        // @codingStandardsIgnoreStart
        )->description(__('TwigView templates precompiler'));
        // @codingStandardsIgnoreEnd
    }
}
