<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of IncludedInValidator
 *
 * @author paul
 */
class IncludedInValidator extends EnumValidator
{

    public function sanitizeValue($value)
    {
        return is_array($value) ? $value : new \Quartz\Component\FormValidator\NotSetField($value);
    }

    public function checkValue($field, $value)
    {
        if ($value instanceof \Quartz\Component\FormValidator\NotSetField)
        {
            if( !is_null($value->getRawValue()) && !is_array($value->getRawValue()) )
            {
                throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, '{0} is not an array', array('{0}' => $value));
            }
            return $value;
        }
        
        try
        {
            foreach( $value as $v )
            {
                parent::checkValue($field, $v);
            }
            return $value;
        } catch( \Quartz\Component\FormValidator\Exceptions\ErrorException $e)
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($e->getField(), $e->getValue(), '[{0}] is not included in [{1}]', $e->getContext());
        }
    }

}
