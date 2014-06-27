<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

/**
 * Description of ValidatorTester
 *
 * @author paul
 */
abstract class ValidatorTester extends \Quartz\Component\FormValidator\tests\units\Tester
{

    public abstract function createValidator();

    public function getValidator($isMandatory = false)
    {
        $validator = $this->createValidator();
        $validator->setMandatory($isMandatory);
        return $validator;
    }

    public abstract function sanatizedDataProvider();

    public function checkDataProvider()
    {
        return $this->sanatizedDataProvider();
    }

    public function validateDataProvider()
    {
        return $this->checkDataProvider();
    }

    /**
     * @dataProvider sanatizedDataProvider
     * @param type $value
     * @param type $expectedValue
     * @param type $isset
     */
    public function testSanatized($validator, $value, $expectedValue, $isset, $exception)
    {
        $functionName = $this->app['logger.interpolate'](__FUNCTION__ . '($v={0}, $exp={1}, $set={2})', array($value, $expectedValue, $isset));

        $this->assert('Test sanatize');
        
        if ($exception)
        {
            $this->assert('Test Validator ' . $functionName . ' has exception')
                    ->exception(function() use($validator, $value) {
                        $validator->sanitizeValue($value);
                    })
                    ->isInstanceOf(get_class($exception))
                    ->hasMessage($exception->getMessage())
            ;
        } else
        {
            $this->if($sanatized = $validator->sanitizeValue($value));
            if (!$isset)
            {
                $this->assert('Test Validator ' . $functionName . ' must be not set')
                        ->object($sanatized)->isInstanceOf('\Quartz\Component\FormValidator\NotSetField');
            } elseif (is_null($expectedValue))
            {
                $this->assert('Test Validator ' . $functionName . ' must be null')
                        ->variable($sanatized)->isNull();
            } else
            {
                $this->assert('Test Validator ' . $functionName . ' must be equalTo({0})', array($expectedValue));
                if(is_integer($expectedValue) )
                {
                    $this->integer($sanatized)->isEqualTo($expectedValue);
                }
                elseif( is_double($expectedValue) || is_float($expectedValue))
                {
                    $this->float($sanatized)->isEqualTo($expectedValue);
                }
                elseif( is_string($expectedValue) )
                {
                    $this->string($sanatized)->isEqualTo($expectedValue);
                }
                elseif( is_array($expectedValue) )
                {
                    $this->array($sanatized)->isEqualTo($expectedValue);
                }
                else
                {
                    $this->variable($sanatized)->isEqualTo($expectedValue);
                }
            }
        }
    }

    /**
     * @dataProvider checkDataProvider
     * @param type $value
     * @param type $expectedValue
     * @param type $isset
     */
    public function testCheckValue($validator, $value, $expectedValue, $isset, $exception)
    {
        $functionName = $this->app['logger.interpolate'](__FUNCTION__ . '($v={0}, $exp={1}, $set={2})', array($value, $expectedValue, $isset));

        $this->assert('Test checkValue');

        if ($exception)
        {
            $this->assert('Test Validator ' . $functionName . ' has exception')
                    ->exception(function() use($validator, $value) {
                        $sanatized = $validator->sanitizeValue($value);
                        $validator->checkValue('test-field', $sanatized);
                    })
                    ->isInstanceOf(get_class($exception))
                    ->hasMessage($exception->getMessage())
            ;
        } else
        {
            $this->if($sanatized = $validator->sanitizeValue($value))
                    and($checked = $validator->checkValue('fieldname', $sanatized));
            
            if (!$isset)
            {
                $this->assert('Test Validator ' . $functionName . ' must be not set')
                        ->object($checked)->isInstanceOf('\Quartz\Component\FormValidator\NotSetField')
                        ->then
                        ->if($checked = $checked->getRawValue())
                ;
            }

            if (is_null($expectedValue))
            {
                $this->assert('Test Validator ' . $functionName . ' must be null')
                        ->variable($checked)->isNull();
            } else
            {
                $this->assert('Test Validator ' . $functionName . ' must be equalTo({0})', array($expectedValue));
                if(is_integer($expectedValue) )
                {
                    $this->integer($checked)->isEqualTo($expectedValue);
                }
                elseif( is_double($expectedValue) || is_float($expectedValue))
                {
                    $this->float($checked)->isEqualTo($expectedValue);
                }
                elseif( is_string($expectedValue) )
                {
                    $this->string($checked)->isEqualTo($expectedValue);
                }
                elseif( is_array($expectedValue) )
                {
                    $this->array($checked)->isEqualTo($expectedValue);
                }
                else
                {
                    $this->variable($checked)->isEqualTo($expectedValue);
                }
            }
        }
    }

    /**
     * @dataProvider validateDataProvider
     * @param type $value
     * @param type $expectedValue
     * @param type $isset
     */
    public function testValidate($validator, $value, $expectedValue, $isset, $exception)
    {
        $fieldname = 'test-field-name';

        $functionName = $this->app['logger.interpolate'](__FUNCTION__ . '($v={1}, $exp={2}, $i={3})', array($fieldname, $value, $expectedValue, $isset));
        if ($exception instanceof \Exception)
        {
            $this->assert('Test Validator ' . $functionName . ' has exception')
                    ->exception(function() use($validator, $value) {
                        $validator->validate('test-field', $value);
                    })
                    ->isInstanceOf(get_class($exception))
                    ->hasMessage($exception->getMessage())
            ;
        } else
        {
            $validated = $validator->validate($fieldname, $value);
            if (!$isset)
            {
                $this->assert('Test Validator ' . $functionName . ' must be not set')
                        ->object($validated)->isInstanceOf('\Quartz\Component\FormValidator\NotSetField')
                        ->variable($validated->getRawValue())->isEqualTo($expectedValue)
                ;
            } elseif (is_null($expectedValue))
            {
                $this->assert('Test Validator ' . $functionName . ' must be null')
                        ->variable($validated)->isNull();
            } else
            {
                $this->assert('Test Validator ' . $functionName . ' must be equalTo({0})', array($expectedValue));
                if(is_integer($expectedValue) )
                {
                    $this->integer($validated)->isEqualTo($expectedValue);
                }
                elseif( is_double($expectedValue) || is_float($expectedValue))
                {
                    $this->float($validated)->isEqualTo($expectedValue);
                }
                elseif( is_string($expectedValue) )
                {
                    $this->string($validated)->isEqualTo($expectedValue);
                }
                elseif( is_array($expectedValue) )
                {
                    $this->array($validated)->isEqualTo($expectedValue);
                }
                else
                {
                    $this->variable($validated)->isEqualTo($expectedValue);
                }
            }
        }

        if (!$isset)
        {
            if ($exception instanceof \InvalidArgumentException)
            {
                $this->assert('Test Validator ' . $functionName . ' mandatory \InvalidArgumentException')
                        ->exception(function() use($validator, $value) {
                            $validator->validate('test-field', $value);
                        })
                        ->isInstanceOf(get_class($exception))
                        ->hasMessage($exception->getMessage())
                ;
            }
            else
            {
                if( ! $exception )
                {
                    $exception = new \Quartz\Component\FormValidator\Exceptions\ErrorException('test-field', '', 'you must set a value');
                }
                $this->assert('Test Validator ' . $functionName . ' mandatory')
                        ->if($validator->setMandatory(true))
                        ->exception(function() use($validator, $fieldname, $value) {
                            $validator->validate($fieldname, $value);
                        })
                        ->isInstanceOf(get_class($exception))
                        ->hasMessage($exception->getMessage())
                ;
            }
        }
    }

    public function testMandatory()
    {
        $this->assert('Test isMandatory')
                ->if($v1 = $this->createValidator())
                ->and($v2 = $this->getValidator(false))
                ->and($v3 = $this->getValidator(true))
                ->and($v4 = $this->getValidator(1))
                ->and($v5 = $this->getValidator(null))
                ->then
                ->boolean($v1->isMandatory())->isFalse()
                ->boolean($v2->isMandatory())->isFalse()
                ->boolean($v3->isMandatory())->isTrue()
                ->boolean($v4->isMandatory())->isTrue()
                ->boolean($v5->isMandatory())->isFalse()
                ->assert('Test setMandatory')
                ->if($v1 = $this->createValidator())
                ->then
                ->boolean($v1->isMandatory())->isFalse()
                ->if($v1 = $this->createValidator())
                ->and($v1->setMandatory(true))
                ->then
                ->boolean($v1->isMandatory())->isTrue()
                ->if($v1 = $this->createValidator())
                ->and($v1->setMandatory(0))
                ->then
                ->boolean($v1->isMandatory())->isFalse()
                ->if($v1 = $this->createValidator())
                ->and($v1->setMandatory(1))
                ->then
                ->boolean($v1->isMandatory())->isTrue()
                ->if($v1 = $this->createValidator())
                ->and($v1->setMandatory(false))
                ->then
                ->boolean($v1->isMandatory())->isFalse()
                ->if($v1 = $this->createValidator())
                ->and($v1->setMandatory(null))
                ->then
                ->boolean($v1->isMandatory())->isFalse()
        ;
    }

}
