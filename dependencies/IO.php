<?php

namespace IO {

    require_once __DIR__ . '/../dependencies/GlobalCommon.php';

    use GlobalCommon\IDataValidation;
    use Layer\Messaging\ResponseMessage;

    class RequestProcess implements IDataValidation
    {

        public $Request;
        public $SessionID;

        function __construct()
        {
        }

        final public function valueSetter($_Data): void
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

    class ResponseProcess
    {
        public         $SessionID = null;
        public         $Response  = null;
        public ?string $Message   = null;
        public ?string $Code      = null;
        public ?string $Title     = null;

        public function __construct()
        {
        }

        final public function responseSetter($_Data = null): void
        {
            $this->Response = $_Data;
        }

        final public function send(): string
        {
            $this->returnJsonHttpResponse($this, $this->isValid());
            // var_dump($this);
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
            return $this->Response !== null;
        }

        final public function throwError(string $_title = '', string $_message = '', string $_code = ''): void
        {
            $responseMessage = new ResponseMessage();
            $responseMessage->setTitle($_title);
            $responseMessage->setMessage($_message);
            $responseMessage->setCode($_code);
            $this->setResponseMessage($responseMessage);

            // $this->returnJsonHttpResponse($this, false);
        }

        final public function setResponseMessage(ResponseMessage $_responseMessage): void
        {
            $this->Message = $_responseMessage->Message;
            $this->Code    = $_responseMessage->Code;
            $this->Title   = $_responseMessage->Title;
        }
    }

}
