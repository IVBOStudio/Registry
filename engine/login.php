<?php
/**
 * Created by PhpStorm.
 * User: Pro808
 * Date: 03.10.2018
 * Time: 17:35
 */
include_once "autoLoaderClass.php";

class login
{
    private $data = array(
        "login" => "",
        "password" => "",
        "hidden" => array(
            "admin" => ""
        )
    );
}

$DB = new DataBase();

$DB->connect();
