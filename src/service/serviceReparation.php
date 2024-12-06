<?php
namespace MyWorkshop\service;

use mysqli;
use MyWorkshop\models\reparation;

class serviceReparation
{
    function connect()
    {
        $db = parse_ini_file("../../config/db_config.ini");
        return new mysqli($db["host"], $db["user"], $db["pwd"], $db["db_name"]); //4 db
    }

    function getReparation($email, $type)
    {
        $mysqli = $this->connect();
        if($type == "employee"){
            $sql_sentence = "SELECT * FROM reparation";
        } else{
            $sql_sentence = "SELECT * FROM reparation WHERE email = '$email'";
        }
        
        $result = $mysqli->query($sql_sentence);

        $data = [];
        while ($row = $result->fetch_assoc()) {

            $reparation = new reparation(
                $row["uuid"],
                $row["name"],
                $row["registerDate"],
                $row["licensePlate"],
                $row["email"]
            );
            $data[] = $reparation;
        }
        return $data;
    }

    function insertReparation()
    {

    }
}