<?php

namespace ELEMENTARY\Model {

    require_once __DIR__ . '/../../dependencies/CRUDController.php';

    use GlobalCommon\DataValidation;
    use GlobalCommon\IDataControl;

    class Person
    {
        public $id                 = null;
        public $gender_category_id = null;
        public $name               = null;
        public $middle_name        = null;
        public $surname            = null;
        public $birth_date         = null;
        public $identification     = null;
        public $is_active          = null;
    }

    class GenderCategory
    {
        public $id        = null;
        public $title     = null;
        public $enum_name = null;
        public $is_active = null;
    }

    class User extends DataValidation implements IDataControl
    {

        public ?int    $ID             = null;
        public ?int    $PersonID       = null;
        public ?int    $UserCategoryID = null;
        public ?bool   $IsActive       = null;

        public function isValid(): bool
        {
            // TODO: Implement isValid() method.
            return true;
        }


        function create()
        {
            // var_dump('TODO: Implement create() method.');


            var_dump($this);
            // TODO: Implement create() method.
        }

        function remove()
        {
            var_dump('TODO: Implement remove() method.');
            // TODO: Implement remove() method.
        }

        function update()
        {
            var_dump('TODO: Implement update() method.');
            // TODO: Implement update() method.
        }

        function delete()
        {
            var_dump('TODO: Implement delete() method.');
            // TODO: Implement delete() method.
        }
    }

}


