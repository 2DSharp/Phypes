<?php declare(strict_types=1);

namespace Phypes\Error;


abstract class RuleErrorCode
{
    const LENGTH_ERROR = 420001;
    const NOT_ALNUM = 420003;
    const CASING_MISMATCH = 420004;
    const NOT_ALPHA = 420005;
    const PATTERN_MISMATCH = 420006;
}