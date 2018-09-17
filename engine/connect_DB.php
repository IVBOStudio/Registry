<?php
include_once "autoLoaderClass.php";

class connect_DB
{
    private $_config;

    function __construct()
    {
        $this->_config = new config();
    }

}
