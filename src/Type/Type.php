<?php

namespace GreenTea\Flux\Type;

use GreenTea\Flux\Validator\Validator;

interface Type
{
    public function __toString() : string;
    public function getValue();
}




