<?php

namespace ELEMENTARY\Model {


    use GlobalCommon\DataControl\DataValidation;
    use GlobalCommon\IDataControl\IDataValidation;

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

    class User extends DataValidation implements IDataValidation
    {

        public      $id        = null;
        public ?int $person_ID = null;
        public      $username  = null;
        public      $password  = null;
        public      $is_active = null;

        public function isValid(): bool
        {
            // TODO: Implement isValid() method.
            return true;
        }


    }

}


