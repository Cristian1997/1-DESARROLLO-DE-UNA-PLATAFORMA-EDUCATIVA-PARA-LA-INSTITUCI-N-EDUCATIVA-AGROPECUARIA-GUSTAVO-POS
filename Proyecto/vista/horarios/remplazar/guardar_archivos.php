<?php
$ruta = "../img/";

if (isset($_FILES["archivo"]) && $_FILES["archivo"]["name"][0]) {
    // Obtén el valor del menú desplegable
    $nombrePersonalizado = isset($_POST['nombrePersonalizado']) ? $_POST['nombrePersonalizado'] : "Horarios_page-0001";

    for ($i = 0; $i < count($_FILES["archivo"]["name"]); $i++) {
        if ($_FILES["archivo"]["type"][$i] == "image/jpeg" || $_FILES["archivo"]["type"][$i] == "image/jpg" || $_FILES["archivo"]["type"][$i] == "image/png") {
            if (file_exists($ruta) || @mkdir($ruta)) {
                // Asignar un nombre personalizado al archivo
                $nombreCompleto = $nombrePersonalizado . ".jpg";

                $origen_archivo = $_FILES["archivo"]["tmp_name"][$i];
                $destino_archivo = $ruta . $nombreCompleto;

                if (@move_uploaded_file($origen_archivo, $destino_archivo)) {
                    echo $nombreCompleto . " guardado correctamente";
                } else {
                    echo "El archivo " . $nombreCompleto . " no se ha guardado correctamente";
                }
            } else {
                echo "No se ha creado la carpeta correctamente.";
            }
        } else {
            echo $_FILES["archivo"]["name"][$i] . " no es un archivo de imagen válido";
        }
    }
} else {
    echo "No se ha cargado ninguna imagen";
}
?>
