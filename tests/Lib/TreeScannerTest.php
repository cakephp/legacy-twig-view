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

namespace WyriHaximus\TwigView\Test\Lib;

use Cake\Routing\Router;
use WyriHaximus\TwigView\Lib\TreeScanner;
use WyriHaximus\TwigView\Test\TestCase;

/**
 * Class TreeScannerTest.
 *
 * @package WyriHaximus\TwigView\Test\Lib\Twig
 */
class TreeScannerTest extends TestCase
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
        $this->assertEquals([
            'APP' => [
                2 => 'exception.twig',
                3 => 'layout.twig',
                5 => 'syntaxerror.twig',
                'Blog' => [
                    'index.twig',
                ],
                'element' => [
                    'element.twig',
                ],
                'layout' => [
                    'layout.twig',
                ],
            ],
            'TestTwigView' => [
                3 => 'twig.twig',
                'Controller' => [
                    'Component' => [
                        'magic.twig',
                    ],
                    'index.twig',
                    'view.twig',
                ],
            ],
            //'Bake' => TreeScanner::plugin('Bake'),
        ], TreeScanner::all());
    }

    public function testPlugin()
    {
        $this->assertSame([
            3 => 'twig.twig',
            'Controller' => [
                'Component' => [
                    'magic.twig',
                ],
                'index.twig',
                'view.twig',
            ],
        ], TreeScanner::plugin('TestTwigView'));
    }
}
