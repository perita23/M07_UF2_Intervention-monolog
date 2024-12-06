<?php
namespace MyWorkshop\service;

use mysqli;
class serviceLogin
{
    function connect()
    {
        $db = parse_ini_file("../config/db_config.ini");
        return new mysqli($db["host"], $db["user"], $db["pwd"], $db["db_name"]); //4 db
    }

    function validateLogin($email, $password, $type)
    {
        $mysqli = $this->connect();
        $sql_sentence = "SELECT * FROM user WHERE email = '$email' AND password = '$password' AND type = '$type'";
        $result = $mysqli->query($sql_sentence);
        return $result;
    }
}