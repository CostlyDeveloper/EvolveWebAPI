<?php

namespace Layer\Messaging {


    class ResponseMessage
    {

        public $Code;
        public $Title;
        public $Message;

        public function __construct()
        {
        }

        public function setCode(string $_Code)
        {
            $this->Code = $_Code ?: null;
        }

        public function setTitle(string $_Title)
        {
            $this->Title = $_Title ?: null;
        }

        public function setMessage(string $_Message)
        {
            $this->Message = $_Message ?: null;
        }
    }
}
