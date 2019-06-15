<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phypes\UnitTest\Type;

use Phypes\Type\Username;
use PHPUnit\Framework\TestCase;

class UsernameTest extends TestCase
{
    public function testGetValue() : void
    {
        $username = new Username('dedipyaman');
        self::assertEquals('dedipyaman', $username->getValue());
    }

    public function testExceptionOnFailure() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Username('de#');
    }
}
