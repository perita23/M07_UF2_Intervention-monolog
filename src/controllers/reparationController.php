<?php
namespace MyWorkshop\controllers;

use MyWorkshop\service\serviceReparation;

class reparationController
{
    function getReparation()
    {
        $serviceReparation = new serviceReparation();
        $response = $serviceReparation->getReparation($_SESSION["email"], $_SESSION["userType"]);
        return $response;
    }

    function insertReparation()
    {
        $serviceReparation = new serviceReparation();
        $response = $serviceReparation->insertReparation(
            $_POST["insertEmail"],
            $_POST["insertName"],
            $_POST["insertDate"],
            $_POST["insertMatricula"],
            $_FILES["insertImage"]["tmp_name"],
            $_POST["idWorkshop"]
        );
        return $response;
    }
}
