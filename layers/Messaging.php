<?php

namespace Layer\Messaging {


    class ResponseMessage
    {

        public ?string $Message = null;
        public ?string $Code    = null;
        public ?string $Title   = null;

        final public function setCode(string $_Code): void
        {
            $this->Code = $_Code ?: null;
        }

        final public function setTitle(string $_Title): void
        {
            $this->Title = $_Title ?: null;
        }

        final public function setMessage(string $_Message): void
        {
            $this->Message = $_Message ?: null;
        }
    }
}
