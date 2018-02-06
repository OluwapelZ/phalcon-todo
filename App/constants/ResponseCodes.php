<?php

namespace App\Constants;

use PhalconUtils\Constants\ResponseCodes as PhalconUtilsResponseCodes;

/**
 * Class ResponseCodes
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 * @package App\Library
 */
class ResponseCodes extends PhalconUtilsResponseCodes
{
    const INVALID_PARAMS    = 'E0004';
    const FIELD_CAN_NOT_BE_EMPTY    = 'E0264';
    const INTERNAL_SERVER_ERROR = 'E0003';
}
