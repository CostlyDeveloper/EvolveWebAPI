<?php

namespace MariaDB {
    require_once __DIR__ . '/../../layers/DataValidation.php';


    use GlobalCommon\CriteriaItem;
    use LAYER\DataValidation\StringValidation;
    use PDO;

    class Database
    {
        private static $host     = "127.0.0.1";
        private static $dbName   = "evolve_web_api";
        private static $username = "root";
        private static $password = "";
        private static $port     = "3307";

        public static function query(string $query, array $params = array())
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
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // vraća int ako je int u bazi
            return $pdo;
        }
    }

    class Actions extends Database
    {

        /*
         * @param CriteriaItem[] $_CriteriaItemList
         */
        // final public function list(string $_Module, string $_Controller, CriteriaItem ...$_CriteriaItemList): void
        final public function list(string $_Module, string $_Controller, array $_CriteriaItemList): array
        {

            $queryCriteria         = 'WHERE ';
            $layerStringValidation = new StringValidation();
            $params                = array();

            foreach ($_CriteriaItemList as $key => $criteriaItem) {
                if ($criteriaItem instanceof CriteriaItem) {
                    if ($criteriaItem->IsAND) {

                        if (!$layerStringValidation->endsWith($queryCriteria, 'WHERE ')) {
                            $queryCriteria = $queryCriteria . ' AND ';
                        }

                        // TODO napravti prepoznavanje ako je u kriteriji više istih propertija

                        $queryCriteria = $queryCriteria . ' ' . $criteriaItem->Property . ' = :' . $criteriaItem->Property . ' ';
                        $template      = array(':' . $criteriaItem->Property => $criteriaItem->Value);


                        $params = array_merge($params, $template);


                    } elseif ($criteriaItem->IsLIKE) {
                        // TODO
                    } elseif ($criteriaItem->IsIN) {
                        // TODO
                    } elseif ($criteriaItem->IsNULL) {
                        // TODO
                    }
                }

            } // foreach

            $queryString = "SELECT " . $_Module . "_" . $_Controller . ".* from " . $_Module . "_" . $_Controller . " " . $queryCriteria . "";

            return self::query($queryString, $params);


        }

    }

}

