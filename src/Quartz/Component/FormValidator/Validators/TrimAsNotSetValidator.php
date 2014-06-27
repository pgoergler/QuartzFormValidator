<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of TrimAsNotSetValidator
 *
 * @author paul
 */
class TrimAsNotSetValidator extends AbstractFormFieldValidator
{

    public function sanitizeValue($value)
    {
        if( is_string($value) )
        {
            $value = \trim($value);
            return $value === '' ? new \Quartz\Component\FormValidator\NotSetField($value) : $value;
        }
        return $value;
    }

    public function checkValue($field, $value)
    {
        return $value;
    }

}
