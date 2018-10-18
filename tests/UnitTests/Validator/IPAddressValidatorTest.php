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
     *
     * @dataProvider correctIpAddresses
     *
     * @param string $ipAddress
     */
    public function testIsValidPass(string $ipAddress) : void
    {
        $result = $this->validator->isValid($ipAddress);
        $this->assertTrue($result);
    }

    /**
     * Should fail and return false
     *
     * @dataProvider wrongIpAddresses
     *
     * @param string $ipAddress
     */
    public function testIsValidFailure(string $ipAddress) : void
    {
        $result = $this->validator->isValid($ipAddress);
        $this->assertFalse($result);
    }

    /**
     * Should fail and return the IP address invalid error code
     */
    public function testErrorCodeOnFailure() : void
    {
        $this->validator->isValid('123312');
        $result = $this->validator->getErrorCode();

        $this->assertEquals(Error::IP_INVALID, $result);
    }

    /**
     * Should pass and return null error code and message.
     */
    public function testErrorOnPass() : void
    {
        $this->validator->isValid('192.168.0.0');

        $code = $this->validator->getErrorCode();
        $msg = $this->validator->getErrorMessage();

        $this->assertNull($code);
        $this->assertNull($msg);
    }

    /**
     * Should fail and pass. Have the message and code unaffected by a different function call.
     */
    public function testMultipleValidations() : void
    {
        $this->testErrorCodeOnFailure();
        $this->testErrorOnPass();
    }

    public function correctIpAddresses()
    {
        return [
            yield [
                '127.0.0.1',
            ],
            yield [
                'FE80:0000:0000:0000:0202:B3FF:FE1E:8329',
            ],
            yield [
                'FE80::0202:B3FF:FE1E:8329',
            ],
        ];
    }

    public function wrongIpAddresses()
    {
        return [
            yield [
                '127.0.0',
            ],
            yield [
                'FE80:0000:0000:B3FF:FE1E:8329',
            ],
            yield [
                'FE80:2211:8329',
            ],
        ];
    }
}
