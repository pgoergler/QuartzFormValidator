<?php

namespace Quartz\Component\FormValidator;

/**
 * Description of CallbackFormValidator
 *
 * @author paul
 */
class CallbackFormValidator extends FormValidator
{
    
    protected $beforeValidateCallback = null;
    protected $afterValidateCallback = null;
    protected $beforeBindCallback = null;
    protected $afterBindCallback = null;
    
    public function __construct(\Quartz\Object\Table &$table = null)
    {
        parent::__construct($table);
    }
    
    public function getBeforeValidateCallback()
    {
        return $this->beforeValidateCallback;
    }

    public function getAfterValidateCallback()
    {
        return $this->afterValidateCallback;
    }

    public function getBeforeBindCallback()
    {
        return $this->beforeBindCallback;
    }

    public function getAfterBindCallback()
    {
        return $this->afterBindCallback;
    }

    public function setBeforeValidateCallback($beforeValidateCallback)
    {
        if(! ($beforeValidateCallback instanceof \Closure ))
        {
            throw new \InvalidArgumentException("must be a valid closure");
        }
        $this->beforeValidateCallback = $beforeValidateCallback;
    }

    public function setAfterValidateCallback($afterValidateCallback)
    {
        if(! ($afterValidateCallback instanceof \Closure ))
        {
            throw new \InvalidArgumentException("must be a valid closure");
        }
        $this->afterValidateCallback = $afterValidateCallback;
    }

    public function setBeforeBindCallback($beforeBindCallback)
    {
        if(! ($beforeBindCallback instanceof \Closure ))
        {
            throw new \InvalidArgumentException("must be a valid closure");
        }
        $this->beforeBindCallback = $beforeBindCallback;
    }

    public function setAfterBindCallback($afterBindCallback)
    {
        if(! ($afterBindCallback instanceof \Closure ))
        {
            throw new \InvalidArgumentException("must be a valid closure");
        }
        $this->afterBindCallback = $afterBindCallback;
    }

    protected function execute($callback, $form)
    {
        if( $callback && $callback instanceof \Closure )
        {
            $args = func_get_args();
            array_shift($args);
            $fn = $callback->bindTo($this);
            return call_user_func_array($fn, $args);
        }
        return $form;
    }
    
    public function validate(array $form)
    {
        $form = $this->execute($this->getBeforeValidateCallback(), $form);
        parent::validate($form);
        $this->execute($this->getAfterValidateCallback(), $form);
        return $this;
    }
    
    public function bindTo(\Quartz\Object\Entity &$object)
    {
        $this->execute($this->getBeforeBindCallback(), $object);
        parent::bindTo($object);
        $this->execute($this->getAfterBindCallback(), $object);
        
        return $this;
    }
    
}
