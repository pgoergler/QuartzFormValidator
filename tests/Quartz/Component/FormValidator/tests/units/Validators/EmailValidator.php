<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\EmailValidator as Validator,
    Quartz\Component\FormValidator\Exceptions\ErrorException as ErrorException

;

/**
 * Description of EmptyAsNotSetValidator
 *
 * @author paul
 */
class EmailValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new Validator();
    }

    public function sanatizedDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator(), null             , null              , true  , null),
            array(new Validator(), 'foo@foo.com'    , 'foo@foo.com'     , true  , null),
            array(new Validator(), 'foo@foo.co.uk'  , 'foo@foo.co.uk'   , true  , null),
            array(new Validator(), ''               , ''                , true  , null),
            array(new Validator(), '     '          , '     '           , true  , null),
            array(new Validator(), 'null'           , 'null'            , true  , null),
            array(new Validator(), '#null#'         , '#null#'          , true  , null),
            array(new Validator(), 'false'          , 'false'           , true  , null),
            array(new Validator(), 'true'           , 'true'            , true  , null),
            array(new Validator(), 'foo'            , 'foo'             , true  , null),
            //-
            array(new Validator(), array()          , array()           , false , null),
            array(new Validator(), array(1)         , array(1)          , false , null),
            array(new Validator(), false            , false             , false , null),
            array(new Validator(), true             , true              , false , null),
            
        );

        return $data;
    }
    
    public function checkDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new Validator(), null             , null              , true  , null),
            array(new Validator(), 'foo@foo.com'    , 'foo@foo.com'     , true  , null),
            array(new Validator(), 'foo@foo.co.uk'  , 'foo@foo.co.uk'   , true  , null),
            array(new Validator(), ''               , ''                , true  , null),
            //-
            array(new Validator(), array()          , array()           , false , null),
            array(new Validator(), array(1)         , array(1)          , false , null),
            array(new Validator(), false            , false             , false , null),
            array(new Validator(), true             , true              , false , null),
            array(new Validator(), '     '          , '     '           , false , new ErrorException('test-field', '', "you must set a valid email")),
            array(new Validator(), 'null'           , 'null'            , false , new ErrorException('test-field', '', "you must set a valid email")),
            array(new Validator(), '#null#'         , '#null#'          , false , new ErrorException('test-field', '', "you must set a valid email")),
            array(new Validator(), 'false'          , 'false'           , false , new ErrorException('test-field', '', "you must set a valid email")),
            array(new Validator(), 'true'           , 'true'            , false , new ErrorException('test-field', '', "you must set a valid email")),
            array(new Validator(), 'foo'            , 'foo'             , false , new ErrorException('test-field', '', "you must set a valid email")),
            
        );

        return $data;
    }

}
