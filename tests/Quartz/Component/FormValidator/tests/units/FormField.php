<?php

namespace Quartz\Component\FormValidator\tests\units;

use Quartz\Component\FormValidator\Validators\NullAsNotSetValidator

;

/**
 * Description of FormField
 *
 * @author paul
 */
class FormField extends Tester
{

    public function testReset()
    {
        $controller = new \atoum\mock\controller();
        $controller->__construct = function() {
            $this->setStatus('warning', 'warning 1');
            $this->setStatus('warning', 'warning 2');
            $this->setStatus('warning', 'warning 3');
            $this->setStatus('error', 'error 1');
            $this->setStatus('error', 'error 2');
        };

        $this->assert(__FUNCTION__)
                ->if($mock = new \mock\Quartz\Component\FormValidator\FormField('test-field', array(), null, $controller))
                ->then
                ->array($mock->getErrors())->hasSize(2)
                ->array($mock->getWarnings())->hasSize(3)
                ->if($mock->reset())
                ->then
                ->array($mock->getErrors())->isEmpty()
                ->array($mock->getWarnings())->isEmpty()
                ->string($mock->getStatus())->isEqualTo('success')
        ;
    }

    public function testGetter()
    {
        $this->assert(__FUNCTION__)
                ->if($object = new \Quartz\Component\FormValidator\FormField('test-field', array(), 123))
                ->then
                ->string($object->getName())->isEqualTo('test-field')
                ->array($object->getValidators())->isEmpty()
                ->string($object->getStatus())->isEqualTo('success')
                ->boolean($object->hasChanged())->isFalse()
                ->boolean($object->hasSuccess())->isTrue()
                ->boolean($object->hasError())->isFalse()
                ->boolean($object->hasWarning())->isFalse()
                ->boolean($object->hasFeedback())->isFalse()
                ->integer($object->getDefaultValue())->isEqualTo(123)
                ->if($object = new \Quartz\Component\FormValidator\FormField('test-field', array(new NullAsNotSetValidator()), 123))
                ->then
                ->string($object->getName())->isEqualTo('test-field')
                ->array($object->getValidators())->hasSize(1)
                ->string($object->getStatus())->isEqualTo('success')
                ->boolean($object->hasChanged())->isFalse()
                ->boolean($object->hasSuccess())->isTrue()
                ->boolean($object->hasError())->isFalse()
                ->boolean($object->hasWarning())->isFalse()
                ->boolean($object->hasFeedback())->isFalse()
                ->integer($object->getDefaultValue())->isEqualTo(123)
        ;
    }

    public function testInitialize()
    {
        $this->assert(__FUNCTION__)
                ->if($object = new \Quartz\Component\FormValidator\FormField('test-field', array(), null))
                ->then
                ->variable($object->getDefaultValue())->isNull()
                ->variable($object->getValue())->isNull()
                ->boolean($object->isValueSet())->isTrue()
                ->if($object->initialize(123))
                ->then
                ->integer($object->getDefaultValue())->isEqualTo(123)
                ->integer($object->getValue())->isEqualTo(123)
                ->boolean($object->isValueSet())->isTrue()
                ->if($object->setValue('123foobarbaz'))
                ->then
                ->integer($object->getDefaultValue())->isEqualTo(123)
                ->string($object->getValue())->isEqualTo('123foobarbaz')
                ->boolean($object->hasChanged())->isTrue()
                ->boolean($object->isValueSet())->isTrue()
        ;
    }

    public function testStatus()
    {
        $this->assert(__FUNCTION__ . ' error then warning')
                ->if($object = new \Quartz\Component\FormValidator\FormField('test-field', array(), null))
                ->then
                ->variable($object->getDefaultValue())->isNull()
                ->variable($object->getValue())->isNull()
                ->boolean($object->isValueSet())->isTrue()
                ->array($object->getErrors())->isEmpty()
                ->array($object->getWarnings())->isEmpty()
                ->string($object->getStatus())->isEqualTo('success')
                ->boolean($object->hasFeedback())->isFalse()
                ->if($object->setStatus('error', 'error #1'))
                ->then
                    ->array($object->getErrors())->hasSize(1)
                    ->boolean($object->hasSuccess())->isFalse()
                    ->boolean($object->hasError())->isTrue()
                    ->boolean($object->hasWarning())->isFalse()
                    ->boolean($object->hasFeedback())->isTrue()
                    ->string($object->getStatus())->isEqualTo('error')
                ->if($object->setStatus('error', 'error #2'))
                ->then
                    ->array($object->getErrors())->hasSize(2)
                    ->boolean($object->hasSuccess())->isFalse()
                    ->boolean($object->hasError())->isTrue()
                    ->boolean($object->hasWarning())->isFalse()
                    ->boolean($object->hasFeedback())->isTrue()
                    ->string($object->getStatus())->isEqualTo('error')
                ->if($object->setStatus('warning', 'warning #1'))
                ->then
                    ->array($object->getErrors())->hasSize(2)
                    ->array($object->getWarnings())->hasSize(1)
                    ->boolean($object->hasSuccess())->isFalse()
                    ->boolean($object->hasError())->isTrue()
                    ->boolean($object->hasWarning())->isTrue()
                    ->boolean($object->hasFeedback())->isTrue()
                    ->string($object->getStatus())->isEqualTo('error')
                ->if($object->setStatus('success'))
                ->then
                    ->array($object->getErrors())->hasSize(2)
                    ->array($object->getWarnings())->hasSize(1)
                    ->boolean($object->hasSuccess())->isFalse()
                    ->boolean($object->hasError())->isTrue()
                    ->boolean($object->hasWarning())->isTrue()
                    ->boolean($object->hasFeedback())->isTrue()
                    ->string($object->getStatus())->isEqualTo('error')
        ;
        $this->assert(__FUNCTION__ . ' warning then error')
                ->if($object = new \Quartz\Component\FormValidator\FormField('test-field', array(), null))
                ->then
                ->variable($object->getDefaultValue())->isNull()
                ->variable($object->getValue())->isNull()
                ->boolean($object->isValueSet())->isTrue()
                ->array($object->getErrors())->isEmpty()
                ->array($object->getWarnings())->isEmpty()
                ->string($object->getStatus())->isEqualTo('success')
                ->boolean($object->hasFeedback())->isFalse()
                ->if($object->setStatus('warning', 'warning #1'))
                ->then
                    ->array($object->getErrors())->isEmpty()
                    ->array($object->getWarnings())->hasSize(1)
                    ->boolean($object->hasSuccess())->isFalse()
                    ->boolean($object->hasError())->isFalse()
                    ->boolean($object->hasWarning())->isTrue()
                    ->boolean($object->hasFeedback())->isTrue()
                    ->string($object->getStatus())->isEqualTo('warning')
                ->if($object->setStatus('error', 'error #1'))
                ->then
                    ->array($object->getErrors())->hasSize(1)
                    ->array($object->getWarnings())->hasSize(1)
                    ->boolean($object->hasSuccess())->isFalse()
                    ->boolean($object->hasError())->isTrue()
                    ->boolean($object->hasWarning())->isTrue()
                    ->boolean($object->hasFeedback())->isTrue()
                    ->string($object->getStatus())->isEqualTo('error')
                ->if($object->setStatus('error', 'error #2'))
                ->then
                    ->array($object->getErrors())->hasSize(2)
                    ->array($object->getWarnings())->hasSize(1)
                    ->boolean($object->hasSuccess())->isFalse()
                    ->boolean($object->hasError())->isTrue()
                    ->boolean($object->hasWarning())->isTrue()
                    ->boolean($object->hasFeedback())->isTrue()
                    ->string($object->getStatus())->isEqualTo('error')
                ->if($object->setStatus('success'))
                ->then
                    ->array($object->getErrors())->hasSize(2)
                    ->array($object->getWarnings())->hasSize(1)
                    ->boolean($object->hasSuccess())->isFalse()
                    ->boolean($object->hasError())->isTrue()
                    ->boolean($object->hasWarning())->isTrue()
                    ->boolean($object->hasFeedback())->isTrue()
                    ->string($object->getStatus())->isEqualTo('error')
        ;
    }

    public function testValidate()
    {
        $this->mockGenerator()->generate('\Quartz\Component\FormValidator\Validators\AbstractFormFieldValidator', '\Mocked', 'ImplValidator');
        $controller1 = new \atoum\mock\controller();
        $controller1->checkValue = function($fieldname, $value) {
            return $value;
        };
        $noopValidator = new \Mocked\ImplValidator(false, $controller1);
        
        $controller2 = new \atoum\mock\controller();
        $controller2->checkValue = function($fieldname, $value) {
            return new \Quartz\Component\FormValidator\NotSetField($value);
        };
        
        $notSetValidator = new \Mocked\ImplValidator(false, $controller2);
                
        $this->assert(__FUNCTION__)
                ->if($object = new \Quartz\Component\FormValidator\FormField('test-field', array($noopValidator), 123))
                ->and($ret = $object->validate('foo'))
                ->then
                    ->boolean($ret)->isTrue()
                    ->string($object->getValue())->isEqualTo('foo')
                    ->string($object->getStatus())->isEqualTo('success')
                    ->mock($noopValidator)->call('sanitizeValue')
                        ->withArguments('foo')
                        ->once()
                    ->mock($noopValidator)->call('checkValue')
                        ->withArguments('test-field', 'foo')
                        ->once()
                    ->mock($noopValidator)->call('validate')
                        ->withArguments('test-field', 'foo')
                        ->once()
                    
                ->if($object = new \Quartz\Component\FormValidator\FormField('test-field', array($notSetValidator), 123))
                ->and($ret = $object->validate('foo'))
                ->then
                    ->boolean($ret)->isTrue()
                    ->string($object->getValue())->isEqualTo('foo')
                    ->boolean($object->isValueSet())->isFalse()
                    ->string($object->getStatus())->isEqualTo('success')
                    ->mock($notSetValidator)->call('sanitizeValue')
                        ->withArguments('foo')
                        ->once()
                    ->mock($notSetValidator)->call('checkValue')
                        ->withArguments('test-field', 'foo')
                        ->once()
                    ->mock($notSetValidator)->call('validate')
                        ->withArguments('test-field', 'foo')
                        ->once()
                    
        ;
        
        $controller3 = new \atoum\mock\controller();
        $controller3->checkValue = function($fieldname, $value) {
            throw new \Quartz\Component\FormValidator\Exceptions\WarningException($fieldname, $value, 'warning !');
        };
        
        $validator = new \Mocked\ImplValidator(false, $controller3);
        $this->assert(__FUNCTION__)
            ->if($object = new \Quartz\Component\FormValidator\FormField('test-field', array($validator), 123))
            ->and($ret = $object->validate('foo'))
            ->then
                ->boolean($ret)->isTrue()
                ->boolean($object->hasFeedback())->isTrue()
                ->boolean($object->hasSuccess())->isFalse()
                ->string($object->getValue())->isEqualTo('foo')
                ->string($object->getStatus())->isEqualTo('warning')
                ->array($object->getWarnings())->hasSize(1)
                ->array($object->getWarnings())->contains('warning !')
                ->mock($validator)->call('sanitizeValue')
                    ->withArguments('foo')
                    ->once()
                ->mock($validator)->call('checkValue')
                    ->withArguments('test-field', 'foo')
                    ->once()
                ->mock($validator)->call('validate')
                    ->withArguments('test-field', 'foo')
                    ->once()
        ;
        
        $controller4 = new \atoum\mock\controller();
        $controller4->checkValue = function($fieldname, $value) {
            throw new \Quartz\Component\FormValidator\Exceptions\ErrorException($fieldname, $value, 'error !');
        };
        
        $validator = new \Mocked\ImplValidator(false, $controller4);
        $this->assert(__FUNCTION__)
            ->if($object = new \Quartz\Component\FormValidator\FormField('test-field', array($validator), 123))
            ->and($ret = $object->validate('foo'))
            ->then
                ->boolean($ret)->isFalse()
                ->boolean($object->hasFeedback())->isTrue()
                ->boolean($object->hasSuccess())->isFalse()
                ->string($object->getValue())->isEqualTo('foo')
                ->string($object->getStatus())->isEqualTo('error')
                ->array($object->getErrors())->hasSize(1)
                ->array($object->getErrors())->contains('error !')
                ->mock($validator)->call('sanitizeValue')
                    ->withArguments('foo')
                    ->twice()
                ->mock($validator)->call('checkValue')
                    ->withArguments('test-field', 'foo')
                    ->once()
                ->mock($validator)->call('validate')
                    ->withArguments('test-field', 'foo')
                    ->once()
        ;
    }

}
