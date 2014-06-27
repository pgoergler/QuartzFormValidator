<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\EnumValidator as Validator,
    Quartz\Component\FormValidator\Exceptions\ErrorException as ErrorException

;

/**
 * Description of EnumValidator
 *
 * @author paul
 */
class EnumValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new Validator(array(5,2,'foo', 1.0, null));
    }

    public function sanatizedDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator(array(5,2,'foo', 1.0, null)), null      , null      , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), 123       , 123       , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), 123.23    , 123.23    , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), '123'     , '123'     , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), '124.23'  , '124.23'  , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), 0         , 0         , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), '0'       , '0'       , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), -10.33    , -10.33    , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), '-10.33'  , '-10.33'  , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), 1234      , 1234      , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), 123456    , 123456    , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), 123.456   , 123.456   , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), '1234'    , '1234'    , true , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), '123456'  , '123456'  , true , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), '-123456' , '-123456' , true , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), '123.456' , '123.456' , true , null),
            //-
            array(new Validator(array(5,2,'foo', 1.0, null)), array()   , array()   , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), array(1)  , array(1)  , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), false     , false     , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), true      , true      , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), ''        , ''        , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), '     '   , '     '   , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), 'null'    , 'null'    , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), '#null#'  , '#null#'  , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), 'false'   , 'false'   , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), 'true'    , 'true'    , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null)), 'foo'     , 'foo'     , true  , null),
            //-
            array(new Validator(array(5,2,'foo', 1.0, null),true), null      , null      , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 123       , 123       , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 123.23    , 123.23    , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '123'     , '123'     , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '124.23'  , '124.23'  , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 0         , 0         , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '0'       , '0'       , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), -10.33    , -10.33    , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '-10.33'  , '-10.33'  , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 1234      , 1234      , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 123456    , 123456    , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 123.456   , 123.456   , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '1234'    , '1234'    , true , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '123456'  , '123456'  , true , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '-123456' , '-123456' , true , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '123.456' , '123.456' , true , null),
            //-,true
            array(new Validator(array(5,2,'foo', 1.0, null),true), array()   , array()   , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), array(1)  , array(1)  , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), false     , false     , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), true      , true      , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), ''        , ''        , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '     '   , '     '   , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 'null'    , 'null'    , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '#null#'  , '#null#'  , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 'false'   , 'false'   , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 'true'    , 'true'    , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 'foo'     , 'foo'     , true  , null),
        );

        return $data;
    }
    
    public function checkDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator(array(5,2,'foo', 1.0, null))     , null      , null       , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))     , 5         , 5          , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))     , 2         , 2          , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))     , 'foo'     , 'foo'      , true  , null),            
            array(new Validator(array(5,2,'foo', 1.0, null))     , 1         , 1          , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))     , 1.0       , 1.0        , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))     , '1.0'     , '1.0'      , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))     , 0         , 0          , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))     , array()   , array()    , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))     , false     , false      , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))     , ''        , ''         , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))     , true      , true       , true  , null),
            //-     
            array(new Validator(array(5,2,'foo', 1.0, null))     , 123       , 123        , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null))     , 123.23    , 123.23     , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null))     , '123'     , '123'      , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null))     , '124.23'  , '124.23'   , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null))     , '0'       , '0'        , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null))     , -10.33    , -10.33     , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null))     , '-10.33'  , '-10.33'   , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null))     , array(1)  , array(1)   , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null))     , '     '   , '     '    , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null))     , 'null'    , 'null'     , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null))     , '#null#'  , '#null#'   , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null))     , 'false'   , 'false'    , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null))     , 'true'    , 'true'     , false , new ErrorException('test-field', '', "you must choose a valid value")),
            //-
            array(new Validator(array(5,2,'foo', 1.0, null),true), null      , null       , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 5         , 5          , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 2         , 2          , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 'foo'     , 'foo'      , true  , null),            
            array(new Validator(array(5,2,'foo', 1.0, null),true), 1.0       , 1.0        , true  , null),
            //-
            array(new Validator(array(5,2,'foo', 1.0, null),true), 0         , 0          , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 1         , 1          , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '1.0'     , '1.0'      , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 123       , 123        , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 123.23    , 123.23     , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '123'     , '123'      , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '124.23'  , '124.23'   , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '0'       , '0'        , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), -10.33    , -10.33     , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '-10.33'  , '-10.33'   , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), array()   , array()    , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), array(1)  , array(1)   , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), ''        , ''         , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '     '   , '     '    , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 'null'    , 'null'     , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), '#null#'  , '#null#'   , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 'false'   , 'false'    , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), 'true'    , 'true'     , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), true      , true       , false , new ErrorException('test-field', '', "you must choose a valid value")),
            array(new Validator(array(5,2,'foo', 1.0, null),true), false     , false      , false , new ErrorException('test-field', '', "you must choose a valid value")),
        );

        return $data;
    }

}
