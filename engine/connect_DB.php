<?php
include_once "autoLoaderClass.php";

class connect_DB
{
    private $_config;
    private $_db_login;
    private $_db_pass;
    private $_db_host;
    private $_connect;

    public function __construct()
    {
        $this->_config = new config();
        $this->_db_login = $this->_config->__db_login__;
        $this->_db_pass = $this->_config->__db_password__;
        $this->_db_host = $this->_config->__db_host__;
    }

    //Подключение к базе данных
    public function connect()
    {
        $this->_connect = mysqli_connect($this->_db_host, $this->_db_login, $this->_db_pass);
        //Установка кодировки
        mysqli_set_charset($this->_connect, "UTF8");
        //Обработка ошибок
        if ($this->_connect->errno) {
            throw new Exception("Не удалось подключиться к базе.");
        }
    }

    // Выбор базы данных
    public function chooseDB($_name_db)
    {
        $this->_connect->select_db($_name_db);
        //Обработка ошибок
        if ($this->_connect->errno) {
            throw new Exception("Не удалось выбрать базу данных.");
        }
    }

    public function close()
    {
        $this->_connect->close();
    }
}
