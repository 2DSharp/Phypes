<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Phypes\Exception;


use Phypes\Error\Error;

class InvalidValue extends \Exception
{
    /**
     * @var array|Error $errors
     */
    private $errors;
    /**
     * InvalidValue constructor.
     * @param string $message
     * @param array|Error $errors
     * @param int $code
     */
    public function __construct(string $message = "", $errors = [], int $code = 0)
    {
        parent::__construct($message, $code);
        $this->errors = $errors;
    }

    /**
     * @return array|Error
     */
    public function getErrors()
    {
        return $this->errors;
    }
}