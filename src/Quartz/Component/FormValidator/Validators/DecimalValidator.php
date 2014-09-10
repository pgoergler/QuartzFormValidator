<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of DecimalValidator
 *
 * @author paul
 */
class DecimalValidator extends RegexValidator
{

    protected $length = 10;
    protected $decimal = 2;

    public function __construct($length, $decimal)
    {
        $this->length = $length;
        $this->decimal = $decimal;
        $intSize = $length - $decimal - 1;
        $decimalSize = $decimal;

        $regex = "^(?P<sign>\-?)[0]*(?P<int>[1-9][0-9]{0,$intSize}|0+)(\.(?P<decimal>[0-9]{0,$decimalSize}))?$";
        parent::__construct($regex);
    }

    public function sanitizeValue($value)
    {
        if (is_null($value))
        {
            return null;
        }

        if (is_string($value))
        {
            $regex = '#^(?P<sign>\-?)[0]*(?P<int>[1-9][0-9]*|0+)(\.(?P<decimal>[0-9]*))?$#';
            if (!preg_match($regex, $value))
            {
                return new \Quartz\Component\FormValidator\NotSetField($value);
            }
            settype($value, 'double');
        }

        if (is_numeric($value))
        {
            settype($value, 'double');
            return $value;
        }
        return new \Quartz\Component\FormValidator\NotSetField($value);
    }

    public function checkValue(\Quartz\Component\FormValidator\FormField $field, $value)
    {
        if ($value instanceof \Quartz\Component\FormValidator\NotSetField)
        {
            return $value;
        }

        if (is_null($value))
        {
            return $value;
        }

        try
        {
            parent::checkValue($field, "$value");
            return $value;
        } catch( \Quartz\Component\FormValidator\Exceptions\ErrorException $e)
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($e->getField(), $e->getValue(), 'you must set a valid number', $e->getContext());
        }
    }

}
