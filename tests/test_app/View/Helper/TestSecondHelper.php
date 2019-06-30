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

namespace App\View\Helper;

use App\Exception\MissingSomethingException;
use Cake\View\Helper;

class TestSecondHelper extends Helper
{
    public function bogus()
    {
        throw new MissingSomethingException('Something is missing');
    }
}
