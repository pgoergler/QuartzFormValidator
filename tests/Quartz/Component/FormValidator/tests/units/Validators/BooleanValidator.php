<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\BooleanValidator as Validator,
    Quartz\Component\FormValidator\Exceptions\ErrorException as ErrorException

;

/**
 * Description of BooleanValidator
 *
 * @author paul
 */
class BooleanValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new Validator();
    }

    public function sanatizedDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator(), null      , null     , true  , null),
            array(new Validator(), false     , false    , true , null),
            array(new Validator(), true      , true     , true , null),
            array(new Validator(), 1         , true     , true  , null),
            array(new Validator(), 123       , true     , true  , null),
            array(new Validator(), '123'     , true     , true  , null),
            array(new Validator(), -10.33    , true     , true  , null),
            array(new Validator(), '-10.33'  , true     , true  , null),
            array(new Validator(), 'on'      , true     , true  , null),
            array(new Validator(), 'yes'     , true     , true  , null),
            array(new Validator(), '1'       , true     , true  , null),
            array(new Validator(), 'true'    , true     , true  , null),
            array(new Validator(), 'false'   , false    , true  , null),
            array(new Validator(), 'off'     , false    , true  , null),
            array(new Validator(), 'no'      , false    , true  , null),
            array(new Validator(), 'no'      , false    , true  , null),
            array(new Validator(), 0         , false    , true  , null),
            array(new Validator(), '0'       , false    , true  , null),
            array(new Validator(), ''       , false    , true  , null),
            array(new Validator(), array()   , array()   , false , null),
        );

        return $data;
    }

}
