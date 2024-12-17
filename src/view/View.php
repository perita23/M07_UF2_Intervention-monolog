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
            <div class="card mb-4 shadow-sm">
                <img src="#" alt="Imagentest" class="card-img-top">
                <div class="card-body">
                    <p class="card-text"><b>UUID: </b><?php echo $value->getUuid() ?></p>
                    <p class="card-text"><b>Nombre: </b><?php echo $value->getName() ?></p>
                    <p class="card-text"><b>Fecha de registro: </b><?php echo $value->getRegisterDate()->format("Y-m-d") ?></p>
                    <?php
                    if ($_SESSION["userType"] == "employee") {
                        ?>
                        <p class="card-text"><b>Matrícula: </b><?php echo $value->getLicensePlate() ?></p>
                        <p class="card-text"><b>Email: </b><?php echo $value->getEmail() ?></p>
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

<body class="bg-light">
    <section class="container my-5">
        <h1 class="mb-4">Bienvenido</h1>
        <h3 class="mb-4">Tus reparaciones:</h3>
        <div class="row h-50 p-4 rounded" style="overflow-y: scroll; background-color:gainsboro">
            <?php
            $view = new View();
            $view->renderReparation()
                ?>
        </div>
    </section>
    <?php
    if ($_SESSION["userType"] == "employee") {
        ?>
        <section class="container my-5">
            <h2>Panel de empleado</h2>
            <p>Añade la información de la reparación en los campos...</p>
            <form action="./View.php" class="row g-3" method="post" enctype="multipart/form-data">
                <div class="col-md-6">
                    <label for="insertImage" class="form-label">Imagen</label>
                    <input type="file" name="insertImage" class="form-control" id="insertImage">
                </div>
                <div class="col-md-6">
                    <label for="insertName" class="form-label">Nombre</label>
                    <input type="text" name="insertName" class="form-control" id="insertName">
                </div>
                <div class="col-md-6">
                    <label for="insertDate" class="form-label">Fecha de registro</label>
                    <input type="date" name="insertDate" class="form-control" id="insertDate">
                </div>
                <div class="col-md-6">
                    <label for="insertMatricula" class="form-label">Matrícula</label>
                    <input type="text" name="insertMatricula" class="form-control" id="insertMatricula">
                </div>
                <div class="col-md-6">
                    <label for="insertEmail" class="form-label">Email</label>
                    <input type="email" name="insertEmail" class="form-control" id="insertEmail">
                </div>
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Enviar</button>
                </div>
            </form>
        </section>
        <?php
    }
    ?>
    <section>
        <div>
            <?php
            if (isset($_POST["insertMatricula"])) {
                var_dump($_FILES["insertImage"]);
                $reparationController = new reparationController();
                $newReparation = $reparationController->insertReparation();
                var_dump($newReparation);
            }
            ;
            ?>
        </div>
    </section>
</body>

</html>