<?php
/**
 * All TwigView plugin tests
 */
class AllTwigViewTest extends CakeTestCase {

/**
 * Suite define the tests for this plugin
 *
 * @return void
 */
	public static function suite() {
		$suite = new CakeTestSuite('All TwigView test');

		$path = CakePlugin::path('TwigView') . 'Test' . DS . 'Case' . DS;
		$suite->addTestDirectoryRecursive($path);

		return $suite;
	}

}
