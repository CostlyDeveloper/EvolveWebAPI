<?php

namespace BASIC\Model {

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

            $dbResponse = $_dataHub->dataHubCreate($data, 'elementary_user');
            if ($dbResponse) {
                $this->ID             = $dbResponse->id;
                $this->PersonID       = $dbResponse->person_id;
                $this->UserCategoryID = $dbResponse->user_category_id;
                $this->IsActive       = $dbResponse->is_active;
                return $this;
            }
            return null;
        }

        final public function read(IDataHubActions $_dataHub): ?self
        {
            // region *** prepare data for query ***
            $data['id'] = $this->ID;
            // endregion

            $dbResponse = $_dataHub->dataHubRead($data, 'elementary_user');
            if ($dbResponse) {
                $this->ID             = $dbResponse->id;
                $this->PersonID       = $dbResponse->person_id;
                $this->UserCategoryID = $dbResponse->user_category_id;
                $this->IsActive       = $dbResponse->is_active;
                return $this;
            }
            return null;
        }

        final public function update(IDataHubActions $_dataHub): ?self
        {
            // region *** prepare data for update ***
            $data['id']               = $this->ID;
            $data['person_id']        = $this->PersonID;
            $data['user_category_id'] = $this->UserCategoryID;
            $data['is_active']        = $this->IsActive;
            // endregion

            $dbResponse = $_dataHub->dataHubUpdate($data, 'elementary_user');
            if ($dbResponse) {
                $this->ID             = $dbResponse->id;
                $this->PersonID       = $dbResponse->person_id;
                $this->UserCategoryID = $dbResponse->user_category_id;
                $this->IsActive       = $dbResponse->is_active;
                return $this;
            }
            return null;

        }

        final public function delete(IDataHubActions $_dataHub): ?self
        {

            // region *** prepare data for update ***
            $data['id']               = $this->ID;
            $data['person_id']        = $this->PersonID;
            $data['user_category_id'] = $this->UserCategoryID;
            $data['is_active']        = $this->IsActive;
            // endregion

            $dbResponse = $_dataHub->dataHubDelete($data, 'elementary_user');

            var_dump($dbResponse);

        }
    }

}


