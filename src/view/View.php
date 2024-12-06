<?php
namespace MyWorkshop\view;
require "../../vendor/autoload.php";

use MyWorkshop\controllers\reparationController;
class View
{
    public function renderReparation()
    {
        session_start();
        $reparationController = new reparationController();

        $content = $reparationController->getReparation();
        if (($content == null)) {
            echo "<p class='text-danger'>No tienes ninguna reparacion registrada...</p>";
            exit;
        }
        foreach ($content as $key => $value) {
            ?>
            <div class="w-50 border rounded">
                <img style="width: 100;" src="#" alt="Imagentest" class="w-100 m-2">
                <hr>
                <div class="p-3">
                    <p><b>uuid: </b><?php echo $value->getUuid() ?></p>
                    <p><b>name: </b><?php echo $value->getName() ?></p>
                    <p><b>fecha de registro: </b><?php echo $value->getRegisterDate()->format("Y-m-d") ?></p>
                    <?php
                    if ($_SESSION["userType"] == "employee") {
                        ?>
                        <p><b>matricula: </b><?php echo $value->getLicensePlate() ?></p>
                        <p><b>email: </b><?php echo $value->getEmail() ?></p>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>

<body style="margin: 0 auto;">
    <section style="width: 100vw;" class="p-4">
        <h1>Bienvenido</h1>
        <h3>Tus reparaciones...</h3>
        <div class="d-flex gap-4">
            <?php
            $view = new View();
            $view->renderReparation()
                ?>
        </div>
    </section>
    <?php
    if ($_SESSION["userType"] == "employee") {
        ?>
        <section class="p-4">

            <h2>panel de empleado</h2>
            <form action=""></form>
        </section>

        <?php
    }
    ?>
</body>

</html>