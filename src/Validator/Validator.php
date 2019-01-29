<?php declare(strict_types=1);

namespace Phypes\Validator;

use Phypes\Result\Result;

interface Validator
{
    public function validate($type, $options = []) : Result;
}