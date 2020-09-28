<?php

// require_once '../modules/ELEMENTARY/Model.php';
namespace LayerCRUD {


    use GlobalCommon\IDataControl;
    use IO\ResponseProcess;
    use Layer\Messaging\ResponseMessage;

    class CRUDController
    {

        public              $module;
        public              $controller;
        public              $action;
        public              $request;
        public IDataControl $model;

        function __construct(string $_path, object $_request)
        {
            $path             = explode("/", $_path);
            $this->request    = $_request;
            $this->module     = strtoupper($path[1]);
            $this->controller = $path[2];
            $this->action     = strtolower($path[3]);

            $this->process();
        }

        private function process(): void
        {
            $class       = $this->module . DIRECTORY_SEPARATOR . 'Model' . DIRECTORY_SEPARATOR . $this->controller;
            $this->model = new $class();
            $this->isCallableValidation($this->model, $this->action);
            $this->model->copyValuesFrom($this->request);
            if ($this->model->isValid()) {
                $this->model->{$this->action}();
            } else {
                $responseMessage = new ResponseMessage();
                $responseMessage->setTitle('ERROR');
                $response = new ResponseProcess();
                $response->setResponseMessage($responseMessage);
                $response->throwError();
            }

        }

        private function isCallableValidation(object $_model, string $_action): void
        {
            if (!is_callable(array($_model, $_action))) {
                $responseMessage = new ResponseMessage();
                $responseMessage->setTitle('ERROR');
                $response = new ResponseProcess();
                $response->setResponseMessage($responseMessage);
                $response->throwError();
                die();
            }
        }
    }

}
