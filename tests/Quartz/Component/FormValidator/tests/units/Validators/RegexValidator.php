<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\RegexValidator as RegexV,
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
        return new RegexV('.*');
    }

    public function sanatizedDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new RegexV('.*'), array()     , array()   , false, new \InvalidArgumentException("you must set a valid value")),
            array(new RegexV('.*'), array(1)    , array(1)  , false, new \InvalidArgumentException("you must set a valid value")),
            array(new RegexV('.*'), false       , false     , false, new \InvalidArgumentException("you must set a valid value")),
            array(new RegexV('.*'), true        , true      , false, new \InvalidArgumentException("you must set a valid value")),
            array(new RegexV('.*'), 1234        , 1234      , false, new \InvalidArgumentException("you must set a valid value")),
            //-
            array(new RegexV('.*'), ''          , ''        , true, null),
            array(new RegexV('.*'), null        , null      , true, null),
            array(new RegexV('.*'), '     '     , '     '   , true, null),
            array(new RegexV('.+'), '     '     , '     '   , true, null),
            array(new RegexV('.*'), '0'         , '0'       , true, null),
            array(new RegexV('[0-9]+'), '0'     , '0'       , true, null),
            array(new RegexV('.+'), 'null'      , 'null'    , true, null),
            array(new RegexV('#null#'), '#null#', '#null#'  , true, null),
            array(new RegexV('.+'), 'null'      , 'null'    , true, null),
            array(new RegexV('.+'), 'false'     , 'false'   , true, null),
            array(new RegexV('.+'), 'true'      , 'true'    , true, null),
            array(new RegexV('.+'), 'foo'       , 'foo'     , true, null),
            array(new RegexV('.+'), ''          , ''        , true, null),
            array(new RegexV('.+'), null        , null      , true, null),
            array(new RegexV('.{0,}'), "\n"     , "\n"      , true, null),
        );

        return $data;
    }
    
    public function checkDataProvider()
    {
        $data = array(
            //  $validator, value, expected value, isset, $exception
            array(new RegexV('^.*$'), array()     , array()   , false, new \InvalidArgumentException("you must set a valid value")),
            array(new RegexV('^.*$'), array(1)    , array(1)  , false, new \InvalidArgumentException("you must set a valid value")),
            array(new RegexV('^.*$'), false       , false     , false, new \InvalidArgumentException("you must set a valid value")),
            array(new RegexV('^.*$'), true        , true      , false, new \InvalidArgumentException("you must set a valid value")),
            array(new RegexV('^.*$'), 1234        , 1234      , false, new \InvalidArgumentException("you must set a valid value")),
            //-
            array(new RegexV('^.*$'), ''          , ''        , true, null),
            array(new RegexV('^.*$'), null        , null      , true, null),
            array(new RegexV('^.*$'), '     '     , '     '   , true, null),
            array(new RegexV('^.+$'), '     '     , '     '   , true, null),
            array(new RegexV('^.*$'), '0'         , '0'       , true, null),
            array(new RegexV('^[0-9]+$'), '0'     , '0'       , true, null),
            array(new RegexV('^.+$'), 'null'      , 'null'    , true, null),
            array(new RegexV('^#null#$'), '#null#', '#null#'  , true, null),
            array(new RegexV('^.+$'), 'null'      , 'null'    , true, null),
            array(new RegexV('^.+$'), 'false'     , 'false'   , true, null),
            array(new RegexV('^.+$'), 'true'      , 'true'    , true, null),
            array(new RegexV('^.+$'), 'foo'       , 'foo'     , true, null),
            array(new RegexV('^.+$'), ''          , ''        , true, new ErrorException('test-field', '', "'{0}' does not match {1}")),
            array(new RegexV('^.+$'), null        , ''        , true, new ErrorException('test-field', null, "'{0}' does not match {1}")),
            array(new RegexV('^.{0,}$'), "\n"     , ""        , true, null),
        );

        return $data;
    }

}
