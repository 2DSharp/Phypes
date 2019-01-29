<?php declare(strict_types=1);

namespace Phypes\Rule;
use Phypes\Result\Result;

interface Rule
{
    public function validate($data) : Result;
}