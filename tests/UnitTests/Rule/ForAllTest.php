<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phypes\UnitTest\Rule;

use Phypes\Exception\InvalidAggregateRule;
use Phypes\Result\Result;
use Phypes\Rule\Aggregate\ForAll;
use PHPUnit\Framework\TestCase;
use Phypes\Rule\Rule;
use Phypes\Rule\String\Alpha;

class ForAllTest extends TestCase
{
    /**
     * @throws InvalidAggregateRule
     */
    public function testImplementsRuleInterface() : void
    {
        $this->assertInstanceOf(Rule::class, new ForAll(new Alpha()));
    }

    public function testEmptyInput() : void
    {
       $this->expectException(InvalidAggregateRule::class);
       new ForAll();
    }

    public function testValidateReturnsResult() : void
    {
        $rule = new AlphaNumeric();
        $this->assertInstanceOf(Result::class, $rule->validate('helloworld'));
    }

}
