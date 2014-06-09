<?php

App::uses('Twig_Loader_Cakephp', 'TwigView.Lib');

class Twig_Loader_CakephpTest extends CakeTestCase {

	public function setUp() {
		parent::setUp();

		App::build(array(
			'Plugin' => array(App::pluginPath('TwigView') . 'Test' . DS . 'test_app' . DS . 'Plugin' . DS ),
		));
		App::build(array(
            'View' => array(App::pluginPath('TwigView') . 'Test' . DS . 'test_app' . DS . 'View' . DS ),
		), App::RESET);
		CakePlugin::load('TestTwigView');

		$this->Loader = new Twig_Loader_Cakephp();
	}

	public function tearDown() {
		unset($this->Loader);

		CakePlugin::unload('TestTwigView');

		parent::tearDown();
	}

	public function testGetSource() {
		$this->assertSame('TwigView', $this->Loader->getSource('TestTwigView.twig'));
	}

/**
 * @expectedException Twig_Error_Loader
 */
	public function testGetSourceNonExistingFile() {
		$this->Loader->getSource('TestTwigView.no_twig');
	}

	public function testGetCacheKeyNoPlugin() {
		$this->assertSame(APP . 'Plugin/TwigView/Test/test_app/View/layout.tpl', $this->Loader->getCacheKey('layout'));
	}

	public function testGetCacheKeyPlugin() {
		$this->assertSame(APP . 'Plugin/TwigView/Test/test_app/Plugin/TestTwigView/View/twig.tpl', $this->Loader->getCacheKey('TestTwigView.twig'));
	}

/**
 * @expectedException Twig_Error_Loader
 */
	public function testGetCacheKeyPluginNonExistingFile() {
		$this->Loader->getCacheKey('TestTwigView.twog');
	}

	public function testIsFresh() {
		file_put_contents(TMP . 'TwigViewIsFreshTest', 'TwigViewIsFreshTest');
		$time = filemtime(TMP . 'TwigViewIsFreshTest');

		$this->assertTrue($this->Loader->isFresh(TMP . 'TwigViewIsFreshTest', $time + 5));
		$this->assertTrue(!$this->Loader->isFresh(TMP . 'TwigViewIsFreshTest', $time - 5));

		unlink(TMP . 'TwigViewIsFreshTest');
	}

/**
 * @expectedException Twig_Error_Loader
 */
	public function testIsFreshNonExistingFile() {
		$this->Loader->isFresh(TMP . 'foobar' . time(), time());
	}

}