<?php

use GlobalCommon\IDatabaseActions;
use GlobalCommon\IDataHubActions;

class DataHub implements IDataHubActions
{
    protected IDatabaseActions $database;

    final public function setDatabase(IDatabaseActions $_database): void
    {
        $this->database = $_database;
    }

    final public function dataHubCreate(array $_data, string $tableName): ?object
    {
        return $this->database->dbActionCreate($_data, $tableName);
    }

    final public function dataHubRead(array $_data, string $tableName): ?object
    {
        return $this->database->dbActionRead($_data, $tableName);
    }

    final public function dataHubUpdate(array $_data, string $tableName): ?object
    {
        return $this->database->dbActionUpdate($_data, $tableName);
    }

    final public function dataHubDelete(array $_data, string $tableName): ?object
    {
        return $this->database->dbActionDelete($_data, $tableName);
    }
}
