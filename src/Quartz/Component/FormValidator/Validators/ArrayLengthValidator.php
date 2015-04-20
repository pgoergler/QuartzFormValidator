<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of ArrayLengthValidator
 *
 * @author paul
 */
class ArrayLengthValidator extends AbstractFormFieldValidator
{

    protected $minLength = 0;
    protected $maxLength = null;

    public function __construct($minLength = 0, $maxLength = null)
    {
        parent::__construct();
        if (func_num_args() == 2)
        {
            $this->minLength = $minLength;
            $this->maxLength = $maxLength;
        } else if (func_num_args() == 1)
        {
            $this->maxLength = $this->minLength = $minLength;
        } else if (func_num_args() == 0)
        {
            $this->minLength = 0;
            $this->maxLength = null;
        }
    }

    public function sanitizeValue($value)
    {
        return (is_array($value) || $value instanceof \Countable) ? $value : new \Quartz\Component\FormValidator\NotSetField($value);
    }

    public function checkValue(\Quartz\Component\FormValidator\FormField $field, $value)
    {
        if ($value instanceof \Quartz\Component\FormValidator\NotSetField)
        {
            return $value;
        }
        
        if( is_null($value) )
        {
            return $value;
        }

        $len = null;
        if( is_array($value) )
        {
            $len = count($value);
        }
        elseif( $value instanceof \Countable )
        {
            $len = $value->count();
        }
        else
        {
            \Logging\LoggersManager::getInstance()->get()->debug($value);
        }

        if ($this->minLength <= $len)
        {
            if (is_null($this->maxLength) || $len <= $this->maxLength)
            {
                return $value;
            }
            $message = 'array length must be lower than {0}';
            $context = array('{0}' => $this->maxLength);
        } else if ($this->maxLength === $this->minLength && $len != $this->minLength)
        {
            $message = 'array length must be {0}';
            $context = array('{0}' => $this->minLength);
        } else if ($this->minLength < $this->maxLength && ($this->minLength > $len || $len > $this->maxLength))
        {
            $message = 'array length must be between {0} and {1}';
            $context = array('{0}' => $this->minLength, '{1}' => $this->maxLength);
        } else if (is_null($this->maxLength) && $this->minLength > $len)
        {
            $message = 'array length must be greater than {0}';
            $context = array('{0}' => $this->minLength);
        } else if (!is_null($this->maxLength) && $len > $this->maxLength)
        {
            $message = 'array length must be lower than {0}';
            $context = array('{0}' => $this->maxLength);
        } else
        {
            $message = 'you must set a valid value';
        }

        throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, $message, $context);
    }

}
