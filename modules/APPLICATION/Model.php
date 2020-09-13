<?php

namespace APPLICATION\Model {

    require_once __DIR__ . '/../../layers/DataHub.php';


    final class Credential implements \IDataControl
    {
        public $Username = null;
        public $Password = null;

        // private $SessionID = null;

        public function dataFetch(): ?bool
        {
            // TODO: Implement dataFetch() method.
            return null;
        }

        public function isValid(): bool
        {
            // TODO: Implement isValid() method.
            return true;
        }

        public function copyValuesFrom(object $_Data): Credential
        {

            foreach ($this as $key => $value) {

                if(property_exists($_Data, $key)){
                     $this->$key = $_Data->$key;
                }
            }

            return $this;
        }


    }
}
