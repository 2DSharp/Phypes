<?php declare(strict_types=1);

namespace Phypes\Result;

use Phypes\Error\Error;

abstract class Result
{
    private $valid;
    private $errors = [];

    public function __construct(bool $valid, Error... $errors)
    {
        $this->valid = $valid;
        $this->errors = $errors;
    }

    public function isValid() : bool
    {
        return $this->valid;
    }

    /**
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getFirstError() : ?Error
    {
        if (!$this->valid) {
            return $this->errors[0];
        }
        return null;
    }
}