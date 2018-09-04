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

    public function testImplementsInterface()
    {
        $this->assertInstanceOf(Validator::class, new EmailValidator());
    }

    public function testIsValid()
    {
        $validator = new EmailValidator();
        
        $result = $validator->isValid('2d@twodee.me');
        $this->assertTrue($result);

        $result = $validator->isValid('12345lol@');
        $this->assertFalse($result);
    }
}
