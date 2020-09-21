<?php

namespace Layer\Messaging {


    use GlobalCommon\IDataControl\IDataValidation;

    class Response
    {
        public $SessionID;
        public $Response = null;
        public $Message;
        public $Code;
        public $Title;

        public function __construct()
        {
            /*  $this->SessionID = $_SessionID ? $_SessionID : null;
              $this->Response  = $_Response ? $_Response : null;
              $this->Message   = $_Message ? $_Message : null;*/
        }

        final public function responseSetter($_Data): void
        {
            $this->Response = $_Data;
        }

        final public function send(): string
        {

            // $this->returnJsonHttpResponse($this, $this->isValid());
            var_dump($this);
            return 'tmp';
        }

        private function returnJsonHttpResponse(object $_Data, bool $_Success): void
        {
            // remove any string that could create an invalid JSON
            // such as PHP Notice, Warning, logs...
            ob_clean();

            // this will clean up any previously added headers, to start clean
            /* if (!headers_sent()) {
                 foreach (headers_list() as $header)
                     header_remove($header);
             }*/

            // Set the content type to JSON and charset
            // (charset can be set to something else)
            header("Content-type: application/json; charset=utf-8");

            // Set your HTTP response code, 2xx = SUCCESS,
            // anything else will be error, refer to HTTP documentation
            if ($_Success) {
                http_response_code(200);
            } else {
                http_response_code(500);
            }

            // encode your PHP Object or Array into a JSON string.
            // stdClass or array

            echo json_encode($_Data);

            // making sure nothing is added
            exit();
        }

        private function isValid(): bool
        {
            // TODO: Implement isValid() method.
            return true;
        }
    }

    class Request implements IDataValidation
    {

        public $Request;
        public $SessionID;

        function __construct()
        {
        }

        final public function ValueSetter($_Data): void
        {

            $this->Request   = is_object($_Data->Request) ? $_Data->Request : null;
            $this->SessionID = is_object($_Data->SessionID) ? $_Data->SessionID : null;
        }

        final public function isValid(): bool
        {
            // TODO: Implement isValid() method.
            return true;
        }
    }

    class ResponseMessage
    {

        public $Code;
        public $Title;
        public $Message;

        public function __construct(string $_Code, string $_Title, string $_Message)
        {
            $this->Code    = $_Code ?: null;
            $this->Title   = $_Title ?: null;
            $this->Message = $_Message ?: null;
        }
    }
}
