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

use WyriHaximus\TwigView\Lib\Twig\Extension\PotentialDangerous;

final class PotentialDangerousTest extends AbstractExtensionTest
{
    public function setUp(): void
    {
        $this->extension = new PotentialDangerous();
        parent::setUp();
    }

    public function testFunctionConfig()
    {
        $callable = $this->getFunction('config')->getCallable();

        $result = call_user_func($callable, 'foo');
        $this->assertNull($result);

        $result = call_user_func($callable, 'debug');
        $this->assertIsBool($result);
    }
}
