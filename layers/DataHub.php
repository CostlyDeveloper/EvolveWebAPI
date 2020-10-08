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

    final public function dataHubCreate(array $_data, string $tableName): ?int
    {
        return $this->database->dbCreate($_data, $tableName);
    }

    final function dataHubRead(object $_data)
    {
        $this->database->dbRead($_data);
    }

    final function dataHubUpdate(object $_data)
    {
        $this->database->dbUpdate($_data);
    }

    final function dataHubDelete(object $_data)
    {
        $this->database->dbDelete($_data);
    }
}
