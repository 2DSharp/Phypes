<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 9/4/18
 * Time: 11:56 PM
 */

namespace GreenTea\Phypes\Validator;

use PHPUnit\Framework\TestCase;

class EmailValidatorTest extends TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new EmailValidator();
    }

    public function testImplementsInterface()
    {
        $this->assertInstanceOf(Validator::class, $this->validator);
    }

    public function testIsValidPass()
    {
        $result = $this->validator->isValid('2d@twodee.me');
        $this->assertTrue($result);
    }

    public function testIsValidFailure()
    {
        $result = $this->validator->isValid('12345lol@');
        $this->assertFalse($result);
    }
}
