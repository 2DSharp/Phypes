<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Type;

use GreenTea\Phypes\Validator\PasswordValidator;
use GreenTea\Phypes\Validator\Validator;

class Password implements Type
{
    /**
     * @var string $password
     */
    private $password;

    /**
     * Create an password object if data is valid.
     * @param string $password
     * @param Validator $validator
     * @throws \InvalidArgumentException
     */
    public function __construct(string $password, Validator $validator = null)
    {
        if ($validator == null) {
            // use the default validator
            $validator = new PasswordValidator();
        }

        if (!$validator->isValid($password)) {
            throw new \InvalidArgumentException('The provided password is invalid.');
        }
        $this->password = $password;
    }

    /**
     * Get string representation of the password object.
     * @return string
     */
    public function __toString(): string
    {
        return $this->password;
    }

    /**
     * Get real value of the password object.
     * @return string
     */
    public function getValue() : string
    {
        return $this->password;
    }
}