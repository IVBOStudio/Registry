<?php
include "autoLoaderClass.php";

class registry
{

}

$connectDb = new connect_DB();

$connectDb->connect();

$connectDb->chooseDB("site");

$connectDb->query("SELECT * FROM ?n ", "users");

$array = $connectDb->GetAssocArrayAll();

print_r($array);

