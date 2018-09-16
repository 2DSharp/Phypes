<?php
declare(strict_types=1);

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

    public function testImplementsInterface() : void
    {
        $this->assertInstanceOf(Validator::class, $this->validator);
    }

    /**
     * Test passing condition on a valid email
     */
    public function testIsValidPass() : void
    {
        $result = $this->validator->isValid('2d@twodee.me');
        $this->assertTrue($result);
    }

    /**
     * Should fail and return false
     */
    public function testIsValidFailure() : void
    {
        $result = $this->validator->isValid('12345lol@');
        $this->assertFalse($result);
    }
}
