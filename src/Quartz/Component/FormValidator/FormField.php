<?php

namespace Quartz\Component\FormValidator;

/**
 * Description of FormField
 *
 * @author paul
 */
class FormField
{

    protected $name;
    protected $status = 'success';
    protected $defaultValue = null;
    protected $value = null;
    protected $errors = array();
    protected $warnings = array();
    protected $validators = array();

    /**
     *
     * @var \Psr\Log\LoggerInterface 
     */
    protected $logger;

    public function __construct($name, array $validators, $defaultValue = null)
    {
        $this->name = $name;
        $this->validators = $validators;
        $this->defaultValue = func_num_args() < 3 ? new NotSetField() : $defaultValue;
        $this->value = $this->defaultValue;
    }

    public function reset()
    {
        $this->setValue($this->defaultValue);
        $this->errors = array();
        $this->warnings = array();
        $this->status = 'success';
    }
    
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @param type $validators
     * @return \Quartz\Component\FormValidator\FormField
     */
    public function setValidators(array $validators)
    {
        $this->validators = $validators;
        return $this;
    }
    
    public function getValidators()
    {
        return $this->validators;
    }
    
    /**
     * 
     * @param \Quartz\Component\FormValidator\Validators\AbstractFormFieldValidator $validator
     * @return \Quartz\Component\FormValidator\FormField
     */
    public function pushValidator(Validators\AbstractFormFieldValidator $validator)
    {
        array_push($this->validators, $validator);
        return $this;
    }

    public function hasSuccess()
    {
        return $this->status === 'success';
    }

    public function hasError()
    {
        return !empty($this->errors);
    }

    public function hasWarning()
    {
        return !empty($this->warnings);
    }

    public function hasFeedback()
    {
        return $this->hasError() || $this->hasWarning();
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status, $message = null, $context = array())
    {
        $ctx = array();
        foreach( $context as $k => $v) {
            if( is_numeric($k) ) {
                $k = "{" . $k ."}";
            }
            $ctx[$k] = $v;
        }
        
        if ($status === 'error')
        {
            $this->status = $status;
            //$this->errors[] = \trim($message) ? : false;
            $this->errors[] = array($message, $ctx);
        } elseif ($status === 'warning')
        {
            if ($this->getStatus() === 'success')
            {
                $this->status = $status;
            }
            //$this->warnings[] = \trim($message) ? : false;
            $this->warnings[] = array($message, $ctx);
        }
        return $this;
    }
    
    public function initialize($value)
    {
        $this->defaultValue = $value;
        $this->value = $this->defaultValue;
    }
    
    public function hasChanged()
    {
        if( $this->value instanceof NotSetField )
        {
            return false;
        }
        $j1 = json_encode($this->getDefaultValue());
        $j2 = json_encode($this->getValue());
        return $j1 != $j2;
    }

    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
    
    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function isValueSet()
    {
        return !$this->hasError() && !($this->value instanceof NotSetField );
    }

    public function getErrors()
    {
        return $this->hasError() ? array_filter($this->errors, function($value) {
                    return $value;
                }) : array();
    }

    public function getWarnings()
    {
        return $this->hasWarning() ? array_filter($this->warnings, function($value) {
                    return $value;
                }) : array();
    }

    public function validateWith($value, Validators\AbstractFormFieldValidator $validator)
    {
        try
        {
            $value = $validator->validate($this, $value);
            $this->setValue($value);
            $this->setStatus('success');
        } catch (Exceptions\WarningException $ex)
        {
            $this->setValue($value);
            $this->setStatus('warning', $ex->getMessage());
            if ($ex->shouldStopValidation())
            {
                throw new Exceptions\StopFieldValidationException();
            }
        } catch (Exceptions\ErrorException $ex)
        {
            $hasError = true;
            $this->setValue(new NotSetField($value));
            $this->setStatus('error', $ex->getMessage(), $ex->getContext());
            if ($ex->shouldStopValidation())
            {
                throw new Exceptions\StopFieldValidationException();
            }
        } catch( \InvalidArgumentException $e)
        {
            $hasError = true;
            $this->setValue(new NotSetField($value));
            $this->setStatus('error', $e->getMessage());
            throw new Exceptions\StopFieldValidationException();
        }
        return $value;
    }
    
    public function validate($value)
    {
        $this->reset();
        
        $this->setValue($value);
        $hasError = false;
        try
        {
            foreach ($this->validators as $validator)
            {
                $value = $this->validateWith($value, $validator);
            }
        } catch (Exceptions\StopFieldValidationException $ex)
        {
            
        }

        return !$hasError;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
