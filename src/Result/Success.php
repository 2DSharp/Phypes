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

/**
 * Class Success
 *
 * Specialized result class for successful outcomes
 * @package Phypes\Result
 * @author Dedipyaman Das <2d@twodee.me>
 */
class Success extends Result
{
    public function __construct()
    {
        parent::__construct(true);
    }
}