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

        $db->commit("CREATE TABLE IF NOT EXISTS `users`  (
`id` INT(11) NOT NULL,
  `firstName` VARCHAR(50) COLLATE utf8_bin NULL,
  `middleName` VARCHAR(50) COLLATE utf8_bin NULL,
  `lastName` VARCHAR(50) COLLATE utf8_bin NULL,
  `email` VARCHAR(50) COLLATE utf8_bin NULL,
  `login` VARCHAR(50) COLLATE utf8_bin NOT NULL,
  `password` VARCHAR(50) COLLATE utf8_bin NOT NULL,
  `hash` VARCHAR(50) COLLATE utf8_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_bin",
            "ALTER TABLE `users`
  ADD PRIMARY KEY (`id`)",
            "ALTER TABLE `users`
  MODIFY `id` INT(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=0",
            "CREATE TABLE IF NOT EXISTS `login_user` (
  `login` VARCHAR(50) NOT NULL,
  `timeStamp` DATETIME NULL,
  `hashes` TEXT,
  `user_agents` TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8",
            "ALTER TABLE `login_user`
  ADD PRIMARY KEY (`login`)");

    }

}

$createTables = new BaseTables();