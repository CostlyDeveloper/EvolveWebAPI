<?php

namespace DataHub {
    class Tools
    {

        protected function actionValidator(string $_Action): bool
        {
            return $_Action == 'read';
        }
    }
}


namespace DataHub\Application {

    use DataHub\Tools;
    use JsonFetch;
    use Request;

    require_once 'storage-fetch/JsonFetch.php';

    class Repository extends Tools
    {
        private $Module     = null;
        private $Controller = null;
        private $Action     = null;
        private $Request    = null;
        private $Response   = null;


        function __construct(string $_Module, string $_Controller, string $_Action, Request $_Request)
        {
            $this->Module     = $_Module;
            $this->Controller = $_Controller;
            $this->Action     = $_Action;
            $this->Request    = $_Request;

        }

        final public function read(Request $_Request): object
        {
            if ($this->actionValidator($this->Action)) {
                if ($this->Action === 'read') {

                    $jsonArray = JsonFetch::fetchFromFile($this->Module, $this->Controller, $this->Action);

                    return json_decode(json_encode($jsonArray)); // pretvara array u objekt


                }
            }
        }

    }
}

