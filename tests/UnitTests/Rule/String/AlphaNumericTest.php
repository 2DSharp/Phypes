<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phypes\UnitTest\Rule\String;

use Phypes\Error\RuleErrorCode;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Rule;
use Phypes\Rule\String\AlphaNumeric;
use PHPUnit\Framework\TestCase;

class AlphaNumericTest extends TestCase
{
    public function testImplementsRuleInterface() : void
    {
        $this->assertInstanceOf(Rule::class, new AlphaNumeric());
    }

    public function testValidateReturnsResult() : void
    {
        $rule = new AlphaNumeric();
        $this->assertInstanceOf(Result::class, $rule->validate('helloworld'));
    }

    public function testResultTypes() : void
    {
        $rule = new AlphaNumeric();
        $this->assertInstanceOf(Failure::class, $rule->validate('aldsk das'));
        $this->assertInstanceOf(Success::class, $rule->validate('abc123'));
    }

    /**
     * @dataProvider getIncorrectValuesNoSplChars
     * @param $text
     */
    public function testFailureNoSplCharsAllowed($text) : void
    {
        $rule = new AlphaNumeric();
        $this->assertFalse($rule->validate($text)->isValid());
    }

    public function getIncorrectValuesNoSplChars()
    {
        return [
            yield [
                'abc 123',
            ],
            yield [
                '#~..',
            ],
            yield [
                '123$' ,
            ],
            yield [
                ' ' ,
            ],
        ];
    }

    /**
     * @dataProvider getCorrectValuesNoSplChars
     * @param $text
     */
    public function testSuccessNoSplCharsAllowed($text)
    {
        $rule = new AlphaNumeric();
        $this->assertTrue($rule->validate($text)->isValid());
    }

    public function getCorrectValuesNoSplChars()
    {
        return [
            yield ['abc'],
            yield ['123abc'],
            yield ['abc123'],
            yield ['1238']
        ];
    }

    public function testFailureWithSplChars() : void
    {
        $rule = new AlphaNumeric([' ']);
        $this->assertFalse($rule->validate('abc #123')->isValid());

        $rule = new AlphaNumeric(['_', '-']);
        $this->assertFalse($rule->validate('abc #123')->isValid());

        $rule = new AlphaNumeric(['$', '-']);
        $this->assertFalse($rule->validate('$ab~c#123')->isValid());

        $rule = new AlphaNumeric(['$', '-']);
        $this->assertFalse($rule->validate(' ')->isValid());
    }

    public function testSuccessWithSplChars() : void
    {
        $rule = new AlphaNumeric([' ']);
        $this->assertTrue($rule->validate('abc 123')->isValid());

        $rule = new AlphaNumeric(['_', '-']);
        $this->assertTrue($rule->validate('_test')->isValid());

        $rule = new AlphaNumeric(['$', '-']);
        $this->assertTrue($rule->validate('$abc-123')->isValid());

        $rule = new AlphaNumeric(['$', '-']);
        $this->assertTrue($rule->validate('123')->isValid());
    }

    public function testFailureError() : void
    {
        $rule = new AlphaNumeric(['_']);
        /**
         * @var Failure $failure
         */
        $failure = $rule->validate('~john');
        $this->assertEquals(RuleErrorCode::NOT_ALNUM, $failure->getFirstError()->getCode());

    }
}
