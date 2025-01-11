<?php
namespace MyWorkshop\service;

use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use mysqli;
use MyWorkshop\models\reparation;
use Ramsey\Uuid\Nonstandard\Uuid;
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Exception;
class serviceReparation
{

    
    function connect()
    {
        $logger = new Logger('serviceReparation');
        try {
            $db = parse_ini_file("../../config/db_config.ini");
            $logger->pushHandler(new StreamHandler('../../logs/app_workshop.log', Logger::INFO));
            $logger->info('conection established with the database');
            return new mysqli($db["host"], $db["user"], $db["pwd"], $db["db_name"]);

        } catch (Exception $e) {
            $logger->pushHandler(new StreamHandler('../../logs/app_workshop.log', Logger::ERROR));
            $logger->error('Error connecting to the database -> ' . $e->getMessage());
        }

    }

    function getReparation($email, $type)
    {
        $logger = new Logger('serviceReparation');

        $managerImage = new ImageManager(new Driver());

        $mysqli = $this->connect();

        try {
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

            $logger->pushHandler(new StreamHandler('../../logs/app_workshop.log', Logger::INFO));
            $logger->info('Data obtained correctly -> ' . $result->num_rows . ' rows returned');

            return $data;
        } catch (Exception $e) {
            $logger->pushHandler(new StreamHandler('../../logs/app_workshop.log', Logger::ERROR));
            $logger->error('Error getting the reparation -> ' . $e->getMessage());
        }


    }

    function insertReparation($email, $name, $date, $matricula, $image, $idWorkshop)
    {
        $logger = new Logger('serviceReparation');
        
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

        try {
            $sql_sentence = "INSERT INTO `workshop`.`reparation` (`uuid`, `name`, `email`, `registerDate`, `licensePlate`, `image`, `idWorkshop`) 
            VALUES ('$uuid', '$name', '$email', '$date', '$matricula', '$imageData','$idWorkshop');";
            if ($mysqli->query($sql_sentence)) {
                $select_sql = "SELECT * FROM `workshop`.`reparation` WHERE `uuid` = '$uuid'";
                $row = $mysqli->query($select_sql)->fetch_assoc();

                $logger->pushHandler(new StreamHandler('../../logs/app_workshop.log', Logger::INFO));
                $logger->info('Reparation inserted correctly -> ' . $row["uuid"]);

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
        } catch (Exception $e) {
            $logger->pushHandler(new StreamHandler('../../logs/app_workshop.log', Logger::WARNING));
            $logger->warning('Error inserting the reparation -> ' . $e->getMessage());
        }

    }
}