<?php
include "autoLoaderClass.php";

class registry
{
    private $data = array(
        "firstName" => "",
        "middleName" => "",
        "lastName" => "",
        "login" => "",
        "email" => "",
        "password");

}

$connectDb = new DataBase();

$connectDb->connect();

$connectDb->chooseDB("site");

//$connectDb->query("INSERT INTO ?n SET ?u ON ON DUPLICATE KEY UPDATE ?u ","users",array("id" => null,"login" => "Pro808","password" => "123","hash" => ""),array("hash" => "DUP"));

//print_r($connectDb->getDataBasesList());



