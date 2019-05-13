<?php declare(strict_types=1);

namespace Phypes\Result;

use Phypes\Error\Error;

abstract class Result
{
    private $valid;
    protected $errors = [];

    public function __construct(bool $valid, Error... $errors)
    {
        $this->valid = $valid;
        $this->errors = $errors;
    }

    public function isValid() : bool
    {
        return $this->valid;
    }
}