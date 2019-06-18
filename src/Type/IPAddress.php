<?php declare(strict_types=1);

namespace Phypes\Type;

use Phypes\Exception\InvalidValue;
use Phypes\Result\Failure;
use Phypes\Validator\IPAddressValidator;
use Phypes\Validator\Validator;

class IPAddress implements Type
{
    /**
     * @var string $ip
     */
    private $ip;

    /**
     * Create an ip address object if data is valid.
     * @param string $ip
     * @param Validator $validator
     * @throws \InvalidArgumentException
     */
    public function __construct(string $ip, Validator $validator = null)
    {
        if ($validator == null) {
            // use the default validator
            $validator = new IPAddressValidator();
        }

        $result = $validator->validate($ip);
        if (!$result->isValid()) {
            /**
             * @var Failure $result
             */
            throw new InvalidValue($result->getFirstError()->getMessage(), $result->getErrors());
        }
        $this->ip = $ip;
    }

    /**
     * Get string representation of the ip address object.
     * @return string
     */
    public function __toString(): string
    {
        return $this->ip;
    }

    /**
     * Get real value of the ip address object.
     * @return string
     */
    public function getValue() : string
    {
        return $this->ip;
    }
}