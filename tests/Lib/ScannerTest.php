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
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'Blog' . DS . 'index.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'Element' . DS . 'element.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'Layout' . DS . 'layout.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'exception.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'layout.twig',
                PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Template' . DS . 'syntaxerror.twig',
            ],
            'Bake' => [
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Controller/component.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Controller/controller.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Element/Controller/add.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Element/Controller/delete.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Element/Controller/edit.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Element/Controller/index.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Element/Controller/login.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Element/Controller/logout.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Element/Controller/view.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Element/array_property.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Element/form.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Form/form.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Layout/default.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Mailer/mailer.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Middleware/middleware.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Model/behavior.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Model/entity.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Model/table.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Plugin/.gitignore.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Plugin/README.md.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Plugin/composer.json.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Plugin/config/routes.php.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Plugin/phpunit.xml.dist.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Plugin/src/Controller/AppController.php.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Plugin/tests/bootstrap.php.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Plugin/webroot/empty.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Shell/helper.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Shell/shell.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Shell/task.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Template/add.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Template/edit.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Template/index.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Template/login.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/Template/view.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/View/cell.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/View/helper.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/tests/fixture.twig',
                PLUGIN_REPO_ROOT . 'vendor/cakephp/bake/src/Template/Bake/tests/test_case.twig',
            ],
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
