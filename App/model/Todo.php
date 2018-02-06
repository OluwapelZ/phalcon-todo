<?php
/**
 * Created by PhpStorm.
 * User: oluwapelumi.olaoye
 * Date: 2/3/18
 * Time: 11:54 AM
 */

use Phalcon\Mvc\Model\Query\Builder as QueryBuilder;
use \App\Model\BaseModel;

class Todo extends BaseModel
{
    public function initialize()
    {
        parent::initialize();

        $this->setSource('Todo');
    }

    /**
     * Create to-do
     *
     * @param $title
     * @param $description
     * @return mixed User|bool
     */
    public static function createTodo($title, $description) {
        $todo = new Todo();
        $todo->title = $title;
        $todo->description = $description;

        if ($todo->save()) {
           $todo->refresh();
           return $todo;
        }
        return false;
    }

    /**
     * Update to-do
     *
     * @param Todo $todo
     * @param $title
     * @param $description
     * @return mixed User|bool
     */
    public static function updateTodo($todo, $title, $description) {
        if(isset($title)) {
            $todo->title = $title;
        }
        if(isset($description)) {
            $todo->description = $description;
        }
        if($todo->save()) {
            $todo->refresh();
            return $todo;
        }
        return false;
    }

    /**
     * delete to-do
     * @param Todo $todo
     * @return bool
     */
    public static function deleteTodo($todo) {
        return $todo->delete();
    }

    /**
     * Get to-do by id
     * @param $id
     * @return mixed array|bool
     */
    public static function fetchTodo($id) {
        $builder = new QueryBuilder();
        $builder
            ->from(['t' => '\Todo'])
            ->columns([
                'title' => 't.title',
                'description' => 't.description'
            ]);
        $builder
            ->where('t.todo_id = :todoId:', ['todoId' => $id])
            ->orderBy('t.created_at DESC');

        $todo = $builder->getQuery()->execute()->toArray();

        return $todo;
    }

    /**
     * Get
     */
}