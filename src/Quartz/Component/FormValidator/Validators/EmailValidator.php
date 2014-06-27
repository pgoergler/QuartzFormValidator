<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of EmailValidator
 *
 * @author paul
 */
class EmailValidator extends RegexValidator
{

    public function __construct($tags = '')
    {
        parent::__construct('^((.*?@.*?(\.[a-z]+)+)?)$', $tags);
    }
    
    public function sanitizeValue($value)
    {
        try
        {
            return parent::sanitizeValue($value);
        } catch (\InvalidArgumentException $e)
        {
            throw new \InvalidArgumentException('you must set a valid email', $e->getCode(), $e);
        }
    }

    public function checkValue($field, $value)
    {
        try
        {
            return parent::checkValue($field, $value);
        } catch (\Quartz\Component\FormValidator\Exceptions\ErrorException $e)
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($e->getField(), $e->getValue(), 'you must set a valid email');
        }
    }

}
