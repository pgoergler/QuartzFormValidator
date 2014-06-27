<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of EmptyAsNotSetValidator
 *
 * @author paul
 */
class EmptyAsNotSetValidator extends AbstractFormFieldValidator
{

    public function sanitizeValue($value)
    {
        if (is_null($value) || $value === '' || (is_array($value) && empty($value)))
        {
            return new \Quartz\Component\FormValidator\NotSetField($value);
        }

        return $value;
    }

    public function checkValue($field, $value)
    {
        return $value;
    }

}
