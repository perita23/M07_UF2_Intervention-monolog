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
            echo "<p class='text-danger text-center'>No tienes ninguna reparación registrada...</p>";
        }

        foreach ($content as $key => $value) {
            ?>
            <div class="card mb-4 shadow-sm">
                <a class="mt-3" href="#" data-bs-toggle="modal" data-bs-target="#imageModal<?php echo $key; ?>">
                    <img src="data:image/png;base64, <?php echo base64_encode($value->getImage()) ?>" alt="Imagentest"
                        class="card-img-top img-fluid rounded mx-auto d-block" style="max-width: 60%; height: auto;">
                </a>
                <div class="card-body">
                    <h5 class="card-title"><b>UUID:</b> <?php echo $value->getUuid() ?></h5>
                    <p class="card-text"><b>Nombre:</b> <?php echo $value->getName() ?></p>
                    <p class="card-text"><b>Id taller:</b> <?php echo $value->getIdWorkshop() ?></p>
                    <p class="card-text"><b>Fecha de registro:</b> <?php echo $value->getRegisterDate()->format("Y-m-d") ?></p>
                    <?php
                    if ($_SESSION["userType"] == "employee") {
                        ?>
                        <p class="card-text"><b>Matrícula:</b> <?php echo $value->getLicensePlate() ?></p>
                        <p class="card-text"><b>Email:</b> <?php echo $value->getEmail() ?></p>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <div class="modal fade" id="imageModal<?php echo $key; ?>" tabindex="-1"
                aria-labelledby="imageModalLabel<?php echo $key; ?>" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="imageModalLabel<?php echo $key; ?>">Imagen de Reparación</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center">
                            <img src="data:image/png;base64, <?php echo base64_encode($value->getImage()) ?>" alt="Imagentest"
                                class="img-fluid rounded">
                        </div>
                    </div>
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
    <title>Reparaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</head>
<header>
    <div class="d-flex">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Reparaciones</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" href="./View.php">Reparaciones</a>
                        </li>
                        <li class="nav-item-">
                            <a class="nav-link active" href="./closeSession.php">Cerrar sesion</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>

<body class="bg-light">
    <section class="container my-5">
        <div class="text-center mb-4">
            <h1 class="display-4">Bienvenido</h1>
            <p class="lead">Tus reparaciones</p>
        </div>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
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
            <h2 class="text-center">Panel de empleado</h2>
            <p class="text-muted text-center">Añade la información de la reparación en los campos...</p>
            <form action="./View.php" class="row g-3" method="post" enctype="multipart/form-data">
                <div class="col-md-6">
                    <label for="insertImage" class="form-label">Imagen</label>
                    <input type="file" name="insertImage" class="form-control" id="insertImage" required>
                </div>
                <div class="col-md-6">
                    <label for="insertName" class="form-label">Nombre taller</label>
                    <input type="text" name="insertName" class="form-control" id="insertName" required>
                </div>
                <div class="col-md-6">
                    <label for="insertIdWorkshop" class="form-label">ID Taller</label>
                    <input type="text" name="idWorkshop" class="form-control" id="idWorkshop" pattern="[0-9]{4}" required>
                </div>
                <div class="col-md-6">
                    <label for="insertDate" class="form-label">Fecha de registro</label>
                    <input type="date" name="insertDate" class="form-control" id="insertDate" required>
                </div>
                <div class="col-md-6">
                    <label for="insertMatricula" class="form-label">Matrícula</label>
                    <input type="text" name="insertMatricula" class="form-control" id="insertMatricula"
                        pattern="[0-9]{4}-[A-Z]{3}" required>
                </div>
                <div class="col-md-6">
                    <label for="insertEmail" class="form-label">Email</label>
                    <input type="email" name="insertEmail" class="form-control" id="insertEmail" required>
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
                $reparationController = new reparationController();
                $newReparation = $reparationController->insertReparation();
                if ($newReparation) {
                    ?>
                    <div class="card mb-4 shadow-sm">
                        <img src="data:image/png;base64, <?php echo base64_encode($newReparation->getImage()) ?>"
                            alt="Imagentest" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text"><b>UUID: </b><?php echo $newReparation->getUuid() ?></p>
                            <p class="card-text"><b>Nombre: </b><?php echo $newReparation->getName() ?></p>
                            <p class="card-text"><b>Id taller:</b> <?php echo $newReparation->getIdWorkshop() ?></p>
                            <p class="card-text"><b>Fecha de registro:
                                </b><?php echo $newReparation->getRegisterDate()->format("Y-m-d") ?></p>
                            <?php
                            if ($_SESSION["userType"] == "employee") {
                                ?>
                                <p class="card-text"><b>Matrícula: </b><?php echo $newReparation->getLicensePlate() ?></p>
                                <p class="card-text"><b>Email: </b><?php echo $newReparation->getEmail() ?></p>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ;
            ?>
        </div>
    </section>
</body>

</html>