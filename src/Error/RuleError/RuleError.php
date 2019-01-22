<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 1/23/19
 * Time: 2:53 AM
 */

namespace Phypes\Error\RuleError;

use Phypes\Error\Error;

class RuleError implements Error
{
    private $code;
    private $message;

    public function __construct(int $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}