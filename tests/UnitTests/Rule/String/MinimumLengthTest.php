<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 1/23/19
 * Time: 6:04 PM
 */

namespace Phypes\UnitTest\Rule\String;

use PHPUnit\Framework\TestCase;
use Phypes\Error\Error;
use Phypes\Error\RuleErrorCode;
use Phypes\Result;
use Phypes\Rule\Rule;
use Phypes\Rule\String\MinimumLength;

class MinimumLengthTest extends TestCase
{
    /**
     * Test if the rule implements the Rule interface
     */
    public function testImplementsRuleInterface() : void
    {
        $this->assertInstanceOf(Rule::class, new MinimumLength(10));
    }

    /**
     * Calling validate should return a Result value object
     */
    public function testValidateReturnsResult() : void
    {
        $rule = new MinimumLength(5);
        $successResult = $rule->validate('MediumText');
        $this->assertInstanceOf(Result::class, $successResult);

        $rule = new MinimumLength(5);
        $failureResult = $rule->validate('Small');
        $this->assertInstanceOf(Result::class, $failureResult);
    }

    /**
     * Check validation status on failure
     */
    public function testValidateFailureBoolean() : void
    {
        $result = $this->getFailedResult();
        $this->assertFalse($result->isValid()) ;
    }

    /**
     * Return error on failure
     */
    public function testValidateFailureErrorInstance() : void
    {
        $result = $this->getFailedResult();
        $this->assertInstanceOf(Error::class, $result->getFirstError());
    }

    /**
     * Validate the Error object values
     */
    public function testValidateFailureError()
    {
        $result = $this->getFailedResult();
        $error = $result->getFirstError();

        $this->assertEquals(RuleErrorCode::TOO_SHORT, $error->getCode());
        $this->assertEquals('The supplied string is too short', $error->getMessage());
    }

    /**
     * Should pass at the exact minimum value specified
     */
    public function testValidateSuccessExactValue()
    {
        $text = 'Apple';
        $rule = new MinimumLength(5);
        $result = $rule->validate($text);

        $this->assertTrue($result->isValid());
    }

    /**
     * Arbitrary length over minimum limit should pass
     */
    public function testValidateSuccessBoolean()
    {
        $text = 'LongEnoughText';
        $rule = new MinimumLength(10);
        $result = $rule->validate($text);

        $this->assertTrue($result->isValid());
    }

    /**
     * Success shouldn't return an Error instance
     */
    public function testValidateSuccessError()
    {
        $text = 'Player';
        $rule = new MinimumLength(5);
        $result = $rule->validate($text);

        $this->assertNull($result->getFirstError()) ;
    }

    private function getFailedResult() : Result
    {
        $text = "Hello";
        $rule = new MinimumLength(6);
        return $rule->validate($text);
    }
}
