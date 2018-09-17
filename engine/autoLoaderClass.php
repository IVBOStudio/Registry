<?php

class autoLoaderClass
{
    private $_dirLib = "./";


    public function load()
    {
        $classes = array_diff(scandir($this->_dirLib), array('..', '.', 'autoLoaderClass.php'));

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

