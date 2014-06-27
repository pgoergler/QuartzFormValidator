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
            array(new Validator(null, null, 'integer')          , '123.3'       , '123.3'       , false , new \InvalidArgumentException("you must set a valid integer")),
            array(new Validator(null, null, 'unsigned integer') , '-123'        , '-123'        , false , new \InvalidArgumentException("you must set a valid unsigned integer")),
            array(new Validator(null, null, 'unsigned integer') , '-123.3'      , '-123.3'      , false , new \InvalidArgumentException("you must set a valid unsigned integer")),
            array(new Validator(null, null, 'unsigned float')   , '-12.456'     , '-12.456'     , false , new \InvalidArgumentException("you must set a valid unsigned float")),
            array(new Validator(null, null, 'unsigned double')  , '-12.456'     , '-12.456'     , false , new \InvalidArgumentException("you must set a valid unsigned double")),
            array(new Validator(null, null, 'integer')          , 123.3         , 123.3         , false , new \InvalidArgumentException("you must set a valid integer")),
            array(new Validator(null, null, 'unsigned integer') , -123          , -123          , false , new \InvalidArgumentException("you must set a valid unsigned integer")),
            array(new Validator(null, null, 'unsigned integer') , -123.3        , -123.3        , false , new \InvalidArgumentException("you must set a valid unsigned integer")),
            array(new Validator(null, null, 'unsigned float')   , -12.456       , -12.456       , false , new \InvalidArgumentException("you must set a valid unsigned float")),
            array(new Validator(null, null, 'unsigned double')  , -12.456       , -12.456       , false , new \InvalidArgumentException("you must set a valid unsigned double")),
            //-
            array(new Validator(), array()   , array()   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), array(1)  , array(1)  , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), false     , false     , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), true      , true      , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), ''        , ''        , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), '     '   , '     '   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), 'null'    , 'null'    , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), '#null#'  , '#null#'  , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), 'false'   , 'false'   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), 'true'    , 'true'    , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), 'foo'     , 'foo'     , false , new \InvalidArgumentException("you must set a valid number")),
            //-
            array(new Validator(3), array()   , array()   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), array(1)  , array(1)  , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), false     , false     , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), true      , true      , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), ''        , ''        , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), '     '   , '     '   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), 'null'    , 'null'    , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), '#null#'  , '#null#'  , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), 'false'   , 'false'   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), 'true'    , 'true'    , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), 'foo'     , 'foo'     , false , new \InvalidArgumentException("you must set a valid number")),
            //-
            array(new Validator(3, 10), array()   , array()   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), array(1)  , array(1)  , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), false     , false     , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), true      , true      , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), ''        , ''        , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), '     '   , '     '   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), 'null'    , 'null'    , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), '#null#'  , '#null#'  , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), 'false'   , 'false'   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), 'true'    , 'true'    , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), 'foo'     , 'foo'     , false , new \InvalidArgumentException("you must set a valid number")),
           
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
            array(new Validator(null, null, 'integer')          , '123.3'       , '123.3'       , false , new \InvalidArgumentException("you must set a valid integer")),
            array(new Validator(null, null, 'unsigned integer') , '-123'        , '-123'        , false , new \InvalidArgumentException("you must set a valid unsigned integer")),
            array(new Validator(null, null, 'unsigned integer') , '-123.3'      , '-123.3'      , false , new \InvalidArgumentException("you must set a valid unsigned integer")),
            array(new Validator(null, null, 'unsigned float')   , '-12.456'     , '-12.456'     , false , new \InvalidArgumentException("you must set a valid unsigned float")),
            array(new Validator(null, null, 'unsigned double')  , '-12.456'     , '-12.456'     , false , new \InvalidArgumentException("you must set a valid unsigned double")),
            array(new Validator(null, null, 'integer')          , 123.3         , 123.3         , false , new \InvalidArgumentException("you must set a valid integer")),
            array(new Validator(null, null, 'unsigned integer') , -123          , -123          , false , new \InvalidArgumentException("you must set a valid unsigned integer")),
            array(new Validator(null, null, 'unsigned integer') , -123.3        , -123.3        , false , new \InvalidArgumentException("you must set a valid unsigned integer")),
            array(new Validator(null, null, 'unsigned float')   , -12.456       , -12.456       , false , new \InvalidArgumentException("you must set a valid unsigned float")),
            array(new Validator(null, null, 'unsigned double')  , -12.456       , -12.456       , false , new \InvalidArgumentException("you must set a valid unsigned double")),
            //-
            array(new Validator(), array()   , array()   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), array(1)  , array(1)  , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), false     , false     , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), true      , true      , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), ''        , ''        , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), '     '   , '     '   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), 'null'    , 'null'    , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), '#null#'  , '#null#'  , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), 'false'   , 'false'   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), 'true'    , 'true'    , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(), 'foo'     , 'foo'     , false , new \InvalidArgumentException("you must set a valid number")),
            //-
            array(new Validator(3), array()   , array()   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), array(1)  , array(1)  , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), false     , false     , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), true      , true      , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), ''        , ''        , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), '     '   , '     '   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), 'null'    , 'null'    , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), '#null#'  , '#null#'  , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), 'false'   , 'false'   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), 'true'    , 'true'    , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3), 'foo'     , 'foo'     , false , new \InvalidArgumentException("you must set a valid number")),
            //-
            array(new Validator(3, 10), array()   , array()   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), array(1)  , array(1)  , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), false     , false     , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), true      , true      , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), ''        , ''        , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), '     '   , '     '   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), 'null'    , 'null'    , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), '#null#'  , '#null#'  , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), 'false'   , 'false'   , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), 'true'    , 'true'    , false , new \InvalidArgumentException("you must set a valid number")),
            array(new Validator(3, 10), 'foo'     , 'foo'     , false , new \InvalidArgumentException("you must set a valid number")),
           
        );

        return $data;
    }

}
