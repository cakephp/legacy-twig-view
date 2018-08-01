<?php declare(strict_types=1);

namespace WyriHaximus\CakePHP\Tests\TwigView;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase as CakeTestCase;

abstract class TestCase extends CakeTestCase
{
    public function setUp()
    {
        parent::setUp();
        Configure::write('Error.errorLevel', E_ALL & ~E_USER_DEPRECATED);
    }
}
