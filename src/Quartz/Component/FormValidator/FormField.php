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
        $this->errors = array();
        $this->warnings = array();
        $this->status = 'success';
    }
    
    public function getName()
    {
        return $this->name;
    }

    public function getValidators()
    {
        return $this->validators;
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

    public function setStatus($status, $message = null)
    {
        if ($status === 'error')
        {
            $this->status = $status;
            $this->errors[] = \trim($message) ? : false;
        } elseif ($status === 'warning')
        {
            if ($this->getStatus() === 'success')
            {
                $this->status = $status;
            }
            $this->warnings[] = \trim($message) ? : false;
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
        return $this->defaultValue instanceof NotSetField ? $this->defaultValue->getRawValue() : $this->defaultValue;
    }
    
    public function getValue()
    {
        return $this->value instanceof NotSetField ? $this->value->getRawValue() : $this->value;
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

    public function validate($value)
    {
        $this->reset();
        
        $this->setValue($value);
        $hasError = false;
        try
        {
            foreach ($this->validators as $validator)
            {
                try
                {
                    $value = $validator->validate($this->getName(), $value);
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
                    $this->setStatus('error', $ex->getMessage());
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
            }
        } catch (Exceptions\StopFieldValidationException $ex)
        {
            
        }

        return !$hasError;
    }

}
