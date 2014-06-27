<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of EnumValidator
 *
 * @author paul
 */
class EnumValidator extends AbstractFormFieldValidator
{

    protected $values = array();
    protected $strict = false;

    public function __construct($enumValues, $strict = false)
    {
        $this->values = $enumValues;
        $this->strict = $strict;
        parent::__construct();
    }

    public function checkValue($field, $value)
    {
        if ($value instanceof \Quartz\Component\FormValidator\NotSetField)
        {
            return $value;
        }

        if (!in_array($value, $this->values, $this->strict))
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, 'you must choose a valid value');
        }
        return $value;
    }

}
