<?php
declare(strict_types=1);
/*
 * This file is part of Phypes.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phypes\Result;

use Phypes\Error\Error;

/**
 * Class Failure
 *
 * Specialized result class for failed cases
 * @package Phypes\Result
 * @author Dedipyaman Das <2d@twodee.me>
 */
class Failure extends Result
{
    public function __construct(Error... $errors)
    {
        parent::__construct(false, $errors);
    }
}