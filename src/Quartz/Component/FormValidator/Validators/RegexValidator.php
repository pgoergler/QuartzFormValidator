<?php

namespace Quartz\Component\FormValidator\Validators;

/**
 * Description of RegexValidator
 *
 * @author paul
 */
class RegexValidator extends AbstractFormFieldValidator
{

    protected $regex = null;
    protected $tags = null;

    public function __construct($regex, $tags = '')
    {
        parent::__construct();
        $this->regex = $regex;
        $this->tags = $tags;
    }

    public function sanitizeValue($value)
    {
        if ($value === null)
        {
            return $value;
        }
        if( is_string($value) )
        {
            return $value;
        }
        throw new \InvalidArgumentException("you must set a valid value");
    }

    public function getRegex()
    {
        return '#' . str_replace('#', '\\#', $this->regex) . '#' . $this->tags;
    }

    public function checkValue($field, $value)
    {
        if ($value instanceof \Quartz\Component\FormValidator\NotSetField)
        {
            return $value;
        }
        
        $regex = $this->getRegex();
        if (!preg_match($regex, "$value", $m))
        {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($field, $value, "'{0}' does not match {1}", array('{0}' => $value, '{1}' => $this->regex));
        }
        return is_null($value) ? $value : $m[0];
    }

}
