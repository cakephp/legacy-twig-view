<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\CakePHP\Tests\TwigView\Lib\Twig;

use Cake\Core\Configure;
use Cake\Core\Plugin as CakePlugin;
use Cake\TestSuite\TestCase;
use WyriHaximus\TwigView\Lib\Twig\Loader;

/**
 * Class LoaderTest
 * @package WyriHaximus\CakePHP\Tests\TwigView\Lib\Twig
 */
class LoaderTest extends TestCase
{
	/**
	 * @var Loader
	 */
	protected $Loader;

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
		CakePlugin::load(
			'TestTwigView',
			[
				'path' => PLUGIN_REPO_ROOT . 'tests' . DS . 'test_app' . DS . 'Plugin' . DS . 'TestTwigView' . DS,
			]
		);

		$this->Loader = new Loader();
	}

	public function tearDown()
	{
		unset($this->Loader);

		CakePlugin::unload('TestTwigView');

		parent::tearDown();
	}

	public function testGetSource()
	{
		$this->assertSame('TwigView', $this->Loader->getSource('TestTwigView.twig'));
	}

	/**
	 * @expectedException Twig_Error_Loader
	 */
	public function testGetSourceNonExistingFile()
	{
		$this->Loader->getSource('TestTwigView.no_twig');
	}

	public function testGetCacheKeyNoPlugin()
	{
		$this->assertSame(
			PLUGIN_REPO_ROOT . 'tests/test_app/Template/layout.tpl',
			$this->Loader->getCacheKey('layout')
		);
	}

	public function testGetCacheKeyPlugin()
	{
		$this->assertSame(
			PLUGIN_REPO_ROOT . 'tests/test_app/Plugin/TestTwigView/src/Template/twig.tpl',
			$this->Loader->getCacheKey('TestTwigView.twig')
		);
	}

	/**
	 * @expectedException Twig_Error_Loader
	 */
	public function testGetCacheKeyPluginNonExistingFile()
	{
		$this->Loader->getCacheKey('TestTwigView.twog');
	}

	public function testIsFresh()
	{
		file_put_contents(TMP . 'TwigViewIsFreshTest', 'TwigViewIsFreshTest');
		$time = filemtime(TMP . 'TwigViewIsFreshTest');

		$this->assertTrue($this->Loader->isFresh(TMP . 'TwigViewIsFreshTest', $time + 5));
		$this->assertTrue(!$this->Loader->isFresh(TMP . 'TwigViewIsFreshTest', $time - 5));

		unlink(TMP . 'TwigViewIsFreshTest');
	}

	/**
	 * @expectedException Twig_Error_Loader
	 */
	public function testIsFreshNonExistingFile()
	{
		$this->Loader->isFresh(TMP . 'foobar' . time(), time());
	}

}