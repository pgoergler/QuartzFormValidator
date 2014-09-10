<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\CallbackValidator as Validator,
    Quartz\Component\FormValidator\Exceptions\ErrorException as ErrorException

;

/**
 * Description of CallbackValidator
 *
 * @author paul
 */
class CallbackValidator extends \Quartz\Component\FormValidator\tests\units\Tester
{

    public function testCallbacks()
    {
        $controller = new \atoum\mock\controller();
        $callbackMock = new \mock\Callbacker($controller);
        $field = new \Quartz\Component\FormValidator\FormField('test-field', array());
        
        $callbackMock->getMockController()->sanitizer = function($value) {
            return $value;
        };
        
        $callbackMock->getMockController()->checker = function($field, $value) {
            return $value;
        };
        
        $sanitizer = function($value) use(&$callbackMock) {
            return $callbackMock->sanitizer($value);
        };
        
        $checker = function($field, $value) use(&$callbackMock) {
            return $callbackMock->checker($field, $value);
        };
        
        
        $this->assert('Test Validator' . __FUNCTION__)
                ->if($res = $callbackMock->checker($field, 'foo'))
                ->then
                    ->string($res)->isEqualTo('foo')
                ->if($res = $callbackMock->sanitizer('value'))
                ->then
                    ->string($res)->isEqualTo('value')
                ->if($validator = new Validator($sanitizer, $checker))
                ->and($callbackMock->getMockController()->resetCalls())
                ->and($validator->sanitizeValue('foo'))
                ->then
                    ->mock($callbackMock)->call('sanitizer')
                        ->withArguments('foo')
                        ->once()
                ->if($validator->validate($field, 'value'))
                ->then
                    ->mock($callbackMock)->call('checker')
                        ->withArguments($field, 'value')
                        ->once()
        ;
    }

}
