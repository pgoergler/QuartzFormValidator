<?php

namespace Quartz\Component\FormValidator\tests\units\Validators;

use Quartz\Component\FormValidator\Validators\NullAsNotSetValidator as NullAsNotSet

;

/**
 * Description of NullAsNotSetValidator
 *
 * @author paul
 */
class NullAsNotSetValidator extends ValidatorTester
{

    public function createValidator()
    {
        return new NullAsNotSet();
    }
    
    public function sanatizedDataProvider()
    {
        $data = array(
            //  value, expected value, isset
            array(new NullAsNotSet(), null      , null      , false , null),
            array(new NullAsNotSet(), ''        , ''        , true  , null),
            array(new NullAsNotSet(), array()   , array()   , true  , null),
            array(new NullAsNotSet(), '     '   , '     '   , true  , null),
            array(new NullAsNotSet(), '0'       , '0'       , true  , null),
            array(new NullAsNotSet(), 'null'    , 'null'    , true  , null),
            array(new NullAsNotSet(), 'false'   , 'false'   , true  , null),
            array(new NullAsNotSet(), 'true'    , 'true'    , true  , null),
            array(new NullAsNotSet(), 'foo'     ,'foo'      , true  , null),
            array(new NullAsNotSet(), array(1)  , array(1)  , true  , null),
        );

        return $data;
    }

}
