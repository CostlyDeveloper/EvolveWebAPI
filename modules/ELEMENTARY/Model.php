<?php

namespace ELEMENTARY\Model {

    require_once __DIR__ . '/../../dependencies/CRUDController.php';

    use GlobalCommon\BasicModel;
    use GlobalCommon\IDataControl;
    use GlobalCommon\IDataHubActions;

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

    class User extends BasicModel implements IDataControl
    {

        public ?int    $ID             = null;
        public ?int    $PersonID       = null;
        public ?int    $UserCategoryID = null;
        public ?bool   $IsActive       = null;

        final public function isValid(): bool
        {
            // TODO: Implement isValid() method.
            return true;
        }


        final public function create(IDataHubActions $_dataHub): ?self
        {
            // region *** prepare data for storage ***
            $data['person_id']        = $this->PersonID;
            $data['user_category_id'] = $this->UserCategoryID;
            $data['is_active']        = $this->IsActive;
            // endregion

            $dbLastInsertID = $_dataHub->dataHubCreate($data, 'elementary_user');
            if ($dbLastInsertID) {
                $this->ID = $dbLastInsertID;
                return $this;
            }
            return null;
        }

        final public function read()
        {

        }

        final public function update()
        {

        }

        final public function delete()
        {

        }
    }

}


