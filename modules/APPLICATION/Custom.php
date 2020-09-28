<?php


namespace APPLICATION\Custom;

require_once __DIR__ . '/../../layers/RequestValidation.php';

use GlobalCommon\DataValidation;
use GlobalCommon\IDataValidation;

final class Credential extends DataValidation implements IDataValidation
{
    public $username = null;
    public $password = null;

    // private $SessionID = null;


    public function isValid(): bool
    {
        // TODO: Implement isValid() method.
        return true;
    }


}

