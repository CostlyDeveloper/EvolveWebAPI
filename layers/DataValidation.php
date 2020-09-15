<?php


namespace LAYER\DataValidation {

    class StringValidation
    {

        final public function startsWith(string $_string, string $_startString): bool
        {
            $len = strlen($_startString);
            return (substr($_string, 0, $len) === $_startString);
        }

        final public function endsWith(string $_string, string $_endString): bool
        {
            $len = strlen($_endString);
            if ($len == 0) {
                return true;
            }
            return (substr($_string, -$len) === $_endString);
        }
    }
}
