<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\RegexValidator as Validator,
    Quartz\Component\FormValidator\Exceptions\ErrorException as ErrorException

;

/**
 * Description of RegexValidator
 *
 * @author paul
 */
class RegexValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new Validator('.*');
    }

    public function sanatizedDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator('.*'), array()     , array()   , false, null),
            array(new Validator('.*'), array(1)    , array(1)  , false, null),
            array(new Validator('.*'), false       , false     , false, null),
            array(new Validator('.*'), true        , true      , false, null),
            array(new Validator('.*'), 1234        , 1234      , false, null),
            //-
            array(new Validator('.*'), ''          , ''        , true, null),
            array(new Validator('.*'), null        , null      , true, null),
            array(new Validator('.*'), '     '     , '     '   , true, null),
            array(new Validator('.+'), '     '     , '     '   , true, null),
            array(new Validator('.*'), '0'         , '0'       , true, null),
            array(new Validator('[0-9]+'), '0'     , '0'       , true, null),
            array(new Validator('.+'), 'null'      , 'null'    , true, null),
            array(new Validator('#null#'), '#null#', '#null#'  , true, null),
            array(new Validator('.+'), 'null'      , 'null'    , true, null),
            array(new Validator('.+'), 'false'     , 'false'   , true, null),
            array(new Validator('.+'), 'true'      , 'true'    , true, null),
            array(new Validator('.+'), 'foo'       , 'foo'     , true, null),
            array(new Validator('.+'), ''          , ''        , true, null),
            array(new Validator('.+'), null        , null      , true, null),
            array(new Validator('.{0,}'), "\n"     , "\n"      , true, null),
        );

        return $data;
    }
    
    public function checkDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator('^.*$'), array()     , array()   , false, null),
            array(new Validator('^.*$'), array(1)    , array(1)  , false, null),
            array(new Validator('^.*$'), false       , false     , false, null),
            array(new Validator('^.*$'), true        , true      , false, null),
            array(new Validator('^.*$'), 1234        , 1234      , false, null),
            //-
            array(new Validator('^.*$'), ''          , ''        , true, null),
            array(new Validator('^.*$'), null        , null      , true, null),
            array(new Validator('^.*$'), '     '     , '     '   , true, null),
            array(new Validator('^.+$'), '     '     , '     '   , true, null),
            array(new Validator('^.*$'), '0'         , '0'       , true, null),
            array(new Validator('^[0-9]+$'), '0'     , '0'       , true, null),
            array(new Validator('^.+$'), 'null'      , 'null'    , true, null),
            array(new Validator('^#null#$'), '#null#', '#null#'  , true, null),
            array(new Validator('^.+$'), 'null'      , 'null'    , true, null),
            array(new Validator('^.+$'), 'false'     , 'false'   , true, null),
            array(new Validator('^.+$'), 'true'      , 'true'    , true, null),
            array(new Validator('^.+$'), 'foo'       , 'foo'     , true, null),
            array(new Validator('^.+$'), ''          , ''        , true, new ErrorException('test-field', '', "'{0}' does not match {1}")),
            array(new Validator('^.+$'), null        , ''        , true, new ErrorException('test-field', null, "'{0}' does not match {1}")),
            array(new Validator('^.{0,}$'), "\n"     , ""        , true, null),
            //-
            array(new Validator('^.{1,}$'), array()     , array()   , false, null),
            array(new Validator('^.{1,}$'), array(1)    , array(1)  , false, null),
            array(new Validator('^.{1,}$'), false       , false     , false, null),
            array(new Validator('^.{1,}$'), true        , true      , false, null),
            array(new Validator('^.{1,}$'), 1234        , 1234      , false, null),
            //-
            array(new Validator('^.{1,4}$'), array()     , array()   , false, null),
            array(new Validator('^.{1,4}$'), array(1)    , array(1)  , false, null),
            array(new Validator('^.{1,4}$'), false       , false     , false, null),
            array(new Validator('^.{1,4}$'), true        , true      , false, null),
            array(new Validator('^.{1,4}$'), 1234        , 1234      , false, null),
            //-
            array(new Validator('^.{0,}$')  , "\n"              , ''        , true, null),
            array(new Validator('^.{1,4}$') , "foo\n"           , "foo"     , true, null),
            array(new Validator('^.{0,}$')  , "foo\nbar"        , "foo\nbar", false, new ErrorException('test-field', '', "'{0}' does not match {1}")),
            array(new Validator('^.{1,}$')  , "\n"              , "\n"      , false, new ErrorException('test-field', '', "'{0}' does not match {1}")),
            array(new Validator('^.{1,4}$') , "\n"              , "\n"      , false, new ErrorException('test-field', '', "'{0}' does not match {1}")),

        );

        return $data;
    }

}
