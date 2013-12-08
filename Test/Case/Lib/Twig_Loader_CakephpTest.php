<?php

App::uses('Twig_Loader_Cakephp', 'TwigView.Lib');

class Twig_Loader_CakephpTest extends CakeTestCase {

	public function setUp() {
		parent::setUp();

		App::build(array(
			'Plugin' => array(App::pluginPath('TwigView') . 'Test' . DS . 'test_app' . DS . 'Plugin' . DS )
		));
		CakePlugin::load('TestTwigView');

		$this->Loader = new Twig_Loader_Cakephp();
	}

	public function tearDown() {
		unset($this->Loader);

		CakePlugin::unload('TestTwigView');

		parent::tearDown();
	}

	public function testGetSource() {

	}

	public function testGetCacheKeyNoPlugin() {
		$this->assertSame(APP . 'View/layout.tpl', $this->Loader->getCacheKey('layout'));
	}

	public function testGetCacheKeyPlugin() {
		$this->assertSame(APP . 'Plugin/TwigView/Test/test_app/Plugin/TestTwigView/View/twig.tpl', $this->Loader->getCacheKey('TestTwigView.twig'));
	}

}