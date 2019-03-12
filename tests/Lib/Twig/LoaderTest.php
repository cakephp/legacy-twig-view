<?php declare(strict_types=1);
/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\CakePHP\Tests\TwigView\Lib\Twig;

use WyriHaximus\CakePHP\Tests\TwigView\TestCase;
use WyriHaximus\TwigView\Lib\Twig\Loader;

/**
 * Class LoaderTest.
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

        $this->loadPlugins(['TestTwigView']);

        $this->Loader = new Loader();
    }

    public function tearDown()
    {
        unset($this->Loader);

        $this->removePlugins(['TestTwigView']);

        parent::tearDown();
    }

    public function testGetSource()
    {
        $this->assertSame('TwigView', $this->Loader->getSource('TestTwigView.twig'));
        $this->assertSame('TwigView', $this->Loader->getSource('TestTwigView.twig.twig'));
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
            PLUGIN_REPO_ROOT . 'tests/test_app/templates/layout.twig',
            $this->Loader->getCacheKey('layout')
        );
    }

    public function testGetCacheKeyPlugin()
    {
        $this->assertSame(
            PLUGIN_REPO_ROOT . 'tests/test_app/Plugin/TestTwigView/templates/twig.twig',
            $this->Loader->getCacheKey('TestTwigView.twig')
        );
        $this->assertSame(
            PLUGIN_REPO_ROOT . 'tests/test_app/Plugin/TestTwigView/templates/twig.twig',
            $this->Loader->getCacheKey('TestTwigView.twig.twig')
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
