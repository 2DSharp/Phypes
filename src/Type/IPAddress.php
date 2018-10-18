<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Type;

use GreenTea\Phypes\Validator\Error;
use GreenTea\Phypes\Validator\IPAddressValidator;
use GreenTea\Phypes\Validator\Validator;

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
     * @throws \GreenTea\Phypes\Exception\PrematureErrorCallException
     */
    public function __construct(string $ip, Validator $validator = null)
    {
        if ($validator == null) {
            // use the default validator
            $validator = new IPAddressValidator();
        }

        if (!$validator->isValid($ip)) {
            throw new \InvalidArgumentException($validator->getErrorMessage(), $validator->getErrorCode());
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