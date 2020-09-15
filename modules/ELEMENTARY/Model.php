<?php

namespace ELEMENTARY\Model {


    class Person
    {
        public $ID                 = null;
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
        public $ID        = null;
        public $title     = null;
        public $enum_name = null;
        public $is_active = null;
    }

}


