<?php
declare(strict_types=1);

namespace Phypes\Type;

interface Type
{
    public function __toString() : string;
    public function getValue();
}
