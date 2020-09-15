<?php

namespace APPLICATION\Model {

    require_once __DIR__ . '/../../dependencies/GlobalCommon.php';

    use GlobalCommon\IDataControl\IDataValidation;

    class User implements IDataValidation
    {

        public $ID        = null;
        public $person_ID = null;
        public $username  = null;
        public $password  = null;
        public $is_active = null;


        public function isValid(): bool
        {
            // TODO: Implement isValid() method.
            return true;
        }


    }
}
