<?php
namespace MyWorkshop\service;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use mysqli;
use MyWorkshop\models\reparation;
use Ramsey\Uuid\Nonstandard\Uuid;

class serviceReparation
{
    function connect()
    {
        $db = parse_ini_file("../../config/db_config.ini");
        return new mysqli($db["host"], $db["user"], $db["pwd"], $db["db_name"]);
    }

    function getReparation($email, $type)
    {
        $managerImage = new ImageManager(new Driver());

        $mysqli = $this->connect();
        if ($type == "employee") {
            $sql_sentence = "SELECT * FROM reparation";
        } else {
            $sql_sentence = "SELECT * FROM reparation WHERE email = '$email'";
        }

        $result = $mysqli->query($sql_sentence);

        $data = [];
        while ($row = $result->fetch_assoc()) {
            $imageObject = $managerImage->read($row["image"]);
            if ($type != "employee") {
                $imageObject->pixelate(30);
                $row["uuid"] = "************************************";
            }
            $reparation = new reparation(
                $row["uuid"],
                $row["name"],
                $row["registerDate"],
                $row["licensePlate"],
                $row["email"],
                $imageObject->toPng(),
                $row["idWorkshop"]
            );
            $data[] = $reparation;
        }
        return $data;
    }

    function insertReparation($email, $name, $date, $matricula, $image, $idWorkshop)
    {
        $managerImage = new ImageManager(new Driver());
        $mysqli = $this->connect();
        $uuid = uuid::uuid4()->toString();
        $imageData = file_get_contents($image);
        $imageObject = $managerImage->read($imageData);
        $imageObject->resize(1366, 768);
        $imageObject->text("{$uuid}-{$matricula}", 100, 75, function ($font) {
            $font->file(__DIR__ . "/../../resources/fonts/OpenSans-VariableFont_wdth,wght.ttf");
            $font->size(34);
            $font->color('#FF0000');
            $font->align('left');
            $font->valign('top');
        });

        $imageData = file_get_contents($imageObject->toPng()->toDataUri());
        $imageData = $mysqli->real_escape_string($imageData);


        $sql_sentence = "INSERT INTO `workshop`.`reparation` (`uuid`, `name`, `email`, `registerDate`, `licensePlate`, `image`, `idWorkshop`) 
                     VALUES ('$uuid', '$name', '$email', '$date', '$matricula', '$imageData','$idWorkshop');";
        if ($mysqli->query($sql_sentence)) {
            $select_sql = "SELECT * FROM `workshop`.`reparation` WHERE `uuid` = '$uuid'";
            $row = $mysqli->query($select_sql)->fetch_assoc();
            return new reparation(
                $row["uuid"],
                $row["name"],
                $row["registerDate"],
                $row["licensePlate"],
                $row["email"],
                $row["image"],
                $row["idWorkshop"]
            );
        }
    }
}