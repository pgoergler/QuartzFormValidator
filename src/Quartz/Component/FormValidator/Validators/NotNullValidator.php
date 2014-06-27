<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of NotNullValidator
 *
 * @author paul
 */
class NotNullValidator extends AbstractFormFieldValidator
{

    public function sanitizeValue($value)
    {
        if ($value === null)
        {
            return new \Quartz\Component\FormValidator\NotSetField($value);
        }

        return $value;
    }

    public function checkValue($field, $value)
    {
        if ($value instanceof \Quartz\Component\FormValidator\NotSetField)
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, 'you must set a value');
        }
        
        if (is_null($value))
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, 'you must set a value');
        }
        
        return $value;
    }

}
