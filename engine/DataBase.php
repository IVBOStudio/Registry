<?php
include_once "config.php";

/*
 * Плейсхолдеры
 * ?i - число
 * ?s - строка
 * ?p - готовый SQL
 * ?u - array для SET ~ INSERT INTO
 * ?a - array для IN ~ UPDATE
 * ?r - rename table (name1 - > name2)
 */

class DataBase
{
    private $_config;
    private $_db_login;
    private $_db_pass;
    private $_db_host;
    private $_connect;
    private $_last_query;

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

    private function prepareQuery($args)
    {
        $query = '';
        //Удаляем первый параметр функции query()
        $raw = array_shift($args);
        //Ищем наши плейсхолдеры
        $array = preg_split('~(\?[nsiuap])~u', $raw, null, PREG_SPLIT_DELIM_CAPTURE);
        // количество плейсхолдеров полученных
        $anum = count($args);
        // количество плейсхолдеров в query запросе
        $pnum = floor(count($array) / 2);
        if ($pnum != $anum) {
            throw new Exception("Оишбка передачи параметров.");
        }
        foreach ($array as $i => $part) {
            if (($i % 2) == 0) {
                $query .= $part;
                continue;
            }
            $value = array_shift($args);
            switch ($part) {
                case '?n':
                    $part = $this->escapeIdent($value);
                    break;
                case '?s':
                    $part = $this->escapeString($value);
                    break;
                case '?i':
                    $part = $this->escapeInt($value);
                    break;
                case '?a':
                    $part = $this->createIN($value);
                    break;
                case '?u':
                    $part = $this->createSET($value);
                    break;
                case '?p':
                    $part = $value;
                    break;
            }
            $query .= $part;
        }
        $this->_last_query = $query;
        return $query;
    }

    private function escapeInt($value)
    {
        if ($value === NULL) {
            return 'NULL';
        }
        if (!is_numeric($value)) {
            throw new Exception("Неправильно передан числовой параметр.");
        }
        if (is_float($value)) {
            $value = number_format($value, 0, '.', '');
        }
        return $value;
    }

    private function escapeString($value)
    {
        if ($value === NULL) {
            return 'NULL';
        }
        return "'" . mysqli_real_escape_string($this->_connect, $value) . "'";
    }

    private function escapeIdent($value)
    {
        if ($value) {
            return "`" . str_replace("`", "``", $value) . "`";
        } else {
            throw new Exception("Не указан именной параметр.");
        }
    }

    private function createIN($data)
    {
        if (!is_array($data)) {
            throw new Exception("Значения для IN (?a) - должен быть array ");
        }
        if (!$data) {
            return 'NULL';
        }
        $query = $comma = '';
        foreach ($data as $value) {
            $query .= $comma . $this->escapeString($value);
            $comma = ",";
        }
        return $query;
    }

    private function createSET($data)
    {
        if (!is_array($data)) {
            throw new Exception("SET (?u) должен быть array.");
        }
        if (!$data) {
            throw new Exception("Пустой массив (?u) для SET");
        }
        $query = $comma = '';
        foreach ($data as $key => $value) {
            $query .= $comma . $this->escapeIdent($key) . '=' . $this->escapeString($value);
            $comma = ",";
        }
        return $query;
    }

    public function rawQuery($query)
    {
        //SQL запрос к базе данных
        $res = mysqli_query($this->_connect, $query);

        if ($this->_connect->errno) {
            throw new Exception("Ошибка запроса к базе данных.");
        } else {
            return $res;
        }
    }

    public function query()
    {
        return $this->rawQuery($this->prepareQuery(func_get_args()));
    }

    public function GetAssocArrayAll()
    {
        $ret = array();
        $query = $this->_last_query;
        if ($res = $this->rawQuery($query)) {
            while ($row = mysqli_fetch_assoc($res)) {
                $ret[] = $row;
            }
            $this->free($res);
        }
        return $ret;
    }

    public function getDataBasesList()
    {
        $arr = Array();
        $query = "show databases;";
        if ($res = $this->rawQuery($query)) {
            while ($row = $res->fetch_array(MYSQLI_NUM)) {
                $arr[] = $row[0];
            }
            $arr = array_diff($arr, array("information_schema", "mysql", "performance_schema", "sys"));
            return $arr;
        } else {
            throw new Exception("Ошибка получения списка баз данных данных.");
        }
    }

    public function getTablesList()
    {
        $arr = Array();
        $query = "show tables;";
        if ($res = $this->rawQuery($query)) {
            while ($row = $res->fetch_array(MYSQLI_NUM)) {
                $arr[] = $row[0];
            }
            return $arr;
        } else {
            throw new Exception("Ошибка получения списка таблиц данных.");
        }
    }

    public function renameTable($value)
    {
        $query = "ALTER TABLE ";
        if (!is_array($value)) {
            throw new Exception("Для изменения имени таблицы (?r) передается массив.");
        }
        foreach ($value as $name1 => $name2) {
            $query .= $this->escapeIdent($name1) . " RENAME " . $this->escapeIdent($name2);
        }
        $this->rawQuery($query);
    }

    public function free($result)
    {
        mysqli_free_result($result);
    }

    public function close()
    {
        $this->_connect->close();
    }
}
