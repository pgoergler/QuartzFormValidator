<?php

namespace Quartz\Component\FormValidator;

/**
 * Description of NotSetField
 *
 * @author paul
 */
class NotSetField
{
    protected $raw_value = '';
    
    public function __construct($raw_value = '')
    {
        $this->raw_value = $raw_value instanceOf NotSetField ? $raw_value->getRawValue() : $raw_value;
    }
    
    public function getRawValue()
    {
        return $this->raw_value;
    }
    
    public function __toString()
    {
        return \Logging\LoggersManager::getInstance()->interpolate("NotSetField({0})", array($this->raw_value));
    }
}
