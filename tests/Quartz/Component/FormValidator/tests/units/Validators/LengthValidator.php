<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\LengthValidator as Validator,
    Quartz\Component\FormValidator\Exceptions\ErrorException as ErrorException

;

/**
 * Description of LengthValidator
 *
 * @author paul
 */
class LengthValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new Validator();
    }

    public function sanatizedDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator()       , array()     , array()   , false, null),
            array(new Validator()       , array(1)    , array(1)  , false, null),
            array(new Validator()       , false       , false     , false, null),
            array(new Validator()       , true        , true      , false, null),
            array(new Validator()       , 1234        , 1234      , false, null),
            //-
            array(new Validator(1)      , array()     , array()   , false, null),
            array(new Validator(1)      , array(1)    , array(1)  , false, null),
            array(new Validator(1)      , false       , false     , false, null),
            array(new Validator(1)      , true        , true      , false, null),
            array(new Validator(1)      , 1234        , 1234      , false, null),
            //-
            array(new Validator(1, 3)   , array()     , array()   , false, null),
            array(new Validator(1, 3)   , array(1)    , array(1)  , false, null),
            array(new Validator(1, 3)   , false       , false     , false, null),
            array(new Validator(1, 3)   , true        , true      , false, null),
            array(new Validator(1, 3)   , 1234        , 1234      , false, null),
            //-
            array(new Validator(), ''           , ''        , true, null),
            array(new Validator(), null         , null      , true, null),
            array(new Validator(), '     '      , '     '   , true, null),
            array(new Validator(), '0'          , '0'       , true, null),
            array(new Validator(), 'null'       , 'null'    , true, null),
            array(new Validator(), '#null#'     , '#null#'  , true, null),
            array(new Validator(), 'false'      , 'false'   , true, null),
            array(new Validator(), 'true'       , 'true'    , true, null),
            array(new Validator(), 'foo'        , 'foo'     , true, null),
        );

        return $data;
    }
    
    public function checkDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator(), array()      , array()   , false, null),
            array(new Validator(), array(1)     , array(1)  , false, null),
            array(new Validator(), false        , false     , false, null),
            array(new Validator(), true         , true      , false, null),
            array(new Validator(), 1234         , 1234      , false, null),
            //-
            //-
            array(new Validator(1)      , array()     , array()   , false, new ErrorException('test-field', '', "you must set a valid value")),
            array(new Validator(1)      , array(1)    , array(1)  , false, new ErrorException('test-field', '', "you must set a valid value")),
            array(new Validator(1)      , false       , false     , false, new ErrorException('test-field', '', "you must set a valid value")),
            array(new Validator(1)      , true        , true      , false, new ErrorException('test-field', '', "you must set a valid value")),
            array(new Validator(1)      , 1234        , 1234      , false, new ErrorException('test-field', '', "you must set a valid value")),
            //-
            array(new Validator(1, 3)   , array()     , array()   , false, new ErrorException('test-field', '', "you must set a valid value")),
            array(new Validator(1, 3)   , array(1)    , array(1)  , false, new ErrorException('test-field', '', "you must set a valid value")),
            array(new Validator(1, 3)   , false       , false     , false, new ErrorException('test-field', '', "you must set a valid value")),
            array(new Validator(1, 3)   , true        , true      , false, new ErrorException('test-field', '', "you must set a valid value")),
            array(new Validator(1, 3)   , 1234        , 1234      , false, new ErrorException('test-field', '', "you must set a valid value")),
            array(new Validator(), "foo\nbar"         , "foo\nbar", false, new ErrorException('test-field', '', "you must set a valid value")),
            array(new Validator(), "\n"               , ''        , true, null),
            array(new Validator(1), "\n"              , "\n"      , false, new ErrorException('test-field', '', "you must set a valid value")),
            array(new Validator(1, 4), "\n"           , "\n"      , false, new ErrorException('test-field', '', "you must set a valid value")),
            array(new Validator(1, 4), "foo\n"        , "foo"     , true, null),

            //-
            array(new Validator(), ''           , ''        , true, null),
            array(new Validator(), null         , null      , true, null),
            array(new Validator(), '     '      , '     '   , true, null),
            array(new Validator(), '0'          , '0'       , true, null),
            array(new Validator(), 'null'       , 'null'    , true, null),
            array(new Validator(), '#null#'     , '#null#'  , true, null),
            array(new Validator(), 'false'      , 'false'   , true, null),
            array(new Validator(), 'true'       , 'true'    , true, null),
            array(new Validator(), 'foo'        , 'foo'     , true, null),
            //-
            array(new Validator(1), '0'         , '0'       , true, null),
            array(new Validator(1), ''          , ''        , true, new ErrorException('test-field', '', "length must be {0} characters")),
            array(new Validator(1), null        , null      , true, new ErrorException('test-field', '', "length must be {0} characters")),
            array(new Validator(1), '     '     , '     '   , true, new ErrorException('test-field', '', "length must be {0} characters")),
            array(new Validator(1), 'null'      , 'null'    , true, new ErrorException('test-field', '', "length must be {0} characters")),
            array(new Validator(1), '#null#'    , '#null#'  , true, new ErrorException('test-field', '', "length must be {0} characters")),
            array(new Validator(1), 'false'     , 'false'   , true, new ErrorException('test-field', '', "length must be {0} characters")),
            array(new Validator(1), 'true'      , 'true'    , true, new ErrorException('test-field', '', "length must be {0} characters")),
            array(new Validator(1), 'foo'       , 'foo'     , true, new ErrorException('test-field', '', "length must be {0} characters")),
            //-
            array(new Validator(1,5), '0'       , '0'       , true, null),
            array(new Validator(1,5), '     '   , '     '   , true, null),
            array(new Validator(1,5), 'false'   , 'false'   , true, null),
            array(new Validator(1,5), 'null'    , 'null'    , true, null),
            array(new Validator(1,5), 'true'    , 'true'    , true, null),
            array(new Validator(1,5), 'foo'     , 'foo'     , true, null),
            array(new Validator(1,5), ''        , ''        , true, new ErrorException('test-field', '', "length must be between {0} and {1} characters")),
            array(new Validator(1,5), null      , null      , true, new ErrorException('test-field', '', "length must be between {0} and {1} characters")),
            array(new Validator(1,5), '#null#'  , '#null#'  , true, new ErrorException('test-field', '', "length must be between {0} and {1} characters")),
        );

        return $data;
    }

}
