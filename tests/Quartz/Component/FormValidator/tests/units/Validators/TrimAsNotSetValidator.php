<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\TrimAsNotSetValidator as TrimAsNotSet

;

/**
 * Description of TrimAsNotSetValidator
 *
 * @author paul
 */
class TrimAsNotSetValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new TrimAsNotSet();
    }

    public function sanatizedDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new TrimAsNotSet(), '', '', false, null),
            array(new TrimAsNotSet(), '     ', '', false, null),
            array(new TrimAsNotSet(), null, null, true, null),
            array(new TrimAsNotSet(), array(), array(), true, null),
            array(new TrimAsNotSet(), '0', '0', true, null),
            array(new TrimAsNotSet(), 'null', 'null', true, null),
            array(new TrimAsNotSet(), 'false', 'false', true, null),
            array(new TrimAsNotSet(), 'true', 'true', true, null),
            array(new TrimAsNotSet(), 'foo', 'foo', true, null),
            array(new TrimAsNotSet(), array(1), array(1), true, null),
        );

        return $data;
    }

}
