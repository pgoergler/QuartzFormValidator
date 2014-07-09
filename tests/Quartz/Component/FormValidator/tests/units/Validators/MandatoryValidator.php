<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\MandatoryValidator as Validator,
    Quartz\Component\FormValidator\NotSetField,
    Quartz\Component\FormValidator\Exceptions\ErrorException
;

/**
 * Description of MandatoryValidator
 *
 * @author paul
 */
class MandatoryValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new Validator('notset');
    }
    
    public function sanatizedDataProvider()
    {
        $data = array(
            //  value, expected value, isset
            array(new Validator(), null      , null      , true , null),
            array(new Validator(), ''        , ''        , true  , null),
            array(new Validator(), array()   , array()   , true  , null),
            array(new Validator(), '     '   , '     '   , true  , null),
            array(new Validator(), '0'       , '0'       , true  , null),
            array(new Validator(), 'null'    , 'null'    , true  , null),
            array(new Validator(), 'false'   , 'false'   , true  , null),
            array(new Validator(), 'true'    , 'true'    , true  , null),
            array(new Validator(), 'foo'     ,'foo'      , true  , null),
            array(new Validator(), array(1)  , array(1)  , true  , null),
            //-
            array(new Validator(), new NotSetField('foo'), 'foo', false , null),
            array(new Validator(), new NotSetField('foo'), 'foo', false , null),
        );

        return $data;
    }

    public function checkDataProvider()
    {
        $data = array(
            //  value, expected value, isset
            array(new Validator(), null      , null      , true , null),
            array(new Validator(), ''        , ''        , true  , null),
            array(new Validator(), array()   , array()   , true  , null),
            array(new Validator(), '     '   , '     '   , true  , null),
            array(new Validator(), '0'       , '0'       , true  , null),
            array(new Validator(), 'null'    , 'null'    , true  , null),
            array(new Validator(), 'false'   , 'false'   , true  , null),
            array(new Validator(), 'true'    , 'true'    , true  , null),
            array(new Validator(), 'foo'     ,'foo'      , true  , null),
            array(new Validator(), array(1)  , array(1)  , true  , null),
            //-
            array(new Validator(), new NotSetField('foo'), 'notset', true , new ErrorException('test-field', '', "you must set a value")),
            array(new Validator(), new NotSetField('foo'), 'notset', false , new ErrorException('test-field', '', "you must set a value")),
        );

        return $data;
    }
    
}
