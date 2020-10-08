<?php


namespace Layer {

    require_once __DIR__ . '/../dependencies/IO.php';

    use IO\RequestProcess;

    class FileContentManagement
    {
        private $Request;
        private $FileContent;

        function __construct()
        {
            // $this->Request = new RequestProcess();
            $this->cors();
            $this->contentListener();
            // $this->setRequest();
        }

        private function cors(): void
        {

            if (
            !($_SERVER['REQUEST_METHOD'] === 'OPTIONS'
              || $_SERVER['REQUEST_METHOD'] === 'POST'
              || $_SERVER['REQUEST_METHOD'] === 'GET')
            ) die();

            // Allow from any origin
            if (isset($_SERVER['HTTP_ORIGIN'])) {
                // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
                // you want to allow, and if so:
                header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
                header('Access-Control-Allow-Credentials: true');
                header('Access-Control-Max-Age: 86400');    // cache for 1 day
            }

            // Access-Control headers are received during OPTIONS requests
            if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {

                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                    // may also be using PUT, PATCH, HEAD etc
                    header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");

                if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                    header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

                exit(0);
            }
        }

        private function contentListener(): void
        {
            $fileContent = file_get_contents('php://input');
            if ($fileContent) {
                $this->FileContent = json_decode($fileContent);
            }
        }

        final public function getFileContent(): ?object
        {

            if ($this->IsValid()) {
                return $this->FileContent;
            }

            return null;

            /* if ($this->IsValid()) {
                 $this->Request->valueSetter($this->FileContent);
             }*/
        }

        /*private function getRequest(): void
                {
                    if ($this->IsValid()) {
                        $this->Request->valueSetter($this->FileContent);
                    }
                }*/

        final public function getRequest(): ?RequestProcess
        {
            return $this->Request->IsValid() ? $this->Request : null;

            /*$encoded = json_encode($this->Request);
            return json_decode($encoded)*/

        }

        // TODO provjeriti ako je ovo potrebno

        private function IsValid(): bool
        {
            return is_object($this->FileContent) && is_object($this->FileContent->Request);
        }


    }
}
