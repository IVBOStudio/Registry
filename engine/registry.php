<?php
include "autoLoaderClass.php";

class registry
{

}

$connectDb = new connect_DB();

$connectDb->connect();

$connectDb->chooseDB("site");

print_r($connectDb->getDataBasesList());



