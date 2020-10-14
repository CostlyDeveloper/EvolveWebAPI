<?php

use GlobalCommon\IDatabaseActions;

class MySQL implements IDatabaseActions
{
    private static $host     = "127.0.0.1";
    private static $dbName   = "evolve_web_api";
    private static $username = "root";
    private static $password = "";
    private static $port     = "3307";


/*    private static function query(string $query, array $params = array())
    {
        $statemant = self::connect()->prepare($query);
        $statemant->execute($params);
        if (explode(' ', $query)[0] === 'SELECT') {
            $data = $statemant->fetchAll();
            // $data = $statemant->fetchObject();
            return $data;
        }
    }*/

    private static function connect(): PDO
    {
        $dataSourceName = "mysql:dbname=" . self::$dbName . ";port=" . self::$port . ";host=" . self::$host . ";charset=utf8";
        $pdo            = new PDO($dataSourceName, self::$username, self::$password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;
    }

    final public function dbActionCreate(array $_data, string $tableName): ?object
    {

        $columns_template = '(' . implode(', ', array_keys($_data)) . ')';
        $placeholders     = '(' . implode(', ', array_map(static function () {
                return '?';
            }, $_data)) . ')';
        $values           = array_map(static function ($value) {
            return $value;
        }, $_data, array_keys($_data));

        try {
            $pdo       = self::connect();
            $query     = "INSERT INTO $tableName $columns_template VALUES $placeholders";
            $statement = $pdo->prepare($query);
            $statement->execute($values);

            $_data['id'] = +$pdo->lastInsertId();
            return $this->dbActionRead($_data, $tableName);

        } catch (PDOException $exception) {
            // TODO make logger for errors
            // var_dump($exception->getMessage());
            return null;
        }
    }

    /** @noinspection SqlResolve */

    final public function dbActionUpdate(array $_data, string $tableName): ?object
    {
        $data = $_data;
        unset($_data['id']);
        $columns_template = implode('=?, ', array_keys($_data)) . '=?';
        $values           = array_map(static function ($value) {
            return $value;
        }, $_data, array_keys($_data));
        $values[]         = $data['id'];

        try {
            $pdo       = self::connect();
            $query     = "UPDATE $tableName SET $columns_template WHERE id=? LIMIT 1";
            $statement = $pdo->prepare($query);
            $statement->execute($values);

            return $this->dbActionRead($data, $tableName);

        } catch (PDOException $exception) {
            // TODO make logger for errors
            // var_dump($exception->getMessage());
            return null;
        }
    }

    /** @noinspection SqlResolve */
    final public function dbActionRead(array $_data, string $tableName): ?object
    {
        try {
            $pdo = self::connect();
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $query     = "SELECT * FROM $tableName WHERE id=? AND deleted_user_id IS NULL";
            $statement = $pdo->prepare($query);
            $statement->execute([$_data['id']]);
            return $statement->fetch();

        } catch (PDOException $exception) {
            // TODO make logger for errors
            // var_dump($exception->getMessage());
            return null;
        }
    }

    /** @noinspection SqlResolve */
    final public function dbActionDelete(array $_data, string $tableName): ?object
    {

        $columns_template = implode('=? AND ', array_keys($_data)) . '=?';
        $values           = array_map(static function ($value) {
            return $value;
        }, $_data, array_keys($_data));

        try {
            $pdo   = self::connect();
            $query = "UPDATE $tableName SET deleted_user_id=1 WHERE $columns_template LIMIT 1";

            $statement = $pdo->prepare($query);
            $statement->execute($values);


            return $this->dbActionRead($_data, $tableName);

        } catch (PDOException $exception) {
            // TODO make logger for errors
            // var_dump($exception->getMessage());
            return null;
        }

    }

}
