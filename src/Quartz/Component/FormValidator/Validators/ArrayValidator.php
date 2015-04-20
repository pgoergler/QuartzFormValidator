<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of ArrayValidator
 *
 * @author paul
 */
class ArrayValidator extends AbstractFormFieldValidator
{

    protected $validators = array();

    public function __construct(array $validators)
    {
        parent::__construct();
        $this->validators = $validators;
    }

    public function sanitizeValue($value)
    {
        if( is_array($value) || $value instanceof \Iterator )
        {
            foreach( $value as $i => $row )
            {
                $validator = array_key_exists($i, $this->validators) ? $this->validators[$i] : false;
                if( $validator )
                {
                    $value[$i] = $validator->sanitizeValue($row);
                }
                else
                {
                    return new \Quartz\Component\FormValidator\NotSetField($value);
                }
            }
        }
        
        return $value;
    }
    
    public function checkValue(\Quartz\Component\FormValidator\FormField $field, $value)
    {
        foreach( $value as $i => $row )
        {
            $validator = array_key_exists($i, $this->validators) ? $this->validators[$i] : false;
            if( $validator )
            {
                $value[$i] = $validator->validate($field, $row);
            }
            else
            {
                $message = "no validator found for key {0}";
                $context = array('{0}' => $i);
                throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, $message, $context);
            }
        }
        return $value;
    }

}
