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

namespace WyriHaximus\CakePHP\Tests\TwigView\Lib;

use Cake\Routing\Router;
use WyriHaximus\CakePHP\Tests\TwigView\TestCase;
use WyriHaximus\TwigView\Lib\RelativeScanner;

/**
 * Class RelativeScannerTest.
 * @package WyriHaximus\CakePHP\Tests\TwigView\Lib\Twig
 */
class RelativeScannerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        Router::reload();
        $this->loadPlugins(['TestTwigView']);
    }

    public function tearDown()
    {
        $this->removePlugins(['TestTwigView']);

        parent::tearDown();
    }

    public function testAll()
    {
        $expected = [
            'APP' => [
                'Blog/index.twig',
                'element/element.twig',
                'exception.twig',
                'layout.twig',
                'layout/layout.twig',
                'syntaxerror.twig',
            ],
            'TestTwigView' => [
                'Controller/Component/magic.twig',
                'Controller/index.twig',
                'Controller/view.twig',
                'twig.twig',
            ],
        ];

        /*if (Plugin::loaded('Bake')) {
            $expected['Bake'] = RelativeScanner::plugin('Bake');
        }*/

        $this->assertEquals($expected, RelativeScanner::all());
    }

    public function testPlugin()
    {
        $this->assertSame([
            'Controller/Component/magic.twig',
            'Controller/index.twig',
            'Controller/view.twig',
            'twig.twig',
        ], RelativeScanner::plugin('TestTwigView'));
    }
}
