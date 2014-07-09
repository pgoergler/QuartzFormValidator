<?php

namespace Quartz\Component\FormValidator\tests\units;

use Quartz\Component\FormValidator\Validators\StringValidator,
    Quartz\Component\FormValidator\Validators\LengthValidator,
    Quartz\Component\FormValidator\Validators\TextValidator,
    Quartz\Component\FormValidator\Validators\EnumValidator,
    Quartz\Component\FormValidator\Validators\IncludedInValidator,
    Quartz\Component\FormValidator\Validators\RegexValidator,
    Quartz\Component\FormValidator\Validators\NumberValidator,
    Quartz\Component\FormValidator\Validators\DecimalValidator,
    Quartz\Component\FormValidator\Validators\EmailValidator,
    Quartz\Component\FormValidator\Validators\TrimAsNotSetValidator,
    Quartz\Component\FormValidator\Validators\NullAsNotSetValidator,
    Quartz\Component\FormValidator\Validators\EmptyAsNotSetValidator

;

/**
 * Description of FormValidator
 *
 * @author paul
 */
class FormValidator extends Tester
{

    public function testChainValidator()
    {
        $form = array(
            'field1' => null,
            'field2' => 'null'
        );

        $this->assert('Test FormValidator ' . __FUNCTION__)
                ->if($formValidator = new \Quartz\Component\FormValidator\FormValidator())
                ->and($v1 = new EmptyAsNotSetValidator())
                ->and($v2 = new NumberValidator(100))
                ->and($formValidator->addField('field1', [$v1, $v2]), null)
                ->and($formValidator->addField('field2', [$v1, $v2]), null)
                ->and($formValidator->validate($form))
                ->and($field = $formValidator->getField('field1') )
                ->then
                    ->variable($formValidator->getValue('field1'))->isNull()
                    ->string($formValidator->getValue('field2'))->isEqualTo('null')
                    ->boolean($formValidator->isFieldValueSet('field2'))->isFalse()
                    ->boolean($formValidator->hasError('field2'))->isFalse()
                    
        ;
    }
    
    public function testMissingField()
    {
        $form = array(
            'field1' => null,
            'field2' => 'null'
        );

        $this->assert('Test FormValidator ' . __FUNCTION__)
                ->if($formValidator = new \Quartz\Component\FormValidator\FormValidator())
                ->and($v1 = new EmptyAsNotSetValidator())
                ->and($v2 = new NumberValidator(100))
                ->and($formValidator->addField('field1', [$v1, $v2]), null)
                ->and($formValidator->addField('field2', [$v1, $v2]), null)
                ->and($formValidator->addField('field3', [$v2]), null)
                ->and($formValidator->validate($form))
                ->and($field = $formValidator->getField('field1') )
                ->then
                    ->variable($formValidator->getValue('field1'))->isNull()
                    ->string($formValidator->getValue('field2'))->isEqualTo('null')
                    ->variable($formValidator->getValue('field3'))->isNull()
                    //-
                    ->boolean($formValidator->isFieldValueSet('field2'))->isFalse()
                    ->boolean($formValidator->hasError('field2'))->isFalse()
                    ->boolean($formValidator->isFieldValueSet('field3'))->isFalse()
                    ->boolean($formValidator->hasError('field3'))->isFalse()
        ;
        
        $this->assert('Test FormValidator ' . __FUNCTION__)
                ->if($formValidator = new \Quartz\Component\FormValidator\FormValidator())
                ->and($v11 = new EmptyAsNotSetValidator())
                ->and($v12 = new NumberValidator(100))
                ->and($formValidator->addField('field1', [$v11, $v12]), null)
                ->and($formValidator->addField('field2', [$v11, $v12]), null)
                //-
                ->and($formValidator->addMandatoryField('field3', [$v12]), null)
                //-
                ->and($formValidator->validate($form))
                ->and($field = $formValidator->getField('field1') )
                ->then
                    ->boolean($formValidator->hasError())->isTrue()
                    ->variable($formValidator->getValue('field1'))->isNull()
                    ->string($formValidator->getValue('field2'))->isEqualTo('null')
                    ->variable($formValidator->getValue('field3'))->isNull()
                    ->boolean($formValidator->hasError('field1'))->isFalse()
                    ->boolean($formValidator->hasError('field2'))->isFalse()
                    ->boolean($formValidator->hasError('field3'))->isTrue()
                    ->boolean($formValidator->isFieldValueSet('field1'))->isFalse()
                    ->boolean($formValidator->isFieldValueSet('field2'))->isFalse()
                    ->boolean($formValidator->isFieldValueSet('field3'))->isFalse()
        ;
    }

}
