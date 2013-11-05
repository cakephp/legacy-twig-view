<?php

App::uses('TwigView', 'TwigView.View');

class TwigViewTest extends CakeTestCase {

	public function testInheritance() {
		$this->assertInstanceof('View', new TwigView);
	}

}
