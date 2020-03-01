<?php
declare(strict_types=1);

/**
 * This file is part of TwigView.
 *
 ** (c) 2014 Cees-Jan Kiewiet
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Cake\TwigView\Lib\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class Arrays.
 *
 * @internal
 */
final class Arrays extends AbstractExtension
{
    /**
     * Get declared functions.
     *
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('in_array', 'in_array'),
            new TwigFunction('explode', 'explode'),
            new TwigFunction('array', function ($array) {
                return (array)$array;
            }),
            new TwigFunction('array_push', 'array_push'),
            new TwigFunction('array_prev', 'prev'),
            new TwigFunction('array_next', 'next'),
            new TwigFunction('array_current', 'current'),
        ];
    }

    /**
     * Get extension name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'array';
    }
}
