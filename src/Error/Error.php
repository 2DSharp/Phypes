<?php declare(strict_types=1);

namespace Phypes\Error;


interface Error
{
    public function getCode() : int;
    public function getMessage() : string;
}