<?php

include_once "DataBase.php";

/**
 * Created by PhpStorm.
 * User: Pro808
 * Date: 20.09.2018
 * Time: 15:59
 */
class BaseTables
{
    function __construct()
    {
        $db = new DataBase();
        $db->connect();
        $db->chooseDB("site");

        $db->query("CREATE TABLE `users` (
 `id` INT(11) NOT NULL,
  `firstName` VARCHAR(50) COLLATE utf8_bin NOT NULL,
  `middleName` VARCHAR(50) COLLATE utf8_bin NOT NULL,
  `lastName` VARCHAR(50) COLLATE utf8_bin NOT NULL,
  `email` VARCHAR(50) COLLATE utf8_bin NOT NULL,
  `login` VARCHAR(50) COLLATE utf8_bin NOT NULL,
  `password` VARCHAR(50) COLLATE utf8_bin NOT NULL,
  `hash` VARCHAR(50) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin");

        $db->query("ALTER TABLE `users`
  ADD PRIMARY KEY (`id`)");

        $db->query("ALTER TABLE `users`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0");

        $db->query("CREATE TABLE `login_user` (
  `login` VARCHAR(50) NOT NULL,
  `timeStamp` DATETIME NOT NULL,
  `hashes` TEXT,
  `user_agents` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8");

        $db->query("ALTER TABLE `login_user`
  ADD PRIMARY KEY (`login`)");

    }

}

$createTables = new BaseTables();