<?php
/**
 * Created by PhpStorm.
 * User: oluwapelumi.olaoye
 * Date: 1/28/18
 * Time: 9:22 PM
 */

use Phalcon\Mvc\Micro\Collection as MicroCollection;

$user = new MicroCollection();

$user->setHandler('App\Controller\TodoController', true)
    ->setPrefix('/todo')
    ->post('/create', 'createTodo', 'add a new todo')
    ->get('/fetch', 'fetchTodo', 'fetch todo from db')
    ->post('/update', 'updateTodo', 'update todo in db')
    ->delete('/delete', 'deleteTodo', 'delete todo in db');

$app->mount($user);
