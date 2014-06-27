<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\NotNullValidator as Validator,
    Quartz\Component\FormValidator\Exceptions\ErrorException as ErrorException
;

/**
 * Description of NotNullValidator
 *
 * @author paul
 */
class NotNullValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new Validator();
    }
    
    public function sanatizedDataProvider()
    {
        $data = array(
            //  value, expected value, isset
            array(new Validator(), null      , null      , false , null),
            array(new Validator(), ''        , ''        , true  , null),
            array(new Validator(), array()   , array()   , true  , null),
            array(new Validator(), '     '   , '     '   , true  , null),
            array(new Validator(), '0'       , '0'       , true  , null),
            array(new Validator(), 'null'    , 'null'    , true  , null),
            array(new Validator(), 'false'   , 'false'   , true  , null),
            array(new Validator(), 'true'    , 'true'    , true  , null),
            array(new Validator(), 'foo'     ,'foo'      , true  , null),
            array(new Validator(), array(1)  , array(1)  , true  , null),
        );

        return $data;
    }
    
    public function checkDataProvider()
    {
        $data = array(
            //  value, expected value, isset
            array(new Validator(), null      , null      , false , new ErrorException('test-field', '', "you must set a value")),
            array(new Validator(), ''        , ''        , true  , null),
            array(new Validator(), array()   , array()   , true  , null),
            array(new Validator(), '     '   , '     '   , true  , null),
            array(new Validator(), '0'       , '0'       , true  , null),
            array(new Validator(), 'null'    , 'null'    , true  , null),
            array(new Validator(), 'false'   , 'false'   , true  , null),
            array(new Validator(), 'true'    , 'true'    , true  , null),
            array(new Validator(), 'foo'     ,'foo'      , true  , null),
            array(new Validator(), array(1)  , array(1)  , true  , null),
        );

        return $data;
    }

}
