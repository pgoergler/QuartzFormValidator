<?php

namespace Quartz\Component\FormValidator\Exceptions;

/**
 * Description of ErrorException
 *
 * @author paul
 */
class ErrorException extends InvalidFieldValueException
{

    public function shouldStopValidation()
    {
        return true;
    }

}
