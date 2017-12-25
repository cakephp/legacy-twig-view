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
use WyriHaximus\TwigView\Lib\RelativeScanner;

/**
 * Class RelativeScannerTest
 * @package WyriHaximus\CakePHP\Tests\TwigView\Lib\Twig
 */
class RelativeScannerTest extends TestCase
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
        $this->assertEquals([
            'APP' => [
                'Blog/index.twig',
                'Element/element.twig',
                'Layout/layout.twig',
                'exception.twig',
                'layout.twig',
                'syntaxerror.twig',
            ],
            'TestTwigView' => [
                'Controller/Component/magic.twig',
                'Controller/index.twig',
                'Controller/view.twig',
                'twig.twig',
            ],
            'Bake' => [
                'Bake/Controller/component.twig',
                'Bake/Controller/controller.twig',
                'Bake/Element/Controller/add.twig',
                'Bake/Element/Controller/delete.twig',
                'Bake/Element/Controller/edit.twig',
                'Bake/Element/Controller/index.twig',
                'Bake/Element/Controller/login.twig',
                'Bake/Element/Controller/logout.twig',
                'Bake/Element/Controller/view.twig',
                'Bake/Element/array_property.twig',
                'Bake/Element/form.twig',
                'Bake/Form/form.twig',
                'Bake/Layout/default.twig',
                'Bake/Mailer/mailer.twig',
                'Bake/Middleware/middleware.twig',
                'Bake/Model/behavior.twig',
                'Bake/Model/entity.twig',
                'Bake/Model/table.twig',
                'Bake/Plugin/.gitignore.twig',
                'Bake/Plugin/README.md.twig',
                'Bake/Plugin/composer.json.twig',
                'Bake/Plugin/config/routes.php.twig',
                'Bake/Plugin/phpunit.xml.dist.twig',
                'Bake/Plugin/src/Controller/AppController.php.twig',
                'Bake/Plugin/tests/bootstrap.php.twig',
                'Bake/Plugin/webroot/empty.twig',
                'Bake/Shell/helper.twig',
                'Bake/Shell/shell.twig',
                'Bake/Shell/task.twig',
                'Bake/Template/add.twig',
                'Bake/Template/edit.twig',
                'Bake/Template/index.twig',
                'Bake/Template/login.twig',
                'Bake/Template/view.twig',
                'Bake/View/cell.twig',
                'Bake/View/helper.twig',
                'Bake/tests/fixture.twig',
                'Bake/tests/test_case.twig',
            ],
        ], RelativeScanner::all());
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
