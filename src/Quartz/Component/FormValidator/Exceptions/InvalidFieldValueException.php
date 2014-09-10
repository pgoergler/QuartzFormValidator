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
        $this->context = array();
        foreach( $context as $k => $v) {
            if( is_numeric($k) ) {
                $k = "{" . $k ."}";
            }
            $this->context[$k] = $v;
        }
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
    
    /*public function __toString()
    {
        return $this->getMessage();
    }*/

}
