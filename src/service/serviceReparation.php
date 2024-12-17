<?php
namespace MyWorkshop\service;

use Exception;
use mysqli;
use MyWorkshop\models\reparation;
use Ramsey\Uuid\Generator\CombGenerator;
use Ramsey\Uuid\Nonstandard\Uuid;
use Ramsey\Uuid\Rfc4122\UuidV1;

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
        if ($type == "employee") {
            $sql_sentence = "SELECT * FROM reparation";
        } else {
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

    function insertReparation($email, $name, $date, $matricula, $image)
    {
        $mysqli = $this->connect();
        $uuid = uuid::uuid4()->toString();
        $imageData = bin2hex(file_get_contents(filename: $image));
        $sql_sentence = "INSERT INTO `workshop`.`reparation` (`uuid`, `name`, `email`, `registerDate`, `licensePlate`, `image`) 
        VALUES ('$uuid', '$name', '$email', '$date', '$matricula', 0x$imageData);";
        var_dump($sql_sentence);

        if ($mysqli->query($sql_sentence) == true) {
            $select_sql = "SELECT * FROM `workshop`.`reparation` WHERE `uuid` = '$uuid'";
            return $mysqli->query($select_sql);
        }
    }
}