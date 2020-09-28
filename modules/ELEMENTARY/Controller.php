<?php

namespace ELEMENTARY\Controller {


    require_once __DIR__ . '/../../layers/DataHub.php';
    require_once __DIR__ . '/../../layers/DataFormatter.php';
    require_once __DIR__ . '/../../modules/APPLICATION/Custom.php';
    require_once __DIR__ . '/../../modules/ELEMENTARY/Model.php';

    use DataHub;
    use ELEMENTARY\Model\User;
    use Layer\DataFormatter\FormatCriteriaItemList;
    use Layer\Messaging\Request;
    use Layer\Messaging\Response;

    class Handshake
    {
        private Request $Request;

        public function __construct(Request $_Request)
        {
            $this->Request = $_Request;

        }

        final public function userLogin(): void
        {
            // $dataFromStorage = $this->processRequest();

            // $this->isValid(); // TODO napraviti validaciju

            // $this->processResponse($dataFromStorage);
            //  var_dump('3223');
        }

        final public function processRequest(): array
        {
            return $this->list();
        }

        final public function list(): array
        {

            $formatCriteria   = new FormatCriteriaItemList();
            $criteriaItemList = $formatCriteria->requestScraper($this->Request);
            $dataHub          = new DataHub\Repository('APPLICATION', 'User', 'list', $this->Request);
            $storage_list     = $dataHub->list($criteriaItemList);

            $modelList = array();
            foreach ($storage_list as $listItem) {
                $user = new User();
                $user->copyValuesFrom($listItem);
                $modelList[] = $user;
            }
            return $modelList;
        }


        // final public function processResponse<T>(T $_Data): void   ***** ovako nešto

        final public function processResponse($_Data): void
        {
            $Response = new Response();
            $Response->responseSetter($_Data);
            $Response->send();
        }

        final public function read(): object
        {
            /* // $dataHub = new DataHub\Application\Repository('APPLICATION', 'Handshake', 'read', $_Request);
             $dataHub = new DataHub\Repository('APPLICATION', 'User', 'read', $_Request);
             return $dataHub->read();*/
        }


    }


}
