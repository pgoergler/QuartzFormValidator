<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\DecimalValidator as Validator,
    Quartz\Component\FormValidator\Exceptions\ErrorException as ErrorException

;

/**
 * Description of DecimalValidator
 *
 * @author paul
 */
class DecimalValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new Validator(5,2);
    }

    public function sanatizedDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator(5,2), null      , null      , true  , null),
            array(new Validator(5,2), 123       , 123.00    , true  , null),
            array(new Validator(5,2), 123.23    , 123.23    , true  , null),
            array(new Validator(5,2), '123'     , 123.00    , true  , null),
            array(new Validator(5,2), '124.23'  , 124.23    , true  , null),
            array(new Validator(5,2), 0         , 0.00      , true  , null),
            array(new Validator(5,2), '0'       , 0.00      , true  , null),
            array(new Validator(5,2), -10.33    , -10.33    , true  , null),
            array(new Validator(5,2), '-10.33'  , -10.33    , true  , null),
            array(new Validator(5,2), 1234      , 1234.00   , true  , null),
            array(new Validator(5,2), 123456    , 123456.00 , true  , null),
            array(new Validator(5,2), 123.456   , 123.456   , true  , null),
            array(new Validator(5,2), '1234'    , 1234.00   , true , null),
            array(new Validator(5,2), '123456'  , 123456.00 , true , null),
            array(new Validator(5,2), '-123456' , -123456.00, true , null),
            array(new Validator(5,2), '123.456' , 123.456   , true , null),
            //-
            array(new Validator(5,2), array()   , array()   , false , null),
            array(new Validator(5,2), array(1)  , array(1)  , false , null),
            array(new Validator(5,2), false     , false     , false , null),
            array(new Validator(5,2), true      , true      , false , null),
            array(new Validator(5,2), ''        , ''        , false , null),
            array(new Validator(5,2), '     '   , '     '   , false , null),
            array(new Validator(5,2), 'null'    , 'null'    , false , null),
            array(new Validator(5,2), '#null#'  , '#null#'  , false , null),
            array(new Validator(5,2), 'false'   , 'false'   , false , null),
            array(new Validator(5,2), 'true'    , 'true'    , false , null),
            array(new Validator(5,2), 'foo'     , 'foo'     , false , null),
            
        );

        return $data;
    }
    
    public function checkDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator(5,2), null      , null      , true  , null),
            array(new Validator(5,2), 123       , 123.00    , true  , null),
            array(new Validator(5,2), 123.23    , 123.23    , true  , null),
            array(new Validator(5,2), '123'     , 123.00    , true  , null),
            array(new Validator(5,2), '124.23'  , 124.23    , true  , null),
            array(new Validator(5,2), 0         , 0.00      , true  , null),
            array(new Validator(5,2), '0'       , 0.00      , true  , null),
            array(new Validator(5,2), -10.33    , -10.33    , true  , null),
            array(new Validator(5,2), '-10.33'  , -10.33    , true  , null),
            //-
            array(new Validator(5,2), array()   , array()   , false , null),
            array(new Validator(5,2), array(1)  , array(1)  , false , null),
            array(new Validator(5,2), false     , false     , false , null),
            array(new Validator(5,2), true      , true      , false , null),
            array(new Validator(5,2), ''        , ''        , false , null),
            array(new Validator(5,2), '     '   , '     '   , false , null),
            array(new Validator(5,2), 'null'    , 'null'    , false , null),
            array(new Validator(5,2), '#null#'  , '#null#'  , false , null),
            array(new Validator(5,2), 'false'   , 'false'   , false , null),
            array(new Validator(5,2), 'true'    , 'true'    , false , null),
            array(new Validator(5,2), 'foo'     , 'foo'     , false , null),
            array(new Validator(5,2), 1234      , 1234.00   , false , new ErrorException('test-field', '', "you must set a valid number")),
            array(new Validator(5,2), '1234'    , 1234.00   , false , new ErrorException('test-field', '', "you must set a valid number")),
            array(new Validator(5,2), 123456    , 123456.00 , false , new ErrorException('test-field', '', "you must set a valid number")),
            array(new Validator(5,2), '123456'  , 123456.00 , false , new ErrorException('test-field', '', "you must set a valid number")),
            array(new Validator(5,2), 123.456   , 123.456   , false , new ErrorException('test-field', '', "you must set a valid number")),
            array(new Validator(5,2), '123.456' , 123.456   , false , new ErrorException('test-field', '', "you must set a valid number")),
            
        );

        return $data;
    }

}
