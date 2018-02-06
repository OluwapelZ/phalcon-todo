<?php

namespace App\Constants;

use PhalconUtils\Constants\ResponseMessages as PhalconUtilsResponseMessages;

/**
 * Class ResponseMessages
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 * @package App\Library
 */
class ResponseMessages extends PhalconUtilsResponseMessages
{
    const INVALID_PARAMS    = '%s';
    const FIELD_CAN_NOT_BE_EMPTY    = 'This field can not be empty';
    const INTERNAL_SERVER_ERROR = "Technical issue: There seem to be an issue with the server, do you mind trying later?";

}