<?php
/**
 * CakePHP : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP Project
 * @since         0.1.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace WyriHaximus\CakePHP\Tests\TwigView\Shell\Task;

use Bake\Shell\Task\BakeTemplateTask;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\StringCompareTrait;
use Cake\TestSuite\TestCase;
/**
 * TemplateTaskTest class
 */
class TemplateTaskTest extends TestCase
{
    use StringCompareTrait;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'core.authors'
    ];

    /**
     * setUp method
     *
     * Ensure that the default template is used
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->_compareBasePath = PLUGIN_REPO_ROOT . 'tests' . DS . 'comparisons' . DIRECTORY_SEPARATOR;

        Configure::write('App.namespace', 'WyriHaximus\TwigView\Test\App');
        $this->_setupTask(['in', 'err', 'error', 'createFile', '_stop']);
    }

    /**
     * Generate the mock objects used in tests.
     *
     * @param $methods
     * @return void
     */
    protected function _setupTask($methods)
    {
        $io = $this->getMockBuilder('Cake\Console\ConsoleIo')
            ->disableOriginalConstructor()
            ->getMock();

        $this->Task = $this->getMockBuilder('WyriHaximus\TwigView\Shell\Task\TwigTemplateTask')
            ->setMethods($methods)
            ->setConstructorArgs([$io])
            ->getMock();
        $this->Task->connection = 'test';

        $this->Task->BakeTemplate = new BakeTemplateTask($io);
        $this->Task->BakeTemplate->params['theme'] = 'TwigView';
        $this->Task->Model = $this->getMockBuilder('Bake\Shell\Task\ModelTask')
            ->setConstructorArgs([$io])
            ->getMock();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        parent::tearDown();
        TableRegistry::clear();
        unset($this->Task);
    }

    /**
     * test Bake method
     *
     * @return void
     */
    public function testBakeView()
    {
        $this->Task->modelName = __NAMESPACE__ . '\\TemplateTask\\AuthorsTable';
        $this->Task->controllerName = 'Authors';
        $this->Task->controllerClass = __NAMESPACE__ . '\\TemplateTask\\AuthorsController';

        $this->Task
            ->expects($this->at(0))
            ->method('createFile')
            ->with($this->_normalizePath(APP . 'Template/Authors/view.twig'));

        $result = $this->Task->bake('view', true);
        $this->assertSameAsFile(__FUNCTION__ . '.twig', $result);
    }

    /**
     * test baking an edit file
     *
     * @return void
     */
    public function testBakeEdit()
    {
        $this->Task->modelName = __NAMESPACE__ . '\\TemplateTask\\AuthorsTable';
        $this->Task->controllerName = 'Authors';
        $this->Task->controllerClass = __NAMESPACE__ . '\\TemplateTask\\AuthorsController';

        $this->Task->expects($this->at(0))->method('createFile')
            ->with(
                $this->_normalizePath(APP . 'Template/Authors/edit.twig')
            );
        $result = $this->Task->bake('edit', true);
        $this->assertSameAsFile(__FUNCTION__ . '.twig', $result);
    }

    /**
     * test baking an index
     *
     * @return void
     */
    public function testBakeIndex()
    {
        $this->Task->modelName = __NAMESPACE__ . '\\TemplateTask\\AuthorsTable';
        $this->Task->controllerName = 'Authors';
        $this->Task->controllerClass = __NAMESPACE__ . '\\TemplateTask\\AuthorsController';

        $this->Task->expects($this->at(0))->method('createFile')
            ->with(
                $this->_normalizePath(APP . 'Template/Authors/index.twig')
            );
        $result = $this->Task->bake('index', true);
        $this->assertSameAsFile(__FUNCTION__ . '.twig', $result);
    }

    /**
     * test bake template with index limit overwrite
     *
     * @return void
     */
    public function testBakeIndexWithIndexLimit()
    {
        $this->Task->modelName = __NAMESPACE__ . '\\TemplateTask\\AuthorsTable';
        $this->Task->controllerName = 'Authors';
        $this->Task->controllerClass = __NAMESPACE__ . '\\TemplateTask\\AuthorsController';
        $this->Task->params['index-columns'] = 1;
        $this->Task->expects($this->at(0))->method('createFile')
            ->with(
                $this->_normalizePath(APP . 'Template/Authors/index.twig')
            );
        $result = $this->Task->bake('index', true);
        $this->assertSameAsFile(__FUNCTION__ . '.twig', $result);
    }

}
