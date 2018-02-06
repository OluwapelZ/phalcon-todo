<?php

namespace App\Model;

use Phalcon\Mvc\Model;
use Phalcon\Exception;
use Phalcon\DI;
use Phalcon\Db;

/**
 * Class BaseModel
 * @author Adeyemi Olaoye <yemi@cottacush.com>
 */
class BaseModel extends Model
{
    /**
     * Language variable that aids language switching to error/success reporting
     * @var $language
     */
    protected $language;

    /**
     * This will hold the models manager for building queries
     * @var $modelsManager
     */
    protected static $modelsManager;

    /**
     * Global events manager that is used to manage and fire events globally
     * @var $eventsManager
     */
    protected $eventsManager;

    public function initialize()
    {
        $this->language = DI::getDefault()->get('language');

        $this->eventsManager = DI::getDefault()->get('eventsManager');

        $this->setEventsManager($this->eventsManager);

        self::$modelsManager = DI::getDefault()->get('modelsManager');

        $this->keepSnapshots(true);
    }

    public function onConstruct()
    {
        $this->setConnectionService('db');
    }

    /**
     * @param $sql
     * @return mixed
     */
    public static function fetchByRawSql($sql)
    {
        $di = DI::getDefault();
        $connection = $di['db'];
        $data = $connection->query($sql);
        $data->setFetchMode(Db::FETCH_ASSOC);
        return $data->fetchAll();
    }

    /**
     * @param $id
     * @return \Phalcon\Mvc\Model
     */
    public static function getById($id)
    {
        return self::findFirst([
            "id = :id:",
            "bind" => ["id" => trim($id)]
        ]);
    }

    /**
     * This is to get all value from table by fields
     *
     * Note:
     * $fields parameter is array of fields. E.g ['name', 'status']
     * $values parameter is array of values corresponding to the fields. E.g ['razaq', 'enabled']
     * $returnColumn parameter are columns to be returned.
     * $operator parameter (a string value): can either be AND or OR
     * @param array $fields
     * @param array $values
     * @param $operator
     *
     * @param null $returnColumn
     * @param bool $returnFirstMatch
     * @return mixed
     */
    public static function getByFields(
        array $fields,
        array $values,
        $operator,
        $returnColumn = null,
        $returnFirstMatch = false)
    {
        $columns = is_null($returnColumn) ? "*" : $returnColumn;
        $condition = "";
        $bind = [];

        if (sizeof($values) < sizeof($fields)) {
            return false;
        }

        $count = 0;
        foreach ($fields as $key => $field) {
            $count += 1;
            $bind["$field"] = $values[$key];
            if ($count >= sizeof($fields)) {
                $condition .= "$field = :$field:";
                break;
            }
            $condition .= "$field = :$field: $operator ";
        }
        if ($returnFirstMatch) {
            return self::findFirst([
                "columns" => $columns,
                $condition,
                "bind" => $bind
            ]);
        }
        return self::find([
            "columns" => $columns,
            $condition,
            "bind" => $bind
        ])->toArray();
    }

    /**
     * @return mixed
     */
    public static function modelsManager()
    {
        return \Phalcon\DI::getDefault()->get('modelsManager');
    }

    /**
     * This is to get all values from table by field
     *
     * Note: the return column are the field that will be fetch from the table.
     * @param $value
     * @param $field
     * @param $returnColumn
     * @param $status
     *
     * @return array \Phalcon\Mvc\Model
     */
    public static function getByField($value, $field, $returnColumn = null, $status = Status::ENABLED)
    {
        $columns = is_null($returnColumn) ? "*" : $returnColumn;
        $bind = empty($status) ? ["$field" => $value] : ["$field" => $value, 'status' => \Status::ENABLED];

        $condition = empty($status) ? "$field = :$field:" : "$field = :$field: AND status = :status:";
        return self::find([
            "columns" => $columns,
            $condition,
            "bind" => $bind
        ])->toArray();
    }

    /**
     * @param null $data
     * @param null $whiteList
     * @return bool
     * @throws \Phalcon\Exception
     */
    public function save($data = null, $whiteList = null)
    {
        if (!parent::save($data, $whiteList)) {
            $message = 'Error saving to the database. Check logs for detailed error.';
            if (!empty($this->getMessages())) {

                foreach ($this->getMessages() as $msg) {
                    $message .= "\n" . $msg;
                }
            }

            throw new Exception($message);
        }
        return true;
    }

    /**
     * @param $modelObject
     * @return \Phalcon\Mvc\Model|bool
     */
    public function saveData($modelObject, $filterColumn = [])
    {
        try {

            $this->setValueToField($modelObject, $filterColumn);
            $this->save();

            return $this->refresh();

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param $data
     * @param array $filter
     */
    public function setValueToField($data, $filter = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && !in_array($key, $filter)) {
                $this->$key = $value;
            }
        }
    }

} 