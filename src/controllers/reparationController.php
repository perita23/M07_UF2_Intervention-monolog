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
}
