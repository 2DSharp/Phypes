<?php


namespace Phypes\Error;


interface Error
{
    public function getCode() : int;
    public function getMessage() : string;
}