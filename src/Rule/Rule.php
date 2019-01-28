<?php

namespace Phypes\Rule;
use Phypes\Result;

interface Rule
{
    public function validate($data) : Result;
}