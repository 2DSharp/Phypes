<?php
declare(strict_types=1);

namespace Phypes\Validator;

use Phypes\Result;

interface Validator
{
    public function getResult($type, $options = []) : Result;
}