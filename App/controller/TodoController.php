<?php
/**
 * Created by PhpStorm.
 * User: oluwapelumi.olaoye
 * Date: 2/3/18
 * Time: 2:40 PM
 */

namespace App\Controller;

use App\Constants\ResponseCodes;
use App\Constants\ResponseMessages;
use Todo;

class TodoController extends BaseController
{
    /**
     * Function to create todo
     */
    public function createTodo()
    {
        $data = $this->request->getJsonRawBody();

        $this->validateParameters($data,
            [
                'title' => 'required',
                'description' => 'required'
            ]);

        if(empty($data->title) || empty($data->description)) {
            $this->sendError(ResponseMessages::FIELD_CAN_NOT_BE_EMPTY, ResponseCodes::FIELD_CAN_NOT_BE_EMPTY, 400);
        }

        $response = Todo::createTodo($data->title, $data->description);

        if(!$response) {
            $this->sendError(ResponseMessages::INTERNAL_SERVER_ERROR, ResponseCodes::INTERNAL_SERVER_ERROR, 500);
        }

        $this->sendSuccess(null);
    }

    /**
     * Function to fetch to update todo in db
     */
    public function updateTodo()
    {
        $data = $this->request->getJsonRawBody();

        $this->validateParameters($data,
            [
                'title' => 'required',
                'description' => 'required'
            ]);
    }

    /**
     * Function to fetch existing todo
     * @param $id
     */
    public function fetchTodo($id) {

    }

    /**
     * Function to delete todo from db
     * @param $id
     */
    public function deleteTodo($id) {

    }

}