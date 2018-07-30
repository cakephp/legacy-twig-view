<?php declare(strict_types=1);
/**
 * This file is part of TwigView.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\CakePHP\Tests\TwigView\Shell\Task;

use Bake\Shell\Task\BakeTemplateTask;
use Cake\Core\Configure;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\StringCompareTrait;
use Cake\TestSuite\TestCase;

/**
 * TemplateTaskTest class.
 */
class TemplateTaskTest extends TestCase
{
    use StringCompareTrait;

    /**
     * Fixtures.
     *
     * @var array
     */
    public $fixtures = [
        'core.authors',
    ];

    /**
     * setUp method.
     *
     * Ensure that the default template is used
     *
     */
    public function setUp()
    {
        parent::setUp();
        $this->_compareBasePath = PLUGIN_REPO_ROOT . 'tests' . DS . 'comparisons' . DIRECTORY_SEPARATOR;

        Configure::write('App.namespace', 'WyriHaximus\TwigView\Test\App');
        $this->_setupTask(['in', 'err', 'error', 'createFile', '_stop']);
    }

    /**
     * tearDown method.
     *
     */
    public function tearDown()
    {
        parent::tearDown();
        TableRegistry::clear();
        unset($this->Task);
    }

    /**
     * test Bake method.
     *
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
     * test baking an edit file.
     *
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
     * test baking an index.
     *
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
     * test bake template with index limit overwrite.
     *
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

    /**
     * Generate the mock objects used in tests.
     *
     * @param $methods
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
     * test baking an index with output file
     *
     * @return void
     */
    public function testBakeIndexWithOutputFile()
    {
        $this->Task->modelName = __NAMESPACE__ . '\\TemplateTask\\AuthorsTable';
        $this->Task->controllerName = 'Authors';
        $this->Task->controllerClass = __NAMESPACE__ . '\\TemplateTask\\AuthorsController';

        $this->Task->expects($this->at(0))->method('createFile')
            ->with(
                $this->_normalizePath(APP . 'Template/Authors/listing.twig')
            );
        $this->Task->bake('index', true, 'listing');
    }
}
