<?php

/**
 * This file is part of TwigView.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace WyriHaximus\CakePHP\Tests\TwigView\Lib\Twig\Extension;

use Cake\TestSuite\TestCase;

abstract class AbstractExtensionTest extends TestCase
{
    /**
     * @var \Twig_ExtensionInterface
     */
    protected $extension;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function testGetTokenParsers()
    {
        $tokenParsers = $this->extension->getTokenParsers();
        $this->assertTrue(is_array($tokenParsers));
        foreach ($tokenParsers as $tokenParser) {
            $this->assertTrue($tokenParser instanceof \Twig_TokenParserInterface || $tokenParser instanceof \Twig_TokenParserBrokerInterface);
        }
    }

    public function testGetNodeVisitors()
    {
        $nodeVisitors = $this->extension->getNodeVisitors();
        $this->assertTrue(is_array($nodeVisitors));
        foreach ($nodeVisitors as $nodeVisitor) {
            $this->assertInstanceOf('Twig_NodeVisitorInterface', $nodeVisitor);
        }
    }

    public function testGetFilters()
    {
        $filters = $this->extension->getFilters();
        $this->assertTrue(is_array($filters));
        foreach ($filters as $filter) {
            $this->assertInstanceOf('Twig_SimpleFilter', $filter);
        }
    }

    protected function getFilter($name)
    {
        $filters = $this->extension->getFilters();
        foreach ($filters as $filter) {
            if ($filter->getName() === $name) {
                return $filter;
            }
        }
    }

    public function testName()
    {
        $name = $this->extension->getName();
        $this->assertInternalType('string', $name);
        $this->assertTrue(strlen($name) > 0);
    }
}
