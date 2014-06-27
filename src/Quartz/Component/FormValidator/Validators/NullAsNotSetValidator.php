<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of NullAsNotSetValidator
 *
 * @author paul
 */
class NullAsNotSetValidator extends AbstractFormFieldValidator
{

    public function sanitizeValue($value)
    {
        if (is_null($value))
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
