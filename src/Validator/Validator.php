<?php

namespace GreenTea\Phypes\Validator;

interface Validator
{
    public function isValid($type, $options = []) : bool;
}