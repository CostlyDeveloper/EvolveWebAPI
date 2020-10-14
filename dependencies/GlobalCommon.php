<?php

namespace GlobalCommon {

    require_once __DIR__ . '/../layers/Messaging.php';
    require_once __DIR__ . '/../layers/DataHub.php';

    // region *** Interface ***


    interface IDataValidation
    {
        public function isValid(): bool;
    }

    interface ICRUD
    {
        function create();

        function read();

        function update();

        function delete();
    }

    interface IDatabaseActions
    {
        public function dbActionCreate(array $_data, string $tableName): ?object;

        public function dbActionRead(array $_data, string $tableName): ?object;

        public function dbActionUpdate(array $_data, string $tableName): ?object;

        public function dbActionDelete(array $_data, string $tableName): ?object;
    }

    interface IDataHubActions
    {
        public function dataHubCreate(array $_data, string $tableName): ?object;

        public function dataHubRead(array $_data, string $tableName): ?object;

        public function dataHubUpdate(array $_data, string $tableName): ?object;

        public function dataHubDelete(array $_data, string $tableName): ?object;
    }

    interface IDataModify
    {
        public function copyValuesFrom(object $_Data);
    }

    interface IDataControl extends IDataValidation, IDataModify
    {
    }

    // endregion

    // region *** Class ***

    trait ModelBasicDataControl
    {

        final public function copyValuesFrom(object $_data): self
        {

            foreach ($this as $key => $value) {

                if (property_exists($_data, $key)) {
                    $this->$key = $_data->$key;
                } else if (property_exists($_data, strtolower($key))) {
                    $lowercaseKey = strtolower($key);
                    $this->$key   = $_data->$lowercaseKey;
                }
            }
            return $this;
        }

        // TODO prebaciti u layer
        private function snakeCaseToPascalCase(string $_string): string
        {
            return str_replace(array('_', 'Id'), array('', 'ID'), ucwords($_string, '_'));

        }


    }

    /*    abstract class DataValidation implements IDataModify
        {

            final public function copyValuesFrom(object $_data): self
            {

                foreach ($this as $key => $value) {

                    if (property_exists($_data, $key)) {
                        $this->$key = $_data->$key;
                    } else if (property_exists($_data, strtolower($key))) {
                        $lowercaseKey = strtolower($key);
                        $this->$key   = $_data->$lowercaseKey;
                    }
                }
                return $this;
            }

            // TODO prebaciti u layer
            private function snakeCaseToPascalCase(string $_string): string
            {
                return str_replace(array('_', 'Id'), array('', 'ID'), ucwords($_string, '_'));

            }


        }*/

    abstract class BasicModel
    {
        use ModelBasicDataControl;

        public function __construct()
        {

        }

    }

    /* class CriteriaItem extends DataValidation
     {
         public ?string $Property  = null;
         public ?string $Value     = null;
         public ?bool   $IsAND     = null;
         public ?bool   $IsLIKE    = null;
         public ?bool   $IsIN      = null;
         public ?bool   $IsNULL    = null;
         public ?bool   $IsBetween = null;
         public ?string $StartDate = null;
         public ?string $EndDate   = null;


         final public function sqlPrepare(object $_Data): self
         {
             $stringFormatter = new StringFormatter();

             foreach ($this as $key => $value) {

                 if (property_exists($_Data, $key)) {
                     if ($this->$key === 'Property') {
                         $this->$key = $stringFormatter->camel2dashed($_Data->$key);
                     } else {
                         $this->$key = $_Data->$key;
                     }

                 }
             }

             return $this;
         }

     }*/
    // endregion

}
