<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Type;

use GreenTea\Phypes\Type\Type;
use GreenTea\Phypes\Validator\IPValidator;
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
     */
    public function __construct(string $ip, Validator $validator = null)
    {
        if ($validator == null) {
            // use the default validator
            $validator = new IPValidator();
        }

        if (!$validator->isValid($ip)) {
            throw new \InvalidArgumentException("The provided ip address in invalid.");
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