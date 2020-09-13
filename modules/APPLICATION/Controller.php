<?php

namespace APPLICATION\Controller {


    require_once __DIR__ .'/../../layers/DataHub.php';
    require_once __DIR__ .'/../../layers/DataControl.php';

    use APPLICATION\Model\Credential;
    use DataHub;
    use Request;
    use Response;

    class Handshake
    {
        public $Credential;

        public function __construct()
        {
            $this->Credential = new Credential();
        }

        final public function UserLogin(Request $_Request): void
        {
            $this->Credential->copyValuesFrom($this->read($_Request));
            if($this->Credential->isValid()){
                // TODO get session ID
                $this->response($this->Credential);
            }

            // echo '<pre>', print_r($this->Credential), '</pre>';
        }

        private function response(object $_Data): void{
            $Response = new Response();
            $Response->responseSetter($_Data);
            $Response->send();
         }

        final public function read(Request $_Request): object
        {
            // $dataHub = new DataHub\Application\Repository('APPLICATION', 'Handshake', 'read', $_Request);
            $dataHub = new DataHub\Application\Repository('APPLICATION', 'Handshake', 'read', $_Request);
            return $dataHub->read($_Request);
        }
    }

}
