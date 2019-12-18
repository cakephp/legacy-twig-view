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

namespace WyriHaximus\TwigView\Shell;

use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\ORM\Locator\LocatorInterface;
use WyriHaximus\TwigView\Lib\Scanner;
use WyriHaximus\TwigView\View\TwigView;

/**
 * Class CompileTemplatesShell.
 * @package WyriHaximus\TwigView\Console\Command
 */
class CompileShell extends Shell
{
    /**
     * Instance of TwigView to be used to compile templates.
     *
     * @var \WyriHaximus\TwigView\View\TwigView
     */
    protected $twigView;

    /**
     * Constructor.
     *
     * @param \Cake\Console\ConsoleIo $io An IO instance.
     */
    public function __construct(?ConsoleIo $io = null, ?LocatorInterface $locator = null)
    {
        parent::__construct($io, $locator);

        $this->twigView = new TwigView();
    }

    /**
     * Set TwigView.
     *
     * @param \WyriHaximus\TwigView\View\TwigView $twigView TwigView instance.
     *
     */
    public function setTwigview(TwigView $twigView)
    {
        $this->twigView = $twigView;
    }

    /**
     * Compile all templates.
     *
     */
    public function all()
    {
        $this->out('<info>Compiling all templates</info>');

        foreach (Scanner::all() as $section => $templates) {
            $this->out('<info>Compiling ' . $section . '\'s templates</info>');
            $this->walkIterator($templates);
        }
    }

    /**
     * Compile only this plugin.
     *
     * @param string $plugin Plugin name.
     *
     */
    public function plugin($plugin)
    {
        $this->out('<info>Compiling one ' . $plugin . '\'s templates</info>');
        $this->walkIterator(Scanner::plugin($plugin));
    }

    /**
     * Only compile one file.
     *
     * @param string $fileName File to compile.
     *
     */
    public function file($fileName)
    {
        $this->out('<info>Compiling one template</info>');
        $this->compileTemplate($fileName);
    }

    /**
     * Set options for this console.
     *
     * @return \Cake\Console\ConsoleOptionParser
     */
    public function getOptionParser(): ConsoleOptionParser
    {
        return parent::getOptionParser()->addSubcommand(
            'all',
            [
                'short' => 'a',
                'help' => __('Searches and precompiles all twig templates it finds.'),
            ]
        )->addSubcommand(
            'plugin',
            [
                'short' => 'p',
                'help' => __('Searches and precompiles all twig templates for a specific plugin.'),
            ]
        )->addSubcommand(
            'file',
            [
                'short' => 'f',
                'help' => __('Precompile a specific file.'),
            ]
        )->setDescription(__('TwigView templates precompiler'));
    }

    /**
     * Walk over $iterator and compile all templates in it.
     *
     * @param mixed $iterator Iterator to walk over.
     *
     */
    protected function walkIterator($iterator)
    {
        foreach ($iterator as $template) {
            $this->compileTemplate($template);
        }
    }

    /**
     * Compile a template.
     *
     * @param string $fileName Template to compile.
     *
     */
    protected function compileTemplate($fileName)
    {
        try {
            $this->
                twigView->
                getTwig()->
                load($fileName);
            $this->out('<success>' . $fileName . '</success>');
        } catch (\Exception $exception) {
            $this->out('<error>' . $fileName . '</error>');
            $this->out('<error>' . $exception->getMessage() . '</error>');
        }
    }
}
