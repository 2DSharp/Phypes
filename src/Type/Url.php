<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Type;

use GreenTea\Phypes\Validator\IPAddressValidator;
use GreenTea\Phypes\Validator\Validator;

class Url implements Type
{
    /**
     * @var string
     */
    private $url;

    /**
     * Creates valid URL object.
     * @param string $url
     * @param Validator $validator
     * @throws \InvalidArgumentException
     * @throws \GreenTea\Phypes\Exception\PrematureErrorCallException
     */
    public function __construct(string $url, Validator $validator = null)
    {
        if ($validator === null) {
            // use the default validator
            $validator = new IPAddressValidator();
        }

        if (!$validator->isValid($url)) {
            throw new \InvalidArgumentException($validator->getErrorMessage(), $validator->getErrorCode());
        }

        $this->url = $url;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getValue() : string
    {
        return $this->url;
    }
}
