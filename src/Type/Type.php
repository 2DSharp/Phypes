<?php
namespace GreenTea\Phypes\Type;

/**
 * Represents a single Type.
 * @author Mangopeaches <https://github.com/mangopeaches>
 */
abstract class Type
{
    /**
     * Provided value.
     *
     * @var mixed
     */
    protected $value;

    /**
     * Error message when validation fails.
     *
     * @var string
     */
    protected $error = '';

    /**
     * Instantiate a new instance.
     *
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * Get string representation of the object.
     * @return string
     */
    public function __toString()
    {
        return $this->value;
    }

    /**
     * Returns the provided data value.
     *
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Performs validation on the type and returns whether or not the type is valid.
     *
     * @return boolean
     */
    public abstract function isValid();

    /**
     * Returns error message for failed validation.
     *
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}
