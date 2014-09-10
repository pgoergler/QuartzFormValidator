<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of MandatoryValidator
 *
 * @author paul
 */
class MandatoryValidator extends AbstractFormFieldValidator
{

    public function checkValue(\Quartz\Component\FormValidator\FormField $field, $value)
    {
        if ($value instanceof \Quartz\Component\FormValidator\NotSetField)
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, 'you must set a value');
        }
        return $value;
    }

}
