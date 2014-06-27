<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\NumberValidator as Validator,
    Quartz\Component\FormValidator\Exceptions\ErrorException as ErrorException

;

/**
 * Description of NumberValidator
 *
 * @author paul
 */
class NumberValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new Validator();
    }

    public function sanatizedDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator(), null      , null      , true  , null),
            array(new Validator(), 123       , 123.00    , true  , null),
            array(new Validator(), 123.23    , 123.23    , true  , null),
            array(new Validator(), '123'     , 123.00    , true  , null),
            array(new Validator(), '124.23'  , 124.23    , true  , null),
            array(new Validator(), 0         , 0.00      , true  , null),
            array(new Validator(), '0'       , 0.00      , true  , null),
            array(new Validator(), -10.33    , -10.33    , true  , null),
            array(new Validator(), '-10.33'  , -10.33    , true  , null),
            array(new Validator(), 1234      , 1234.00   , true  , null),
            array(new Validator(), 123456    , 123456.00 , true  , null),
            array(new Validator(), 123.456   , 123.456   , true  , null),
            array(new Validator(), '1234'    , 1234.00   , true , null),
            array(new Validator(), '123456'  , 123456.00 , true , null),
            array(new Validator(), '-123456' , -123456.00, true , null),
            array(new Validator(), '123.456' , 123.456   , true , null),
            //-
            array(new Validator(3), null      , null      , true  , null),
            array(new Validator(3), 123       , 123.00    , true  , null),
            array(new Validator(3), 123.23    , 123.23    , true  , null),
            array(new Validator(3), '123'     , 123.00    , true  , null),
            array(new Validator(3), '124.23'  , 124.23    , true  , null),
            array(new Validator(3), 0         , 0.00      , true  , null),
            array(new Validator(3), '0'       , 0.00      , true  , null),
            array(new Validator(3), -10.33    , -10.33    , true  , null),
            array(new Validator(3), '-10.33'  , -10.33    , true  , null),
            array(new Validator(3), 1234      , 1234.00   , true  , null),
            array(new Validator(3), 123456    , 123456.00 , true  , null),
            array(new Validator(3), 123.456   , 123.456   , true  , null),
            array(new Validator(3), '1234'    , 1234.00   , true , null),
            array(new Validator(3), '123456'  , 123456.00 , true , null),
            array(new Validator(3), '-123456' , -123456.00, true , null),
            array(new Validator(3), '123.456' , 123.456   , true , null),
            //-
            array(new Validator(3, 10), null      , null      , true  , null),
            array(new Validator(3, 10), 123       , 123.00    , true  , null),
            array(new Validator(3, 10), 123.23    , 123.23    , true  , null),
            array(new Validator(3, 10), '123'     , 123.00    , true  , null),
            array(new Validator(3, 10), '124.23'  , 124.23    , true  , null),
            array(new Validator(3, 10), 0         , 0.00      , true  , null),
            array(new Validator(3, 10), '0'       , 0.00      , true  , null),
            array(new Validator(3, 10), -10.33    , -10.33    , true  , null),
            array(new Validator(3, 10), '-10.33'  , -10.33    , true  , null),
            array(new Validator(3, 10), 1234      , 1234.00   , true  , null),
            array(new Validator(3, 10), 123456    , 123456.00 , true  , null),
            array(new Validator(3, 10), 123.456   , 123.456   , true  , null),
            array(new Validator(3, 10), '1234'    , 1234.00   , true , null),
            array(new Validator(3, 10), '123456'  , 123456.00 , true , null),
            array(new Validator(3, 10), '-123456' , -123456.00, true , null),
            array(new Validator(3, 10), '123.456' , 123.456   , true , null),
            //-
            array(new Validator(null, null, 'integer')          , '123'         , 123           , true , null),
            array(new Validator(null, null, 'integer')          , '-123'        , -123          , true , null),
            array(new Validator(null, null, 'float')            , '123.456'     , 123.456       , true , null),
            array(new Validator(null, null, 'float')            , '-123.456'    , -123.456      , true , null),
            array(new Validator(null, null, 'double')           , '123.456'     , 123.456       , true , null),
            array(new Validator(null, null, 'double')           , '-123.456'    , -123.456      , true , null),
            array(new Validator(null, null, 'unsigned integer') , '123'         , 123           , true , null),
            array(new Validator(null, null, 'unsigned float')   , '123.456'     , 123.456       , true , null),
            array(new Validator(null, null, 'unsigned double')  , '123.456'     , 123.456       , true , null),
            //-
            array(new Validator(null, null, 'integer')          , '123.3'       , '123.3'       , false , null),
            array(new Validator(null, null, 'unsigned integer') , '-123'        , '-123'        , false , null),
            array(new Validator(null, null, 'unsigned integer') , '-123.3'      , '-123.3'      , false , null),
            array(new Validator(null, null, 'unsigned float')   , '-12.456'     , '-12.456'     , false , null),
            array(new Validator(null, null, 'unsigned double')  , '-12.456'     , '-12.456'     , false , null),
            array(new Validator(null, null, 'integer')          , 123.3         , 123.3         , false , null),
            array(new Validator(null, null, 'unsigned integer') , -123          , -123          , false , null),
            array(new Validator(null, null, 'unsigned integer') , -123.3        , -123.3        , false , null),
            array(new Validator(null, null, 'unsigned float')   , -12.456       , -12.456       , false , null),
            array(new Validator(null, null, 'unsigned double')  , -12.456       , -12.456       , false , null),
            //-
            array(new Validator(), array()   , array()   , false , null),
            array(new Validator(), array(1)  , array(1)  , false , null),
            array(new Validator(), false     , false     , false , null),
            array(new Validator(), true      , true      , false , null),
            array(new Validator(), ''        , ''        , false , null),
            array(new Validator(), '     '   , '     '   , false , null),
            array(new Validator(), 'null'    , 'null'    , false , null),
            array(new Validator(), '#null#'  , '#null#'  , false , null),
            array(new Validator(), 'false'   , 'false'   , false , null),
            array(new Validator(), 'true'    , 'true'    , false , null),
            array(new Validator(), 'foo'     , 'foo'     , false , null),
            //-
            array(new Validator(3), array()   , array()   , false , null),
            array(new Validator(3), array(1)  , array(1)  , false , null),
            array(new Validator(3), false     , false     , false , null),
            array(new Validator(3), true      , true      , false , null),
            array(new Validator(3), ''        , ''        , false , null),
            array(new Validator(3), '     '   , '     '   , false , null),
            array(new Validator(3), 'null'    , 'null'    , false , null),
            array(new Validator(3), '#null#'  , '#null#'  , false , null),
            array(new Validator(3), 'false'   , 'false'   , false , null),
            array(new Validator(3), 'true'    , 'true'    , false , null),
            array(new Validator(3), 'foo'     , 'foo'     , false , null),
            //-
            array(new Validator(3, 10), array()   , array()   , false , null),
            array(new Validator(3, 10), array(1)  , array(1)  , false , null),
            array(new Validator(3, 10), false     , false     , false , null),
            array(new Validator(3, 10), true      , true      , false , null),
            array(new Validator(3, 10), ''        , ''        , false , null),
            array(new Validator(3, 10), '     '   , '     '   , false , null),
            array(new Validator(3, 10), 'null'    , 'null'    , false , null),
            array(new Validator(3, 10), '#null#'  , '#null#'  , false , null),
            array(new Validator(3, 10), 'false'   , 'false'   , false , null),
            array(new Validator(3, 10), 'true'    , 'true'    , false , null),
            array(new Validator(3, 10), 'foo'     , 'foo'     , false , null),
           
        );

        return $data;
    }
    
    public function checkDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator(), null      , null      , true  , null),
            array(new Validator(), 123       , 123.00    , true  , null),
            array(new Validator(), 123.23    , 123.23    , true  , null),
            array(new Validator(), '123'     , 123.00    , true  , null),
            array(new Validator(), '124.23'  , 124.23    , true  , null),
            array(new Validator(), 0         , 0.00      , true  , null),
            array(new Validator(), '0'       , 0.00      , true  , null),
            array(new Validator(), -10.33    , -10.33    , true  , null),
            array(new Validator(), '-10.33'  , -10.33    , true  , null),
            array(new Validator(), 1234      , 1234.00   , true  , null),
            array(new Validator(), 123456    , 123456.00 , true  , null),
            array(new Validator(), 123.456   , 123.456   , true  , null),
            array(new Validator(), '1234'    , 1234.00   , true , null),
            array(new Validator(), '123456'  , 123456.00 , true , null),
            array(new Validator(), '-123456' , -123456.00, true , null),
            array(new Validator(), '123.456' , 123.456   , true , null),
            //-
            array(new Validator(3), null      , null      , true  , null),
            array(new Validator(3), 3         , 3.00      , true  , null),
            array(new Validator(3), 123       , 123.00    , false , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3), 123.23    , 123.23    , false , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3), '123'     , 123.00    , false , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3), '124.23'  , 124.23    , false , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3), 0         , 0.00      , false , new ErrorException('test-field', '', "you must a number greater than {0}")),
            array(new Validator(3), '0'       , 0.00      , false , new ErrorException('test-field', '', "you must a number greater than {0}")),
            array(new Validator(3), -10.33    , -10.33    , false , new ErrorException('test-field', '', "you must a number greater than {0}")),
            array(new Validator(3), '-10.33'  , -10.33    , false , new ErrorException('test-field', '', "you must a number greater than {0}")),
            array(new Validator(3), 1234      , 1234.00   , false , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3), 123456    , 123456.00 , false , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3), 123.456   , 123.456   , false , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3), '1234'    , 1234.00   , false , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3), '123456'  , 123456.00 , false , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3), '-123456' , -123456.00, false , new ErrorException('test-field', '', "you must a number greater than {0}")),
            array(new Validator(3), '123.456' , 123.456   , false , new ErrorException('test-field', '', "you must a number lower than {0}")),
            //-
            array(new Validator(3, 10), null      , null      , true , null),
            array(new Validator(3, 10), 5         , 5.00      , true , null),
            array(new Validator(3, 10), 3         , 3.00      , true , null),
            array(new Validator(3, 10), 10        , 10.00     , true , null),
            array(new Validator(3, 10), 123       , 123.00    , true , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3, 10), 123.23    , 123.23    , true , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3, 10), '123'     , 123.00    , true , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3, 10), '124.23'  , 124.23    , true , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3, 10), 0         , 0.00      , true , new ErrorException('test-field', '', "you must a number greater than {0}")),
            array(new Validator(3, 10), '0'       , 0.00      , true , new ErrorException('test-field', '', "you must a number greater than {0}")),
            array(new Validator(3, 10), -10.33    , -10.33    , true , new ErrorException('test-field', '', "you must a number greater than {0}")),
            array(new Validator(3, 10), '-10.33'  , -10.33    , true , new ErrorException('test-field', '', "you must a number greater than {0}")),
            array(new Validator(3, 10), 1234      , 1234.00   , true , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3, 10), 123456    , 123456.00 , true , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3, 10), 123.456   , 123.456   , true , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3, 10), '1234'    , 1234.00   , true , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3, 10), '123456'  , 123456.00 , true , new ErrorException('test-field', '', "you must a number lower than {0}")),
            array(new Validator(3, 10), '-123456' , -123456.00, true , new ErrorException('test-field', '', "you must a number greater than {0}")),
            array(new Validator(3, 10), '123.456' , 123.456   , true , new ErrorException('test-field', '', "you must a number lower than {0}")),
            //-
            array(new Validator(null, null, 'integer')          , '123'         , 123           , true , null),
            array(new Validator(null, null, 'integer')          , '-123'        , -123          , true , null),
            array(new Validator(null, null, 'float')            , '123.456'     , 123.456       , true , null),
            array(new Validator(null, null, 'float')            , '-123.456'    , -123.456      , true , null),
            array(new Validator(null, null, 'double')           , '123.456'     , 123.456       , true , null),
            array(new Validator(null, null, 'double')           , '-123.456'    , -123.456      , true , null),
            array(new Validator(null, null, 'unsigned integer') , '123'         , 123           , true , null),
            array(new Validator(null, null, 'unsigned float')   , '123.456'     , 123.456       , true , null),
            array(new Validator(null, null, 'unsigned double')  , '123.456'     , 123.456       , true , null),
            //-
            array(new Validator(null, null, 'integer')          , '123.3'       , '123.3'       , false , null),
            array(new Validator(null, null, 'unsigned integer') , '-123'        , '-123'        , false , null),
            array(new Validator(null, null, 'unsigned integer') , '-123.3'      , '-123.3'      , false , null),
            array(new Validator(null, null, 'unsigned float')   , '-12.456'     , '-12.456'     , false , null),
            array(new Validator(null, null, 'unsigned double')  , '-12.456'     , '-12.456'     , false , null),
            array(new Validator(null, null, 'integer')          , 123.3         , 123.3         , false , null),
            array(new Validator(null, null, 'unsigned integer') , -123          , -123          , false , null),
            array(new Validator(null, null, 'unsigned integer') , -123.3        , -123.3        , false , null),
            array(new Validator(null, null, 'unsigned float')   , -12.456       , -12.456       , false , null),
            array(new Validator(null, null, 'unsigned double')  , -12.456       , -12.456       , false , null),
            //-
            array(new Validator(), array()   , array()   , false , null),
            array(new Validator(), array(1)  , array(1)  , false , null),
            array(new Validator(), false     , false     , false , null),
            array(new Validator(), true      , true      , false , null),
            array(new Validator(), ''        , ''        , false , null),
            array(new Validator(), '     '   , '     '   , false , null),
            array(new Validator(), 'null'    , 'null'    , false , null),
            array(new Validator(), '#null#'  , '#null#'  , false , null),
            array(new Validator(), 'false'   , 'false'   , false , null),
            array(new Validator(), 'true'    , 'true'    , false , null),
            array(new Validator(), 'foo'     , 'foo'     , false , null),
            //-
            array(new Validator(3), array()   , array()   , false , null),
            array(new Validator(3), array(1)  , array(1)  , false , null),
            array(new Validator(3), false     , false     , false , null),
            array(new Validator(3), true      , true      , false , null),
            array(new Validator(3), ''        , ''        , false , null),
            array(new Validator(3), '     '   , '     '   , false , null),
            array(new Validator(3), 'null'    , 'null'    , false , null),
            array(new Validator(3), '#null#'  , '#null#'  , false , null),
            array(new Validator(3), 'false'   , 'false'   , false , null),
            array(new Validator(3), 'true'    , 'true'    , false , null),
            array(new Validator(3), 'foo'     , 'foo'     , false , null),
            //-
            array(new Validator(3, 10), array()   , array()   , false , null),
            array(new Validator(3, 10), array(1)  , array(1)  , false , null),
            array(new Validator(3, 10), false     , false     , false , null),
            array(new Validator(3, 10), true      , true      , false , null),
            array(new Validator(3, 10), ''        , ''        , false , null),
            array(new Validator(3, 10), '     '   , '     '   , false , null),
            array(new Validator(3, 10), 'null'    , 'null'    , false , null),
            array(new Validator(3, 10), '#null#'  , '#null#'  , false , null),
            array(new Validator(3, 10), 'false'   , 'false'   , false , null),
            array(new Validator(3, 10), 'true'    , 'true'    , false , null),
            array(new Validator(3, 10), 'foo'     , 'foo'     , false , null),
           
        );

        return $data;
    }

}
