<?php


abstract class JsonFetch
{

    public static function fetchFromFile(string $_Module, string $_Controller, string $_Action)
    {
        $str = file_get_contents('../database/json-db/' . $_Module . '/' . $_Controller . '/' . $_Action . '.json');
        return json_decode($str, true);
    }
}
