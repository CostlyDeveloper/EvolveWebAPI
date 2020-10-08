<?php

use GlobalCommon\IDatabaseActions;

class MySQL implements IDatabaseActions
{
    private static $host     = "127.0.0.1";
    private static $dbName   = "evolve_web_api";
    private static $username = "root";
    private static $password = "";
    private static $port     = "3307";

    /*public function dbCreate(array $_data, string $tableName)
    {

        //
        $columns      = '(' . implode(', ', array_keys($_data)) . ')';
        $placeholders = '(' . implode(', ', array_map(
                function ($value, $key) {
                    return sprintf(":%s", $key);
                },
                $_data,
                array_keys($_data)
            )) . ')';

        $pdo = self::connect();
        $query = "INSERT INTO $tableName $columns VALUES $placeholders";
        $statement = $pdo->prepare($query);
        $statement->execute($_data);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        $result2 = $pdo->lastInsertId();

        var_dump($result2);
        var_dump($result);

    }*/

    private static function query(string $query, array $params = array())
    {
        $statemant = self::connect()->prepare($query);
        $statemant->execute($params);
        if (explode(' ', $query)[0] === 'SELECT') {
            $data = $statemant->fetchAll();
            // $data = $statemant->fetchObject();
            return $data;
        }
    }

    private static function connect(): PDO
    {
        $dataSourceName = "mysql:dbname=" . self::$dbName . ";port=" . self::$port . ";host=" . self::$host . ";charset=utf8";
        $pdo            = new PDO($dataSourceName, self::$username, self::$password);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        /*        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);

                 // vraća int ako je int u bazi*/
        return $pdo;
    }

    public function dbCreate(array $_data, string $tableName)
    {

        //
        $columns      = '(' . implode(', ', array_keys($_data)) . ')';
        $placeholders = '(' . implode(', ', array_map(
                function () {
                    return '?';
                },
                $_data
            )) . ')';
        $values       = array_map(
            function ($value) {
                return $value;
            },
            $_data,
            array_keys($_data)
        );

        try {
            $pdo       = self::connect();
            $query     = "INSERT INTO $tableName $columns VALUES $placeholders";
            $statement = $pdo->prepare($query);
            $statement->execute($values);
            return +$pdo->lastInsertId();

        } catch (PDOException $exception) {
            // TODO make logger for errors
            // var_dump($exception->getMessage());
            return null;
        }
    }

    public function dbRead(object $_data)
    {

    }

    public function dbUpdate(object $_data)
    {

    }

    public function dbDelete(object $_data)
    {

    }

}
