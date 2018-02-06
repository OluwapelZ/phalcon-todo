<?php
/**
 * Created by PhpStorm.
 * User: oluwapelumi.olaoye
 * Date: 2/2/18
 * Time: 7:59 PM
 */

interface IJSend
{

    public function sendSuccess($data);
    public function sendError($message, $code, $data = null);
    public function sendFail($data);
}