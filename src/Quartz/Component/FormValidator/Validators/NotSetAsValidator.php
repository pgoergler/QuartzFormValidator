<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of NotSetAsValidator
 *
 * @author paul
 */
class NotSetAsValidator extends AbstractFormFieldValidator
{

    protected $value;

    public function __construct($defaultValue = null)
    {
        parent::__construct();
        $this->value = $defaultValue;
    }

    public function checkValue($field, $value)
    {
        if ($value instanceof \Quartz\Component\FormValidator\NotSetField)
        {
            return $this->value;
        }
        return $value;
    }

}
