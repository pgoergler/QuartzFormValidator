<?php

namespace Quartz\Component\FormValidator\Validators;

use Quartz\Component\FormValidator\NotSetField;

/**
 * Description of AbstractFormFieldValidator
 *
 * @author paul
 */
abstract class AbstractFormFieldValidator
{

    protected $isMandatory;

    public function __construct($isMandatory = false)
    {
        $this->isMandatory = $isMandatory ? true : false; // to force boolean
    }

    public function isMandatory()
    {
        return $this->isMandatory;
    }

    /**
     * 
     * @param type $boolean
     * @return \Quartz\Component\FormValidator\FormFieldValidator
     */
    public function setMandatory($boolean)
    {
        $this->isMandatory = $boolean ? true : false; // to force boolean
        return $this;
    }

    public function sanitizeValue($value)
    {
        return $value;
    }

    public function validate($field, $value)
    {
        $sanitized = $this->sanitizeValue($value);
        if ($sanitized instanceof NotSetField)
        {
            if ($this->isMandatory())
            {
                throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, 'you must set a value');
            }
        }
        $result = $this->checkValue($field, $sanitized);
        if ($result instanceof NotSetField)
        {
            if ($this->isMandatory())
            {
                throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, 'you must set a value');
            }
        }
        return $result;
    }

    public abstract function checkValue($field, $value);
}
