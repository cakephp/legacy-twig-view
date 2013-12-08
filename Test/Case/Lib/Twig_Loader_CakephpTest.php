<?php

App::uses('Twig_Loader_Cakephp', 'TwigView.Lib');

class Twig_Loader_CakephpTest extends CakeTestCase {

	public function setUp() {
		parent::setUp();

		$this->Loader = new Twig_Loader_Cakephp();
	}

	public function tearDown() {
		unset($this->Loader);

		parent::tearDown();
	}

	public function testGetCacheKeyNoPlugin() {
		$this->assertSame(APP . 'View/layout.tpl', $this->Loader->getCacheKey('layout'));
	}

	public function testGetCacheKeyPlugin() {
		$this->assertSame(APP . 'Plugin/TwigView/View/layout.tpl', $this->Loader->getCacheKey('TwigView.layout'));
	}

}