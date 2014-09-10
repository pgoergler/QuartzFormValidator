<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of CallbackValidator
 *
 * @author paul
 */
class CallbackValidator extends AbstractFormFieldValidator
{
    protected $sanitizer = null;
    protected $checker = null;
    
    public function __construct($sanitizeCallback, $checkValueCallback)
    {
        parent::__construct();
        
        if( is_callable($sanitizeCallback) )
        {
            $this->sanitizer = $sanitizeCallback;
        }
        
        if( is_callable($checkValueCallback) )
        {
            $this->checker = $checkValueCallback;
        }
    }
    
    public function sanitizeValue($value)
    {
        if( $this->sanitizer )
        {
            $fn = $this->sanitizer;
            return $fn($value);
        }
        
        return parent::sanitizeValue($value);
    }
    
    public function checkValue(\Quartz\Component\FormValidator\FormField $field, $value)
    {
        if( $this->checker )
        {
            $fn = $this->checker;
            return $fn($field, $value);
        }
        
        return $value;
    }
}
