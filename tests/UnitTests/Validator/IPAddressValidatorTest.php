<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Validator;

use PHPUnit\Framework\TestCase;

class IPAddressValidatorTest extends TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new IPAddressValidator();
    }

    public function testImplementsInterface() : void
    {
        $this->assertInstanceOf(Validator::class, $this->validator);
    }

    /**
     * Test passing condition on a valid ip address
     */
    public function testIsValidPass() : void
    {
        $result = $this->validator->isValid('127.0.0.1');
        $this->assertTrue($result);
    }

    /**
     * Should fail and return false
     */
    public function testIsValidFailure() : void
    {
        $result = $this->validator->isValid('127.0.0');
        $this->assertFalse($result);
    }
}
