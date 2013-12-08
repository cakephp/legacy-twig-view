<?php

App::uses('TwigView', 'TwigView.View');

class TwigViewTest extends CakeTestCase {

	protected function _hibernateListeners($eventKey) {
		$this->__preservedEventListeners[$eventKey] = CakeEventManager::instance()->listeners($eventKey);

		foreach ($this->__preservedEventListeners[$eventKey] as $eventListener) {
			CakeEventManager::instance()->detach($eventListener['callable'], $eventKey);
		}
	}

	protected function _wakeupListeners($eventKey) {
		if (isset($this->__preservedEventListeners[$eventKey])) {
			return;
		}

		foreach ($this->__preservedEventListeners[$eventKey] as $eventListener) {
			CakeEventManager::instance()->attach($eventListener['callable'], $eventKey, array(
				'passParams' => $eventListener['passParams'],
			));
		}

		$this->__preservedEventListeners = array();
	}

	public function testInheritance() {
		$this->assertInstanceof('View', new TwigView);
	}

	public function testConstruct() {
		$this->_hibernateListeners('Twig.TwigView.construct');

		$callbackFired = false;
		$that = $this;
		$eventCallback = function($event) use($that, &$callbackFired) {
			$this->assertInstanceof('Twig_Environment', $event->data['TwigEnvironment']);
			$callbackFired = true;
		};
		CakeEventManager::instance()->attach($eventCallback, 'Twig.TwigView.construct');

		$TwigView = new TwigView();

		CakeEventManager::instance()->detach($eventCallback, 'Twig.TwigView.construct');
		$this->_wakeupListeners('Twig.TwigView.construct');

		$this->assertTrue($callbackFired);
	}

}
