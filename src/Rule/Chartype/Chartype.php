<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Phypes\Rule\Chartype;


abstract class Chartype
{
    /**
     * Special characters excused within the string pattern
     * Handy for username validations
     * @var array $allowedSpecialChars
     */
    protected $allowedSpecialChars = [];

    /**
     * AlphaNumeric constructor.
     * @param array $allowedSpecialChars
     */
    public function __construct($allowedSpecialChars = [])
    {
        $this->allowedSpecialChars = $allowedSpecialChars;
    }
}