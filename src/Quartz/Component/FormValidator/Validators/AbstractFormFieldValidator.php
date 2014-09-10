<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of AbstractFormFieldValidator
 *
 * @author paul
 */
abstract class AbstractFormFieldValidator
{

    public function __construct()
    {
        
    }

    public function sanitizeValue($value)
    {
        return $value;
    }

    public function validate(\Quartz\Component\FormValidator\FormField $field, $value)
    {
        return $this->checkValue($field, $this->sanitizeValue($value));
    }

    public abstract function checkValue(\Quartz\Component\FormValidator\FormField $field, $value);
}
