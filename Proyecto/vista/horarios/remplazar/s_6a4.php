<!DOCTYPE html>
<html>

<head>
    <title>archivos</title>

</head>

<body>
    <form id="archivoForm" enctype="multipart/form-data">
        <input type="file" name="archivo[]" multiple="multiple">
        <input type="button" value="Guardar" onclick="guardarArchivos()">
    </form>

    <div id="mensaje"></div>

    <script>
        function guardarArchivos() {
            var formData = new FormData($("#archivoForm")[0]);

            $.ajax({
                url: "s_6a4.php", // Nombre del archivo PHP que manejará la lógica de guardado
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#mensaje").html(response);
                },
                error: function(error) {
                    $("#mensaje").html("Error al guardar archivos.");
                }
            });
        }
    </script>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $ruta = "carpeta/";

        if (isset($_FILES["archivo"]) && $_FILES["archivo"]["name"][0]) {
            for ($i = 0; $i < count($_FILES["archivo"]["name"]); $i++) {
                if ($_FILES["archivo"]["type"][$i] == "image/jpeg" || $_FILES["archivo"]["type"][$i] == "image/jpg" || $_FILES["archivo"]["type"][$i] == "image/png") {
                    if (file_exists($ruta) || @mkdir($ruta)) {
                        // Asignar un nombre personalizado al archivo
                        $nombre_personalizado = "archivo_personalizado_" . $i . ".jpg";

                        $origen_archivo = $_FILES["archivo"]["tmp_name"][$i];
                        $destino_archivo = $ruta . $nombre_personalizado;

                        if (@move_uploaded_file($origen_archivo, $destino_archivo)) {
                            echo $nombre_personalizado . " guardado correctamente<br>";
                        } else {
                            echo "El archivo " . $nombre_personalizado . " no se ha guardado correctamente<br>";
                        }
                    } else {
                        echo "No se ha creado la carpeta correctamente.<br>";
                    }
                } else {
                    echo $_FILES["archivo"]["name"][$i] . " no es un archivo de imagen válido<br>";
                }
            }
        } else {
            echo "No se ha cargado ninguna imagen<br>";
        }
    }
    ?>
</body>

</html>
