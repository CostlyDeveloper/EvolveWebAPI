<?php

namespace LayerCRUD {

    require_once __DIR__ . '/../storage/mysql/MySQL.php';

    use DataHub;
    use GlobalCommon\BasicModel;
    use IO\RequestProcess;
    use IO\ResponseProcess;
    use MySQL;

    class CRUDController
    {

        public string                             $module;
        public string                             $controller;
        public string                             $action;
        public RequestProcess                     $request;
        public ResponseProcess                    $response;
        public BasicModel                         $model;

        function __construct(string $_path, RequestProcess $_request, ResponseProcess $_response)
        {
            $path             = explode("/", $_path);
            $this->request    = $_request;
            $this->response   = $_response;
            $this->module     = strtoupper($path[1]);
            $this->controller = $path[2];
            $this->action     = strtolower($path[3]);

            $this->process();
        }

        private function process(): void
        {
            // let's put it together class path, it must match with namespace namespace MODULE_NAME\Model it is placed /modules/MODULE_NAME/Model.php - and the class name in file
            $class       = $this->module . DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR . $this->controller;
            $this->model = new $class();
            // it checks the action(method) is exposed or not / private or public
            $this->isCallableValidation($this->model, $this->action);
            // make sure that we filter and validate only data in request that fit to our own object
            $this->model->copyValuesFrom($this->request->Request);

            // every model validate itself
            if ($this->model->isValid()) {

                $dataHub = new DataHub();

                // TODO napraviti više opcija tj. više različitih tehnologija baza koje će se priključiti na solution
                $dataHub->setDatabase(new MySQL());

                $modelDataResponse = $this->model->{$this->action}($dataHub);
                if ($modelDataResponse) {
                    $this->response->setResponseMessage('OK');
                    $this->response->sendResponse($modelDataResponse);
                } else {
                    $this->response->throwError('ERROR', 'Request error.');
                }

            } else {
                $this->response->throwError('ERROR', 'Request validation error.');
            }

        }

        private function isCallableValidation(object $_model, string $_action): void
        {
            if (!is_callable(array($_model, $_action))) {
                $this->response->throwError('ERROR', 'Action not exist.');
                die();
            }
        }
    }

}
