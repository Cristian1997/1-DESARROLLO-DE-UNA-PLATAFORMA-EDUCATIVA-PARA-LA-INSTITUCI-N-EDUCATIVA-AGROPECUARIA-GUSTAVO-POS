<!DOCTYPE html>
<html>
<head>
    <title>archivos</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function () {
            $('form[name="inscripcion"]').submit(function (e) {
                e.preventDefault();

                var formData = new FormData($(this)[0]);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        // Recarga la página después de que la operación del servidor haya finalizado
                        location.reload();
                    }
                });
            });
        });
    </script>
</head>
<body>
    <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" enctype="multipart/form-data" name="inscripcion">
        <label for="nombre_personalizado">Seleccione un nombre personalizado:</label>
        <select name="nombre_personalizado">
            <option value="Horarios_page-0001">6a</option>
            <option value="Horarios_page-0002">Horarios_page-0002</option>
            <option value="Horarios_page-0003">Horarios_page-0003</option>
            <!-- Agrega más opciones según sea necesario -->
        </select>
        <br>
        <input type="file" name="archivo[]" multiple="multiple">
        <input type="submit" value="Guardar">
    </form>

    <?php
    $ruta = "../img/";

    if (isset($_FILES["archivo"]) && $_FILES["archivo"]["name"][0]) {
        $nombre_personalizado = isset($_POST['nombre_personalizado']) ? $_POST['nombre_personalizado'] : "Horarios_page-0001";

        for ($i = 0; $i < count($_FILES["archivo"]["name"]); $i++) {
            if ($_FILES["archivo"]["type"][$i] == "image/jpeg" || $_FILES["archivo"]["type"][$i] == "image/jpg" || $_FILES["archivo"]["type"][$i] == "image/png") {
                if (file_exists($ruta) || @mkdir($ruta)) {
                    // Asignar un nombre personalizado al archivo
                    $nombre_archivo = $nombre_personalizado . "" . ".jpg";

                    $origen_archivo = $_FILES["archivo"]["tmp_name"][$i];
                    $destino_archivo = $ruta . $nombre_archivo;

                    if (@move_uploaded_file($origen_archivo, $destino_archivo)) {
                        echo "<br>" . $nombre_archivo . " guardado correctamente";
                    } else {
                        echo "<br> El archivo " . $nombre_archivo . " no se ha guardado correctamente";
                    }
                } else {
                    echo "No se ha creado la carpeta correctamente.";
                }
            } else {
                echo "<br>" . $_FILES["archivo"]["name"][$i] . " no es un archivo de imagen válido";
            }
        }
    } else {
        echo "<br> No se ha cargado ninguna imagen";
    }
    ?>
</body>
</html>
