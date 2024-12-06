<?php
require "../vendor/autoload.php";
use MyWorkshop\controllers\loginController;


if (isset($_POST["userEmail"]) && isset($_POST["userPassword"])) {
    $loginController = new loginController();
    $loginController->logIn();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
    <title>WorkShopCars</title>
</head>

<body>
    <div class="container">
        <div class="row vh-100 align-items-center justify-content-center">
            <div class="col-md-6 p-4">
                <form action="./index.php" method="post" class="text-center bg-light p-4 rounded">
                    <h2 class="mb-4">Sign In</h2>
                    <div class="mb-3">
                        <label for="userType" class="form-label">I am a</label>
                        <select class="form-select" id="userType" name="userType">
                            <option value="client">Client</option>
                            <option value="employee">Employee</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="userEmail" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="userPassword" required>
                    </div>
                    <div>
                        <p class="text-danger">
                            <?php
                            if (isset($_GET["error"])) {
                                echo "Email o contraseña incorrectos";
                            }
                            ?>
                        </p>
                    </div>
                    <button type="submit" class="btn btn-primary">Sign in</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>