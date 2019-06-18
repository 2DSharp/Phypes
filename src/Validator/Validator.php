<?php declare(strict_types=1);

namespace Phypes\Validator;

use Phypes\Exception\InvalidRule;
use Phypes\Result\Result;

interface Validator
{
    /**
     * @throws InvalidRule
     * @param $type
     * @return Result
     */
    public function validate($type) : Result;
}