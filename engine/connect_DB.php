<?php
include_once "autoLoaderClass.php";

class connect_DB
{
    private $_config;
    private $_db_login;
    private $_db_pass;
    private $_db_host;
    private $_connect;

    function __construct()
    {
        $this->_config = new config();
        $this->_db_login = $this->_config->__DB_login__;
        $this->_db_pass = $this->_config->__DB_password__;
        $this->_db_host = $this->_config->__DB_HOST__;
    }

    function connect()
    {
        $this->_connect = mysqli_connect($this->_db_host, $this->_db_login, $this->_db_pass);
        mysqli_set_charset($this->_connect, "UTF8");
        if ($this->_connect->errno) {
            throw new Exception("Не удалось подключиться к базе.");
        }

    }

    function chooseDB($_name_db)
    {
        $this->_connect->select_db($_name_db);
        if ($this->_connect->errno) {
            throw new Exception("Не удалось выбрать базу данных.");
        }
    }
}
