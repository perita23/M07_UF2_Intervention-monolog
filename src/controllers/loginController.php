<?php
namespace MyWorkshop\controllers;

use MyWorkshop\service\serviceLogin;


class loginController
{

    public function logIn()
    {
        session_start();
        if (isset($_POST)) {
            $email = $_POST["userEmail"];
            $password = $_POST["userPassword"];
            $type = $_POST["userType"];

            $serviceLogin = new serviceLogin();

            $response = $serviceLogin->validateLogin($email, $password, $type);
            if ($response->num_rows == 1) {
                $_SESSION["email"] = $email;
                $_SESSION["userType"] = $type;
                header("Location: ../src/view/View.php");
            } else {
                session_destroy();
                header("Location: ./index.php?error=1");
            }

        }
    }

}
