<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of NumberValidator
 *
 * @author paul
 */
class NumberValidator extends RegexValidator
{

    protected $min = null;
    protected $max = null;
    protected $type = 'integer';
    protected $realType = 'integer';

    public function __construct($min = null, $max = null, $type = 'number')
    {
        if (func_num_args() >= 2)
        {
            $this->min = $min;
            $this->max = $max;
        } else if (func_num_args() == 1)
        {
            $this->max = $this->min = $min;
        } else if (func_num_args() == 0)
        {
            $this->min = null;
            $this->max = null;
        }

        switch ($type)
        {
            case 'unsigned float':
            case 'unsigned double':
                $regex = '^[0]*(?P<int>[1-9][0-9]*|0+)\.((?P<decimal>[0-9]*))?$';
                $this->realType = $type;
                $type = 'double';
                break;
            case 'unsigned integer':
                $regex = '^[0]*(?P<int>[1-9][0-9]*|0+)$';
                $this->realType = $type;
                $type = 'integer';
                break;
            case 'float':
            case 'double':
                $regex = '^(?P<sign>\-?)[0]*(?P<int>[1-9][0-9]*|0+)\.((?P<decimal>[0-9]*))?$';
                $this->realType = $type;
                break;
            case 'integer':
                $regex = '^(?P<sign>\-?)[0]*(?P<int>[1-9][0-9]*|0+)$';
                $this->realType = 'integer';
                break;
            case 'number':
            default:
                $regex = '^(?P<sign>\-?)[0]*(?P<int>[1-9][0-9]*|0+)(\.(?P<decimal>[0-9]*))?$';
                $this->realType = 'number';
                $type = 'float';
        }

        $this->type = $type;
        parent::__construct($regex);
    }

    public function sanitizeValue($value)
    {
        if (is_null($value))
        {
            return null;
        }

        if( is_numeric($value) || is_string($value))
        {
            if (!preg_match($this->getRegex(), "$value"))
            {
                return new \Quartz\Component\FormValidator\NotSetField($value);
            }

            settype($value, $this->type);
        }

        if (is_numeric($value))
        {
            settype($value, $this->type);
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

        switch ($this->type)
        {
            case 'unsigned float':
            case 'unsigned double':
                $regex = '#^[0]*(?P<int>[1-9][0-9]*|0+)(\.(?P<decimal>[0-9]*))?$#';
                $type = 'double';
                break;
            case 'unsigned integer':
                $regex = '#^[0]*(?P<int>[1-9][0-9]*|0+)$#';
                $type = 'integer';
                break;
            case 'float':
            case 'double':
                $regex = '#^(?P<sign>\-?)[0]*(?P<int>[1-9][0-9]*|0+)(\.(?P<decimal>[0-9]*))?$#';
                break;
            case 'integer':
            default:
                $regex = '#^(?P<sign>\-?)[0]*(?P<int>[1-9][0-9]*|0+)$#';
        }

        try
        {
            parent::checkValue($field, "$value");
        } catch (\Quartz\Component\FormValidator\Exceptions\ErrorException $e)
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($e->getField(), $e->getValue(), 'you must set a valid ' . $this->realType, $e->getContext());
        }

        if (!is_null($this->min) && $this->min > $value)
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, 'you must a number greater than {0}', array('{0}' => $this->min));
        }

        if (!is_null($this->max) && $this->max < $value)
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, 'you must a number lower than {0}', array('{0}' => $this->max));
        }

        return $value;
    }

}
