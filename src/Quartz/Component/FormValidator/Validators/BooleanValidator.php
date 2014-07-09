<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of BooleanValidator
 *
 * @author paul
 */
class BooleanValidator extends StringValidator
{

    public function sanitizeValue($value)
    {
        if (is_null($value))
        {
            return $value;
        } elseif (is_numeric($value))
        {
            return $value != 0;
        } elseif (is_string($value))
        {
            return in_array($value, array('yes', 'on', 'true', '1'));
        } elseif (is_bool($value))
        {
            return $value;
        }

        return new \Quartz\Component\FormValidator\NotSetField($value);
    }

    public function checkValue($field, $value)
    {
        if ($value instanceof \Quartz\Component\FormValidator\NotSetField)
        {
            return $value;
        }

        if (is_null($value))
        {
            return $value;
        }

        return boolval($value);
    }

}
