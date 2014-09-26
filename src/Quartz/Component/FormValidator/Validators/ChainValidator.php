<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of ChainValidator
 *
 * @author paul
 */
class ChainValidator extends AbstractFormFieldValidator
{

    protected $validators = array();

    public function __construct(array $validators)
    {
        parent::__construct();
        $this->validators = $validators;
    }

    public function sanitizeValue($value)
    {
        foreach ($this->validators as $validator)
        {
            $value = $validator->sanitizeValue($value);
        }
        return $value;
    }

    public function checkValue(\Quartz\Component\FormValidator\FormField $field, $value)
    {
        foreach ($this->validators as $validator)
        {
            $value = $validator->checkValue($field, $value);
        }
        return $value;
    }

}
