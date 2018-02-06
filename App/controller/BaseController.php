<?php
/**
 * Created by PhpStorm.
 * User: oluwapelumi.olaoye
 * Date: 1/29/18
 * Time: 3:37 PM
 */

namespace App\Controller;

use App\Constants\ResponseCodes;
use App\Constants\ResponseMessages;
use Phalcon\Mvc\Controller;
use Phalcon\DI;

class BaseController extends Controller implements \IJSend
{

    /**
     * Language variable that aids language switching to error/success reporting
     *
     * @var $language
     */
    protected $language;

    /**
     * Global events manager that is used to manage and fire events globally
     *
     * @var $eventsManager
     */
    protected $eventsManager;

    /**
     * Global config variable
     *
     * @var $config
     */
    protected $config;

    public function onConstruct()
    {
        $this->response->setContentType('application/json');
        $this->language = DI::getDefault()->get('language');

        $this->config = DI::getDefault()->get('config');

        $this->eventsManager = DI::getDefault()->get('eventsManager');

        $this->setEventsManager($this->eventsManager);
    }



    /**
     * Send a fail response if an API call failed
     *
     * @param     $data
     * @param int $http_status_code
     */
    public function sendFail($data, $http_status_code = 500)
    {
        $this->response->setStatusCode($http_status_code, \HttpStatusCodes::getMessage($http_status_code))
            ->sendHeaders();

        $this->response->setJsonContent([
            'status' => 'fail',
            'data'   => $data,
        ]);

        if (!$this->response->isSent()) {
            $this->response->send();
        }
    }

    /**
     * Send an error response if an API call failed
     *
     * @param      $message
     * @param      $error_code
     * @param int $http_status_code
     * @param null $data
     */
    public function sendError($message, $error_code, $http_status_code = 500, $data = null)
    {
        $message = $this->language->getMessages($error_code) ? $this->language->getMessages($error_code) : $message;

        if (is_array($message)) {
            $message = $message['message'];
        }

        $response = [
            'status' => 'error',
            'message' => $message,
            'code' => $error_code,
        ];

        if (!is_null($data)) {
            $response['data'] = $data;
        }

        $this->response->setStatusCode($http_status_code, \HttpStatusCodes::getMessage($http_status_code))
            ->sendHeaders();
        $this->response->setJsonContent($response);

        if (!$this->response->isSent()) {
            $this->response->send();
        }
        exit;
    }

    /**
     * Send a success response if an API call was successful
     *
     * @param $data
     */
    public function sendSuccess($data)
    {
        // TODO: Implement sendSuccess() method.
        $this->response->setStatusCode(200, \HttpStatusCodes::getMessage(200))->sendHeaders();

        $this->response->setJsonContent([
            'status' => 'success',
            'data'   => $data,
        ]);

        if (!$this->response->isSent()) {
            $this->response->send();
        }
    }

    /**
     * @param $data
     * @param $parameters
     * @param bool $sendError
     * @param bool $returnArray
     * @return bool|array
     */
    protected function validateParameters($data, $parameters, $sendError = true, $returnArray = false)
    {
        $validated = \GUMPHelper::is_valid((array)$data, $parameters);

        if ($validated !== true ) {

            if($sendError) {
                $messageList = \Utils::stripHtmlTags($validated);
                $message = implode(',', $messageList);
                $this->sendError(sprintf(ResponseMessages::INVALID_PARAMS, $message), ResponseCodes::INVALID_PARAMS, 400,
                    $messageList);
            }

            if ($returnArray) {
                $messageList = Utils::stripHtmlTags($validated);
                $message = implode(',', $messageList);
                return ['status' => false, 'message' => $message, 'code' => ResponseCodes::INVALID_PARAMS];
            }

            return false;
        }

        return true;
    }
}