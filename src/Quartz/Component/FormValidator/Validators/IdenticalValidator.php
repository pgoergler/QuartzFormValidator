<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of IdenticalValidator
 *
 * @author paul
 */
class IdenticalValidator extends AbstractFormFieldValidator
{

    protected $value;

    public function __construct($value)
    {
        parent::__construct();
        $this->value = $value;
    }

    public function checkValue(\Quartz\Component\FormValidator\FormField $field, $value)
    {
        if ($value !== $this->value)
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, "value are not equal");
        }
        return $value;
    }

}
