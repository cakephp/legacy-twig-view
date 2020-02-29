<?php
declare(strict_types=1);

/**
 * This file is part of TwigView.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cake\TwigView\Test\Lib;

use Cake\Routing\Router;
use Cake\TwigView\Lib\Scanner;
use Cake\TwigView\Test\TestCase;

/**
 * Class ScannerTest.
 * @package Cake\TwigView\Test\Lib\Twig
 */
class ScannerTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Router::reload();
        $this->loadPlugins(['TestTwigView']);
    }

    public function tearDown(): void
    {
        $this->removePlugins(['TestTwigView']);

        parent::tearDown();
    }

    public function testAll()
    {
        $this->assertSame([
            'APP' => [
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'templates' . DS . 'Blog' . DS . 'index.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'templates' . DS . 'element' . DS . 'element.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'templates' . DS . 'exception.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'templates' . DS . 'layout.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'templates' . DS . 'layout' . DS . 'layout.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'templates' . DS . 'syntaxerror.twig',
            ],
            //'Bake' => Scanner::plugin('Bake'),
            'TestTwigView' => [
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'templates' . DS . 'Controller' . DS . 'Component' . DS . 'magic.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'templates' . DS . 'Controller' . DS . 'index.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'templates' . DS . 'Controller' . DS . 'view.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'templates' . DS . 'twig.twig',
            ],
        ], Scanner::all());
    }

    public function testPlugin()
    {
        $this->assertSame([
            PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'templates' . DS . 'Controller' . DS . 'Component' . DS . 'magic.twig',
            PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'templates' . DS . 'Controller' . DS . 'index.twig',
            PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'templates' . DS . 'Controller' . DS . 'view.twig',
            PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'templates' . DS . 'twig.twig',
        ], Scanner::plugin('TestTwigView'));
    }
}
