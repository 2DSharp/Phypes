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

use Phypes\Error\Error;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Rule;
use Phypes\Rule\String\TextCase;
use PHPUnit\Framework\TestCase;

class TextCaseTest extends TestCase
{
    // TODO: Add test cases for strict modes
    /**
     * Test if the rule implements the Rule interface
     */
    public function testImplementsRuleInterface() : void
    {
        $this->assertInstanceOf(Rule::class, new TextCase(TextCase::MIXED));
    }

    public function testInvalidLevel() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        new TextCase(3);

        $this->expectException(\InvalidArgumentException::class);
        new TextCase(-1);
    }
    /**
     * Calling validate should return a AbstractResult value object
     */
    public function testValidateReturnsResult() : void
    {
        $rule = new TextCase(TextCase::MIXED);
        $result = $rule->validate('teststring');
        $this->assertInstanceOf(Result::class, $result);
    }

    /**
     * Should return an instance of Success and isValid() is set to true
     */
    public function testMixedSuccess() : void
    {
        $rule = new TextCase(TextCase::MIXED);
        $result = $rule->validate('MixedCasing');
        $this->assertTrue($result->isValid());
        $this->assertInstanceOf(Success::class, $result);
    }

    public function testAllCapsSuccess() : void
    {
        $rule = new TextCase(TextCase::ALL_CAPS);
        $result = $rule->validate('ALLCAPS');
        $this->assertTrue($result->isValid());
        $this->assertInstanceOf(Success::class, $result);
    }

    public function testNoneCapsSuccess() : void
    {
        $rule = new TextCase(TextCase::NONE_CAPS);
        $result = $rule->validate('nonecaps');
        $this->assertTrue($result->isValid());
        $this->assertInstanceOf(Success::class, $result);
    }

    /**
     * Check validation status on failure
     */
    public function testMixedFailureBoolean() : void
    {
        $rule = new TextCase(TextCase::MIXED);
        $result = $rule->validate('allsmall');
        $this->assertFalse($result->isValid());
    }
    public function testAllCapsFailureBoolean() : void
    {
        $rule = new TextCase(TextCase::ALL_CAPS);
        $result = $rule->validate('MixedCase');
        $this->assertFalse($result->isValid());
    }

    public function testNoneCapsFailureBoolean() : void
    {
        $rule = new TextCase(TextCase::NONE_CAPS);
        $result = $rule->validate('MixedCase');
        $this->assertFalse($result->isValid());
    }


    /**
     * Check result type on failure
     */
    public function testMixedFailureInstance() : void
    {
        $rule = new TextCase(TextCase::MIXED);
        $result = $rule->validate('smalltext');
        $this->assertInstanceOf(Failure::class, $result);
    }

    // Edge cases for mixed
    public function testEmpty() : void
    {
        $rule = new TextCase(TextCase::MIXED);
        $result = $rule->validate('');
        $this->assertFalse($result->isValid());

        $rule = new TextCase(TextCase::ALL_CAPS);
        $result = $rule->validate('');
        $this->assertFalse($result->isValid());

        $rule = new TextCase(TextCase::NONE_CAPS);
        $result = $rule->validate('');
        $this->assertFalse($result->isValid());
    }

    public function getWrongMixedValues()
    {
        return [
            yield [
                '____',
            ],
            yield [
                '1234',
            ],
            yield [
                '    ',
            ],
            yield [
                '213_12.4 ~#'
            ]
        ];
    }
    /**
     * Check results of not having an alphabet at all
     * @dataProvider getWrongMixedValues
     */
    public function testMixedOtherCharsFailure(string $wrongValues) : void
    {
        $rule = new TextCase(TextCase::MIXED);

        $result = $rule->validate($wrongValues);
        $this->assertFalse($result->isValid());
    }

    /**
     * @dataProvider getWrongMixedValues
     * @param string $wrongValues
     */
    public function testAllCapsOtherCharsFailure(string $wrongValues) : void
    {
        $rule = new TextCase(TextCase::ALL_CAPS);

        $result = $rule->validate($wrongValues);
        $this->assertFalse($result->isValid());
    }

    /**
     * @dataProvider getWrongMixedValues
     * @param string $wrongValues
     */
    public function testNoneCapsOtherCharsFailure(string $wrongValues) : void
    {
        $rule = new TextCase(TextCase::NONE_CAPS);

        $result = $rule->validate($wrongValues);
        $this->assertFalse($result->isValid());
    }

    /**
     * Check if only one valid type of alphabet and the other invalid characters yield failure
     */
    public function testMixedOneAlphaOtherCharsFailure() : void
    {
        $rule = new TextCase(TextCase::MIXED);

        $lower = 'a2312_ 23bcd';
        $result = $rule->validate($lower);
        $this->assertFalse($result->isValid());

        $upper = '23_ B#..ACID';
        $result = $rule->validate($upper);
        $this->assertFalse($result->isValid());
    }

    public function getCorrectMixedValues()
    {
        return [
            yield [
                'abc   _23 UPPER',
            ],
            yield [
                '__HailPHP',
            ],
            yield [
                'a B' ,
            ],
        ];
    }

    /**
     * Minimum conditions met with other characters
     * @dataProvider getCorrectMixedValues
     */
    public function testMixedOtherCharsSuccess($correctValues) : void
    {
        $rule = new TextCase(TextCase::MIXED);

        $result = $rule->validate($correctValues);
        $this->assertTrue($result->isValid());
    }

    /**
     * Return error on failure
     */
    public function testValidateFailureErrorInstance() : void
    {
        $rule = new TextCase(TextCase::MIXED);
        $result = $rule->validate('abc');

        $this->assertInstanceOf(Error::class, $result->getFirstError());
    }

}
