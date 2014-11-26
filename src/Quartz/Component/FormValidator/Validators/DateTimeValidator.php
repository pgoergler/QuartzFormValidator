<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of DateTimeValidator
 *
 * @author paul
 */
class DateTimeValidator extends AbstractFormFieldValidator
{
    protected $minimum = null;
    protected $maximum = null;
    protected $timezone = null;
    
    public function __construct($minimum = null, $maximum = null, $timezone = null)
    {
        parent::__construct();
        
        $this->timezone = $timezone ? : ($timezone instanceof \DateTimeZone ? $timezone : new \DateTimeZone(\date_default_timezone_get()));
        $this->minimum = $minimum ? \datetime($minimum, $timezone) : null;
        $this->maximum = $maximum ? \datetime($maximum, $timezone) : null;
    }
    
    public function sanitizeValue($value)
    {
        if ($value === null )
        {
            return $value;
        }
        if( $value instanceof \DateTime )
        {
            return $value;
        }
        try
        {
            return \datetime($value, $this->timezone);
        } catch (\Exception $ex) {
            return new \Quartz\Component\FormValidator\NotSetField($value);
        }
    }
    
    public function checkValue(\Quartz\Component\FormValidator\FormField $field, $value)
    {
        if ($value instanceof \Quartz\Component\FormValidator\NotSetField)
        {
            return $value;
        }
        
        if( !is_null($this->minimum) && $value < $this->minimum )
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, "'{0}' must be after {1}", array('{0}' => $value->format('Y-m-d H:i:s'), '{1}' => $this->minimum->format('Y-m-d H:i:s')));
        }
        
        if( !is_null($this->maximum) && $value > $this->maximum )
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, "'{0}' must be before {1}", array('{0}' => $value->format('Y-m-d H:i:s'), '{1}' => $this->minimum->format('Y-m-d H:i:s')));
        }
        
        return $value;
    }
}
