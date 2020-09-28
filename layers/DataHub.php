<?php


namespace DataHub {

    use JsonFetch;
    use Layer\Messaging\Request;
    use MariaDB\Actions;
    use MariaDB\Database;

    require_once 'storage-fetch/JsonFetch.php';
    require_once __DIR__ . '/storage-fetch/JsonFetch.php';
    require_once __DIR__ . '/../storage/maria-db/Database.php';

    class Repository
    {
        private $Module     = null;
        private $Controller = null;
        private $Action     = null;
        private $Request    = null;
        private $Response   = null;


        function __construct(string $_Module, string $_Controller, string $_Action, Request $_Request)
        {
            $this->Module     = strtolower($_Module);
            $this->Controller = strtolower($_Controller);
            $this->Action     = strtolower($_Action);
            $this->Request    = $_Request;

        }

        final public function read(): void
        {
            if ($this->Action === 'read') {
                // return $this->readFromJSON();
                // return $this->readFromMariaDB();

            }
        }

        // final public function list(CriteriaItem ...$_CriteriaItemList): array
        final public function list(array $_CriteriaItemList): array
        {
            if ($this->Action === 'list') {
                $mariaDB = new Actions();
                return $mariaDB->list($this->Module, $this->Controller, $_CriteriaItemList);

                // TODO napraviti da query prima kriteriju
                //  return $mariaDB::query("SELECT * from ". $this->Module."_". $this->Controller."");

            }
        }

        private function readFromJSON(): object
        {
            $jsonArray = JsonFetch::fetchFromFile($this->Module, $this->Controller, $this->Action);
            return json_decode(json_encode($jsonArray)); // pretvara array u objekt*/
        }

        private function readFromMariaDB(): void
        {
            $mariaDB = new Database();
            // TODO napraviti da query prima kriteriju
            //  return $mariaDB::query("SELECT * from ". $this->Module."_". $this->Controller."");
        }

    }
}

