<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\NotSetAsValidator as Validator,
    Quartz\Component\FormValidator\NotSetField

;

/**
 * Description of NotSetAsValidator
 *
 * @author paul
 */
class NotSetAsValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new Validator('notset');
    }
    
    public function sanatizedDataProvider()
    {
        $data = array(
            //  value, expected value, isset
            array(new Validator('notset'), null      , null      , true , null),
            array(new Validator('notset'), ''        , ''        , true  , null),
            array(new Validator('notset'), array()   , array()   , true  , null),
            array(new Validator('notset'), '     '   , '     '   , true  , null),
            array(new Validator('notset'), '0'       , '0'       , true  , null),
            array(new Validator('notset'), 'null'    , 'null'    , true  , null),
            array(new Validator('notset'), 'false'   , 'false'   , true  , null),
            array(new Validator('notset'), 'true'    , 'true'    , true  , null),
            array(new Validator('notset'), 'foo'     ,'foo'      , true  , null),
            array(new Validator('notset'), array(1)  , array(1)  , true  , null),
            //-
            array(new Validator('notset'), new NotSetField('foo'), 'notset', false , null),
            array(new Validator(new NotSetField('notset')), new NotSetField('foo'), 'notset', false , null),
        );

        return $data;
    }

    public function checkDataProvider()
    {
        $data = array(
            //  value, expected value, isset
            array(new Validator('notset'), null      , null      , true , null),
            array(new Validator('notset'), ''        , ''        , true  , null),
            array(new Validator('notset'), array()   , array()   , true  , null),
            array(new Validator('notset'), '     '   , '     '   , true  , null),
            array(new Validator('notset'), '0'       , '0'       , true  , null),
            array(new Validator('notset'), 'null'    , 'null'    , true  , null),
            array(new Validator('notset'), 'false'   , 'false'   , true  , null),
            array(new Validator('notset'), 'true'    , 'true'    , true  , null),
            array(new Validator('notset'), 'foo'     ,'foo'      , true  , null),
            array(new Validator('notset'), array(1)  , array(1)  , true  , null),
            //-
            array(new Validator('notset'), new NotSetField('foo'), 'notset', true , null),
            array(new Validator(new NotSetField('notset')), new NotSetField('foo'), 'notset', false , null),
        );

        return $data;
    }
    
}
