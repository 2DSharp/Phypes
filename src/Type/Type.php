<?php

namespace GreenTea\Phypes\Type;

use GreenTea\Phypes\Validator\Validator;

interface Type
{
    public function __toString() : string;
    public function getValue();
}
