<?php
declare(strict_types=1);

/**
 * This file is part of TwigView.
 *
 ** (c) 2015 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace WyriHaximus\TwigView\Test\Lib\Twig\Extension;

use Twig\TokenParser\TokenParserInterface;
use Twig\TwigFilter;
use WyriHaximus\TwigView\Test\TestCase;

abstract class AbstractExtensionTest extends TestCase
{
    /**
     * @var \Twig\Extension\AbstractExtensionInterface
     */
    protected $extension;

    public function setUp(): void
    {
        parent::setUp();
    }

    public function tearDown(): void
    {
        parent::tearDown();
    }

    public function testGetTokenParsers()
    {
        $tokenParsers = $this->extension->getTokenParsers();
        $this->assertTrue(is_array($tokenParsers));
        foreach ($tokenParsers as $tokenParser) {
            $this->assertTrue($tokenParser instanceof TokenParserInterface);
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
            $this->assertInstanceOf(TwigFilter::class, $filter);
        }
    }

    public function testName()
    {
        $name = $this->extension->getName();
        $this->assertIsString($name);
        $this->assertTrue(strlen($name) > 0);
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

    protected function getFunction($name)
    {
        $functions = $this->extension->getFunctions();
        foreach ($functions as $function) {
            if ($function->getName() === $name) {
                return $function;
            }
        }
    }
}
