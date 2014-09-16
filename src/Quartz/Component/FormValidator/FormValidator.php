<?php

namespace Quartz\Component\FormValidator;

/**
 * Description of FormValidator
 *
 * @author paul
 */
class FormValidator
{

    protected $fields;

    /**
     *
     * @var \Quartz\Object\Table $table
     */
    protected $table;

    /**
     *
     * @var \Quartz\Object\Entity &$object 
     */
    protected $object;
    protected $hasFeedback = false;
    protected $hasError = false;
    protected $hasWarning = false;
    protected $changes = null;

    public function __construct(\Quartz\Object\Table &$table = null)
    {
        $this->table = $table;
    }

    /**
     * 
     * @return \Quartz\Object\Entity $object
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * 
     * @param string $fieldName
     * @param FormFieldValidator|array(FormFieldValidator) $validator
     * @param mixed $defaultValue
     * @return \Quartz\Component\FormValidator\FormValidator
     */
    public function addField($fieldName, $validator, $defaultValue = null, $isMandatory = false)
    {
        if (!$validator)
        {
            return $this;
        }

        if (func_num_args() < 3)
        {
            if (!is_null($this->table))
            {
                $fieldTableConfiguration = $this->table->getColumn($fieldName);
                if ($fieldTableConfiguration)
                {
                    $defaultValue = $fieldTableConfiguration['value'];
                }
            }
        }

        if ($validator instanceof Validators\AbstractFormFieldValidator)
        {
            $validator = array($validator);
        }

        if ($isMandatory)
        {
            array_push($validator, new Validators\MandatoryValidator());
        }


        $field = new FormField($fieldName, $validator, $defaultValue);
        $this->fields[$fieldName] = $field;
        return $this;
    }

    /**
     * 
     * @param string $fieldName
     * @param FormFieldValidator|array(FormFieldValidator) $validator
     * @param mixed $defaultValue
     * @return \Quartz\Component\FormValidator\FormValidator
     */
    public function addMandatoryField($fieldName, $validator, $defaultValue = null)
    {
        if (func_num_args() < 3)
        {
            if (!is_null($this->table))
            {
                $fieldTableConfiguration = $this->table->getColumn($fieldName);
                if ($fieldTableConfiguration)
                {
                    $defaultValue = $fieldTableConfiguration['value'];
                }
            }
        }

        return $this->addField($fieldName, $validator, $defaultValue, true);
    }

    /**
     * 
     * @param string $fieldName
     * @return \Quartz\Component\FormValidator\FormField
     */
    public function getField($fieldName)
    {
        if (!array_key_exists($fieldName, $this->fields))
        {
            return null;
        }
        return $this->fields[$fieldName];
    }

    public function setFieldStatus($fieldName, $status, $message = null)
    {
        $field = $this->getField($fieldName);
        if ($field)
        {
            $field->setStatus($status, $message);
            if ($field->hasError())
            {
                $this->hasError = true;
            }
            if ($field->hasWarning())
            {
                $this->hasWarning = true;
            }
            if ($field->hasFeedback())
            {
                $this->hasFeedback = true;
            }
        }

        return $this;
    }

    /**
     * 
     * @param string $fieldName
     * @return boolean
     */
    public function hasSuccess($fieldName = null)
    {
        if (is_null($fieldName))
        {
            return !$this->hasError();
        }

        if (!array_key_exists($fieldName, $this->fields))
        {
            return false;
        }
        return $this->fields[$fieldName]->hasSuccess();
    }

    /**
     * 
     * @param string $fieldName
     * @return boolean
     */
    public function hasError($fieldName = null)
    {
        if (is_null($fieldName))
        {
            return $this->hasError;
        }

        if (!array_key_exists($fieldName, $this->fields))
        {
            return false;
        }

        return $this->fields[$fieldName]->hasError();
    }

    /**
     * 
     * @param string $fieldName
     * @return boolean
     */
    public function hasFeedback($fieldName = null)
    {
        if (is_null($fieldName))
        {
            return $this->hasFeedback;
        }

        if (!array_key_exists($fieldName, $this->fields))
        {
            return false;
        }

        return $this->fields[$fieldName]->hasFeedback();
    }

    /**
     * 
     * @param string $fieldName
     * @return boolean
     */
    public function hasWarning($fieldName = null)
    {
        if (is_null($fieldName))
        {
            return $this->hasWarning;
        }

        if (!array_key_exists($fieldName, $this->fields))
        {
            return false;
        }

        return $this->fields[$fieldName]->hasWarning();
    }

    /**
     * 
     * @param string $fieldName
     * @return boolean
     */
    public function isFieldValueSet($fieldName)
    {
        if (!array_key_exists($fieldName, $this->fields))
        {
            return false;
        }

        return $this->fields[$fieldName]->isValueSet();
    }

    /**
     * 
     * @param string $fieldName
     * @return mixed
     */
    public function getValue($fieldName)
    {
        if (!array_key_exists($fieldName, $this->fields))
        {
            return null;
        }

        $value = $this->fields[$fieldName]->getValue();
        return $value instanceof NotSetField ? $value->getRawValue() : $value;
    }

    /**
     * 
     * @param string $fieldName
     * @return array
     */
    public function getErrors($fieldName = null)
    {
        if (is_null($fieldName))
        {
            $errors = array();
            foreach ($this->fields as $field)
            {
                $errors = array_merge($errors, $field->getErrors());
            }

            return $errors;
        }

        if (!array_key_exists($fieldName, $this->fields))
        {
            return null;
        }

        if ($this->hasError($fieldName))
        {
            return $this->fields[$fieldName]->getErrors();
        }
        return array();
    }

    /**
     * 
     * @param string $fieldName
     * @return array
     */
    public function getWarnings($fieldName = null)
    {
        if (is_null($fieldName))
        {
            $warnings = array();
            foreach ($this->fields as $field)
            {
                $warnings = array_merge($warnings, $field->getWarnings());
            }
            return $warnings;
        }

        if (!array_key_exists($fieldName, $this->fields))
        {
            return null;
        }

        if ($this->hasWarning($fieldName))
        {
            return $this->fields[$fieldName]->getWarnings();
        }
        return array();
    }

    /**
     * 
     * @param string $fieldName
     * @return array
     */
    public function getAssociativeErrors()
    {
        $errors = array();
        foreach ($this->fields as $field)
        {
            if ($field->hasError())
            {
                $errors[$field->getName()] = $field->getErrors();
            }
        }
        return $errors;
    }

    /**
     * 
     * @param string $fieldName
     * @return array
     */
    public function getAssociativeWarnings()
    {
        $warnings = array();
        foreach ($this->fields as $field)
        {
            if ($field->hasWarning())
            {
                $warnings[$field->getName()] = $field->getWarnings();
            }
        }
        return $warnings;
    }

    /**
     * 
     * @param array $form
     * @return \Quartz\Component\FormValidator\FormValidator
     */
    public function validate(array $form)
    {
        $this->hasFeedback = false;
        $this->hasError = false;
        $this->hasWarning = false;
        $this->changes = null;

        foreach ($this->fields as $fieldName => $field)
        {
            $value = array_key_exists($fieldName, $form) ? $form[$fieldName] : $field->getDefaultValue();
            $this->validateField($fieldName, $value);
        }
        return $this;
    }

    public function validateField($fieldName, $value, \Quartz\Component\FormValidator\Validators\AbstractFormFieldValidator $validator = null)
    {
        $field = $this->getField($fieldName);
        if (!$field)
        {
            throw new \Exception('field [' . $fieldName . ']not found');
        }

        try
        {
            if (is_null($validator))
            {
                $field->validate($value);
            } else
            {
                $field->validateWith($value, $validator);
            }
        } catch (Exceptions\StopFieldValidationException $ex)
        {
            
        }
        if ($field->hasError())
        {
            $this->hasError = true;
        }
        if ($field->hasWarning())
        {
            $this->hasWarning = true;
        }
        if ($field->hasFeedback())
        {
            $this->hasFeedback = true;
        }
    }

    /**
     * 
     * @param \Quartz\Object\Entity $entity
     * @return \Quartz\Component\FormValidator\FormValidator
     */
    public function initializeWithEntity(\Quartz\Object\Entity $entity)
    {
        foreach ($this->fields as $fieldName => $field)
        {
            if ($entity->has($fieldName))
            {
                $getter = $entity->getGetter($fieldName);
                $value = $entity->$getter();
                $field->setValue($value);
            }
        }
        return $this;
    }

    /**
     * 
     * @param \Quartz\Object\Entity $object
     * @return \Quartz\Component\FormValidator\FormValidator
     */
    public function bindTo(\Quartz\Object\Entity &$object)
    {
        $this->changes = null;
        foreach ($this->fields as $fieldName => $field)
        {
            if (!$field->hasError() && $field->isValueSet())
            {
                try
                {
                    $getter = $object->getGetter($fieldName);
                    $setter = $object->getSetter($fieldName);
                    
                    if((method_exists($object, $getter) && method_exists($object, $setter)) || $object->has($fieldName))
                    {
                        $object->$setter($field->getValue());
                        $field->setValue($object->$getter());
                    }
                } catch (\Exception $e)
                {
                    $this->setFieldStatus($fieldName, 'error', $e->getMessage());
                }
            }
        }
        $this->object = $object;
        return $this;
    }

    public function getUpdatedValues()
    {
        if (!is_null($this->changes))
        {
            return $this->changes;
        }

        foreach ($this->fields as $fieldName => $field)
        {
            if ($field->hasChanged())
            {
                $this->changes[$fieldName] = array($field->getDefaultValue(), $field->getValue());
            }
        }
        return $this->changes;
    }

    public function hasChanged()
    {
        $this->getUpdatedValues();
        return !is_null($this->changes) && !empty($this->changes);
    }

}
