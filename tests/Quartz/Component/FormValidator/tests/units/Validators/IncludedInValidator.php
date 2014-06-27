<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\IncludedInValidator as Validator,
    Quartz\Component\FormValidator\Exceptions\ErrorException as ErrorException

;

/**
 * Description of IncludedInValidator
 *
 * @author paul
 */
class IncludedInValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new Validator(array(5,2,'foo', 1.0, null));
    }

    public function sanatizedDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator(array(5,2,'foo', 1.0, null))      , array()   , array()   , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      , array(1)  , array(1)  , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      , null      , null      , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      , false     , false     , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      , true      , true      , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      , ''        , array()   , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      , '     '   , '     '   , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      , 'null'    , 'null'    , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      , '#null#'  , '#null#'  , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      , 'false'   , 'false'   , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      , 'true'    , 'true'    , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      , 'foo'     , 'foo'     , false , null),
            //-
            array(new Validator(array(5,2,'foo', 1.0, null), true), array()   , array()   , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true), array(1)  , array(1)  , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true), null      , null      , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true), false     , false     , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true), true      , true      , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true), ''        , array()   , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true), '     '   , '     '   , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true), 'null'    , 'null'    , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true), '#null#'  , '#null#'  , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true), 'false'   , 'false'   , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true), 'true'    , 'true'    , false , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true), 'foo'     , 'foo'     , false , null),
        );

        return $data;
    }
    
    public function checkDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array()                    , array()                    , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array(1)                   , array(1)                   , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array('1')                 , array('1')                 , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array(5)                   , array(5)                   , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array('foo')               , array('foo')               , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array(1.0)                 , array(1.0)                 , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array(null)                , array(null)                , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array(1,5)                 , array(1,5)                 , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array(1,2)                 , array(1,2)                 , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array(1,'foo')             , array(1,'foo')             , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array(1, null)             , array(1, null)             , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array(null, 5, 2, 'foo', ) , array(null, 5, 2, 'foo', ) , true  , null),
            
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array(4)                   , array(4)                   , false , new ErrorException('test-field', '', "[{0}] is not included in [{1}]")),
            array(new Validator(array(5,2,'foo', 1.0, null))      ,array(4, 'foo')            , array(4, 'foo')            , false , new ErrorException('test-field', '', "[{0}] is not included in [{1}]")),
            array(new Validator(array(5,2,'foo', 1.0, null))      , null                 , null                  , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null))      , false                , false                 , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null))      , true                 , true                  , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null))      , ''                   , null                  , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null))      , '     '              , '     '               , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null))      , 'null'               , 'null'                , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null))      , '#null#'             , '#null#'              , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null))      , 'false'              , 'false'               , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null))      , 'true'               , 'true'                , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null))      , 'foo'                , 'foo'                 , false , new ErrorException('test-field', '', "{0} is not an array")),
            //-
            array(new Validator(array(5,2,'foo', 1.0, null), true),array()                    , array()                    , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true),array(1.0)                 , array(1.0)                 , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true),array(5)                   , array(5)                   , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true),array('foo')               , array('foo')               , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true),array(null)                , array(null)                , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true),array(1.0,5)               , array(1.0,5)               , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true),array(1.0,2)               , array(1.0,2)               , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true),array(1.0,'foo')           , array(1.0,'foo')           , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true),array(1.0, null)           , array(1.0, null)           , true  , null),
            array(new Validator(array(5,2,'foo', 1.0, null), true),array(null,5,2,'foo',1.0)  , array(null,5,2,'foo',1.0)  , true  , null),
            //-
            array(new Validator(array(5,2,'foo', 1.0, null), true),array(1)                   , array(1)                   , false , new ErrorException('test-field', '', "[{0}] is not included in [{1}]")),
            array(new Validator(array(5,2,'foo', 1.0, null), true),array(4)                   , array(4)                   , false , new ErrorException('test-field', '', "[{0}] is not included in [{1}]")),
            array(new Validator(array(5,2,'foo', 1.0, null), true),array(4, 'foo')            , array(4, 'foo')            , false , new ErrorException('test-field', '', "[{0}] is not included in [{1}]")),
            array(new Validator(array(5,2,'foo', 1.0, null), true), null                 , null                  , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null), true), false                , false                 , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null), true), true                 , true                  , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null), true), ''                   , null                  , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null), true), '     '              , '     '               , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null), true), 'null'               , 'null'                , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null), true), '#null#'             , '#null#'              , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null), true), 'false'              , 'false'               , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null), true), 'true'               , 'true'                , false , new ErrorException('test-field', '', "{0} is not an array")),
            array(new Validator(array(5,2,'foo', 1.0, null), true), 'foo'                , 'foo'                 , false , new ErrorException('test-field', '', "{0} is not an array")),
        );

        return $data;
    }

}
