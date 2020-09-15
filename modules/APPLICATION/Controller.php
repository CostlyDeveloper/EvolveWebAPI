<?php

namespace APPLICATION\Controller {


    require_once __DIR__ . '/../../layers/DataHub.php';
    require_once __DIR__ . '/../../layers/DataFormatter.php';
    require_once __DIR__ . '/../../modules/APPLICATION/Custom.php';

    use APPLICATION\Custom\Credential;
    use DataHub;
    use Layer\DataFormatter\FormatCriteriaItemList;
    use Layer\Messaging\Request;
    use Layer\Messaging\Response;

    class Handshake
    {
        public  $Credential;
        private $Request;

        public function __construct(Request $_Request)
        {
            $this->Credential = new Credential();
            $this->Request    = $_Request;
            $this->start();
        }

        final public function start(): void
        {

            $storage_list = $this->list();
            var_dump($storage_list);
            /*$this->Credential->copyValuesFrom($storage_object);
            if ($this->Credential->isValid()) {
                // TODO get session ID
                $this->response($this->Credential);
            }*/
        }

        final public function read(): object
        {
            /* // $dataHub = new DataHub\Application\Repository('APPLICATION', 'Handshake', 'read', $_Request);
             $dataHub = new DataHub\Repository('APPLICATION', 'User', 'read', $_Request);
             return $dataHub->read();*/
        }

        final public function list(): array
        {

            $formatCriteria   = new FormatCriteriaItemList();
            $criteriaItemList = $formatCriteria->requestScraper($this->Request);


            // $dataHub = new DataHub\Application\Repository('APPLICATION', 'Handshake', 'read', $_Request);
            // var_dump($_Request);


            $dataHub = new DataHub\Repository('APPLICATION', 'User', 'list', $this->Request);
            return $dataHub->list($criteriaItemList);
        }

        private function response(object $_Data): void
        {
            $Response = new Response();
            $Response->responseSetter($_Data);
            $Response->send();
        }

    }

}
