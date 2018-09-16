<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Type;

interface Type
{
    public function __toString() : string;
    public function getValue();
}
