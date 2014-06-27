<?php

namespace Quartz\Component\FormValidator\Exceptions;

/**
 * Description of WarningException
 *
 * @author paul
 */
class InvalidFieldValueException extends \InvalidArgumentException
{

    protected $field;
    protected $value;
    protected $context;

    public function __construct($field, $value, $message, $context = array(), $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->field = $field;
        $this->value = $value;
        $this->context = $context;
    }

    public function getField()
    {
        return $this->field;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getContext()
    {
        return $this->context;
    }

    public function shouldStopValidation()
    {
        return false;
    }

}
