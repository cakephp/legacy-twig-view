<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\CakePHP\Tests\TwigView\Lib;

use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\TestSuite\TestCase;
use WyriHaximus\TwigView\Lib\Scanner;

/**
 * Class ScannerTest
 * @package WyriHaximus\CakePHP\Tests\TwigView\Lib\Twig
 */
class ScannerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        Configure::write(
            'App',
            [
                'paths' => [
                    'templates' => [
                        PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS,
                    ],
                ]
            ]
        );

        $this->deprecated(function () {
            Plugin::load(
                'TestTwigView',
                [
                    'path' => PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS,
                ]
            );
            Plugin::load(
                'TestTwigViewEmpty',
                [
                    'path' => PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigViewEmpty' . DS,
                ]
            );
        });
    }

    public function tearDown()
    {
        $this->deprecated(function () {
            Plugin::unload('TestTwigView');
        });

        parent::tearDown();
    }

    public function testAll()
    {
        $this->assertSame([
            'APP' => [
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'Blog' . DS . 'index.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'Element' . DS . 'element.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'Layout' . DS . 'layout.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'exception.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'layout.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'syntaxerror.twig',
            ],
            'Bake' => Scanner::plugin('Bake'),
            'TestTwigView' => [
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'src' . DS . 'Template' . DS . 'Controller' . DS . 'Component' . DS . 'magic.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'src' . DS . 'Template' . DS . 'Controller' . DS . 'index.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'src' . DS . 'Template' . DS . 'Controller' . DS . 'view.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'src' . DS . 'Template' . DS . 'twig.twig',
            ],
        ], Scanner::all());
    }

    public function testPlugin()
    {
        $this->assertSame([
            PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'src' . DS . 'Template' . DS . 'Controller' . DS . 'Component' . DS . 'magic.twig',
            PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'src' . DS . 'Template' . DS . 'Controller' . DS . 'index.twig',
            PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'src' . DS . 'Template' . DS . 'Controller' . DS . 'view.twig',
            PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'src' . DS . 'Template' . DS . 'twig.twig',
        ], Scanner::plugin('TestTwigView'));
    }
}
