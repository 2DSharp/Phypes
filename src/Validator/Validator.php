<?php
namespace GreenTea\Phypes\Validator;

use GreenTea\Phypes\Type\Type;

/**
 * Actions specific to the validators that must be implemented or inherited.
 * @author Mangopeaches <https://github.com/mangopeaches>
 */
class Validator
{
    /**
     * Contains all validation error messages.
     *
     * @var array
     */
    private $errors = [];
    
    /**
     * Types to be validated.
     *
     * @var array
     */
    private $types = [];

    /**
     * Instantiate a new instance.
     *
     * @param Type|Types[] $types
     */
    public function __construct($types)
    {
        if (is_array($types)) {
            $this->types = $types;
        } else if ($types instanceof Type) {
            $this->types = [$types];
        }
    }

    /**
     * Performs validation on all the supplied types.
     *
     * @return bool
     */
    public function validate()
    {
        // validate each type
        foreach ($this->types as $type) {
            if (!$type->isValid()) {
                $reflector = new \ReflectionClass($type);
                $this->errors[] = [
                    'type' => strtolower($reflector->getShortName()),
                    'error' => $type->getError(),
                    'value' => $type->getValue()
                ];
            }
        }
        return count($this->errors) === 0;
    }
    /**
     * Returns the error messages.
     * 
     * @return string
     */
    public function errors()
    {
        return $this->errors;
    }
}