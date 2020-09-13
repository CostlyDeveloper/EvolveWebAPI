<?php
require_once '../dependencies/IDataControl.php';

class FileContentManagement
{
    private $Request;
    private $FileContent;

    function __construct()
    {
        $this->Request = new Request();
        $this->cors();
        $this->contentListener();
        $this->setRequest();
    }

    private function cors()
    {

        if (
            $_SERVER['REQUEST_METHOD'] === 'OPTIONS'
            || $_SERVER['REQUEST_METHOD'] === 'POST'
            || $_SERVER['REQUEST_METHOD'] === 'GET'
        ) {
        } else
            die();

        // Allow from any origin
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            // Decide if the origin in $_SERVER['HTTP_ORIGIN'] is one
            // you want to allow, and if so:
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');    // cache for 1 day
        }

        // Access-Control headers are received during OPTIONS requests
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                // may also be using PUT, PATCH, HEAD etc
                header("Access-Control-Allow-Methods: GET, POST, PUT, OPTIONS");

            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

            exit(0);
        }
    }

    private function contentListener()
    {
        $fileContent = file_get_contents('php://input');
        if ($fileContent) {
            $this->FileContent = json_decode($fileContent);
        }
    }

    private function setRequest()
    {
        if ($this->IsValid()) {
            $this->Request->ValueSetter($this->FileContent);
        }
    }

    private function IsValid()
    {
        return is_object($this->FileContent) && is_object($this->FileContent->Request);
    }

    public function getRequest()
    {
        return $this->Request->IsValid() ? $this->Request : null;

        /*$encoded = json_encode($this->Request);
        return json_decode($encoded)*/

    }


}


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

    final public function responseSetter(object $_Data): void
    {
        $this->Response = $_Data;
    }

    final public function send(): string
    {

        $this->returnJsonHttpResponse($this, $this->isValid());
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

class ResponseMessage
{

    public $Code;
    public $Title;
    public $Message;

    function __construct($_Code, $_Title, $_Message)
    {
        $this->Code    = $_Code ? $_Code : null;
        $this->Title   = $_Title ? $_Title : null;
        $this->Message = $_Message ? $_Message : null;
    }
}

class Request implements \IDataControl
{

    public $Request;
    public $SessionID;

    function __construct()
    {
    }

    function ValueSetter($_Data)
    {

        $this->Request   = is_object($_Data->Request) ? $_Data->Request : null;
        $this->SessionID = is_object($_Data->SessionID) ? $_Data->SessionID : null;
    }

    function isValid(): bool
    {
        // TODO: Implement isValid() method.
        return true;
    }
}

