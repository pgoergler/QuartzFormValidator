<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\EmptyAsNotSetValidator as EmptyAsNotSet

;

/**
 * Description of EmptyAsNotSetValidator
 *
 * @author paul
 */
class EmptyAsNotSetValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new EmptyAsNotSet();
    }

    public function sanatizedDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new EmptyAsNotSet(), '', '', false, null),
            array(new EmptyAsNotSet(), null, null, false, null),
            array(new EmptyAsNotSet(), array(), array(), false, null),
            array(new EmptyAsNotSet(), '     ', '     ', true, null),
            array(new EmptyAsNotSet(), '0', '0', true, null),
            array(new EmptyAsNotSet(), 'null', 'null', true, null),
            array(new EmptyAsNotSet(), 'false', 'false', true, null),
            array(new EmptyAsNotSet(), 'true', 'true', true, null),
            array(new EmptyAsNotSet(), 'foo', 'foo', true, null),
            array(new EmptyAsNotSet(), array(1), array(1), true, null),
        );

        return $data;
    }
}
