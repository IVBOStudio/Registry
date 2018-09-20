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

$msg = $_POST["msg"];

$msgAjax = array();
$msgAjax["msg"] = "Пидр : " . $msg;

echo json_encode($msgAjax);



