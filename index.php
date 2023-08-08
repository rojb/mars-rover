<?php
require_once 'php/meseta.php';
require_once 'php/rover.php';

$regex = '/^[LlRrMm]+$/';

session_start();

if (!isset($_SESSION["meseta"])) {
    $_SESSION["meseta"] = new Meseta();
}

if (!isset($_SESSION["rovers"])) {
    $_SESSION["rovers"] = [];
}

$meseta = $_SESSION["meseta"];
$rovers = $_SESSION["rovers"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["coord-x-meseta"]) && isset($_POST["coord-y-meseta"])) {

        $x = $_POST["coord-x-meseta"];
        $y = $_POST["coord-y-meseta"];
        if ($x >= 0 && $y >= 0) {
            $meseta->x = $_POST["coord-x-meseta"];
            $meseta->y = $_POST["coord-y-meseta"];
        }
    } elseif (
        isset($_POST["coord-x-rover"]) && isset($_POST["coord-y-rover"])
        && isset($_POST["dir-rover"]) && isset($_POST["string-mov"])
    ) {
        if ($meseta->x == -1 && $meseta->y == -1) {
            echo 'Establezca dimensiones válidas para la meseta.';
            return;
        }
        $rover = new Rover($meseta);
        $x = $_POST["coord-x-rover"];
        $y = $_POST["coord-y-rover"];
        if ($x >= 0 && $x <= $meseta->x && $y >= 0 && $y <= $meseta->y) {
            $dir = $_POST["dir-rover"];
            $comandos = trim($_POST["string-mov"]);
            if (preg_match($regex, $comandos)) {
                array_push($rovers, $rover->moverse($x, $y, $dir, $comandos));
                $_SESSION["rovers"] = $rovers;
            } else {
                echo ("Caracteres permitidos: LRM");
            }
        }
    } elseif (isset($_POST["reset-form-btn"])) {
        $_SESSION["meseta"] = new Meseta();
        $meseta = $_SESSION["meseta"];
        $_SESSION["rovers"] = [];
        $rovers =  $_SESSION["rovers"];
    } else {
        echo "No se recibió ningún formulario válido.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Rover de Marte</title>
</head>

<body>
    <main class="container">
        <div class="card mt-5">
            <div class="card-header text-uppercase">
                Panel de control de la misión
            </div>
            <div class="card-body">
                <form class="mb-3" id="form-reset" method="post">
                    <input type="checkbox" name="reset-form-btn" checked hidden />
                    <input type="submit" class="btn btn-primary" value="Limpiar Formulario" />
                </form>
                <form id="form-meseta" method="post" class="form-control">
                    <span class="fs-5 fw-bold d-block">Meseta <small>(Coord. sup. de la meseta)</small></span>
                    <label for="coord-x-meseta">X</label>
                    <input type="number" name="coord-x-meseta" id="" placeholder="Coordenada x" value="<?php if ($meseta->x != -1) {
                                                                                                            echo $meseta->x;
                                                                                                        }  ?>" required />
                    <label for="coord-y-meseta">Y</label>
                    <input type="number" name="coord-y-meseta" id="" placeholder="Coordenada y" value="<?php if ($meseta->y != -1) {
                                                                                                            echo $meseta->y;
                                                                                                        }  ?>" required />

                    <input type="submit" class="btn btn-primary" value="Ejecutar">
                </form>

                <form method="post" class="form-control mt-3 d-flex align-items-center">

                    <div class="">
                        <div>
                            <span class="fs-5 fw-bold d-block">Coord. Rover</span>
                            <label for="coord-x-rover">X</label>
                            <input type="number" name="coord-x-rover" id="" placeholder="Coordenada x" required />
                            <label for="coord-y-rover">Y</label>
                            <input type="number" name="coord-y-rover" id="" placeholder="Coordenada y" required />
                            <div class="">
                                <label for="dir-rover">Dirección</label>
                                <select name="dir-rover" class="form-select w-50 " required>
                                    <option selected disabled>Selecciona</option>
                                    <option value="N">N</option>
                                    <option value="S">S</option>
                                    <option value="E">E</option>
                                    <option value="O">O</option>
                                </select>
                            </div>
                        </div>

                        <div class=" ">
                            <label class="fs-5 fw-bold d-block" for="string-mov">String de Movimientos</label>
                            <input type="text" name="string-mov" id="" placeholder="String de movimientos" required />
                        </div>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Ejecutar">
                </form>


                <p class="card-text fs-5 fw-bold mt-3">Salida</p>
                <div class="form-control bg-dark text-white overflow-auto" style="height: 150px;">

                    <?php
                    if (!empty($rovers)) {
                        for ($i = 0; $i < count($rovers); $i++) { ?>
                            <pre> <?php print_r($rovers[$i]) ?> </pre>
                        <?php  } ?>
                    <?php  } ?>
                </div>

            </div>
            <div class="card-footer text-muted text-uppercase">
                nasa
            </div>
        </div>
    </main>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</html>