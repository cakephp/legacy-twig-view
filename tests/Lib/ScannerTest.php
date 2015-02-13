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
    }

    public function tearDown()
    {
        Plugin::unload('TestTwigView');

        parent::tearDown();
    }

    public function testAll()
    {
        $this->assertSame([
            'APP' => [
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'layout.tpl',
            ],
            'TestTwigView' => [
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'src' . DS . 'Template' . DS . 'twig.tpl',
            ],
        ], Scanner::all());
    }

    public function testPlugin()
    {
        $this->assertSame([
            PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS . 'src' . DS . 'Template' . DS . 'twig.tpl',
        ], Scanner::plugin('TestTwigView'));
    }
}
