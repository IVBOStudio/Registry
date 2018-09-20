<?php

class autoLoaderClass
{
    // Каталог модулей CMS-ки
    private $_dirLib = "./";
    
    public function load()
    {
        // Получение всех имен файлов, кроме самого файла и служебных директорий
        $classes = array_diff(scandir($this->_dirLib), array('..', '.', 'autoLoaderClass.php', "BaseTables.php"));

        // Подключение всех модулей
        foreach ($classes as $class) {
            include_once './' . $class;
        }
    }

    public function __construct()
    {
        spl_autoload_register(array($this, "load"));
    }
}

$loader = (new autoLoaderClass())->load();

