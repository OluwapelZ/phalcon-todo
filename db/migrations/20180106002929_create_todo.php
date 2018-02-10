<?php

use Phinx\Db\Adapter\MysqlAdapter;
use Phinx\Migration\AbstractMigration;

/**
 * Created by PhpStorm.
 * User: oluwapelumi.olaoye
 * Date: 2/5/18
 * Time: 6:59 PM
 */
class CreateTodo extends AbstractMigration {

    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $this->table('Todo', ['id' => false, 'primary_key' => 'todo_id'])
            ->addColumn('todo_id', 'integer', ['limit' => 11, 'identity' => true, 'signed' => false])
            ->addColumn('title', 'string', ['limit' => 10])
            ->addColumn('description', 'string', ['limit' => 10, 'null' => true])
            ->create();
    }


}