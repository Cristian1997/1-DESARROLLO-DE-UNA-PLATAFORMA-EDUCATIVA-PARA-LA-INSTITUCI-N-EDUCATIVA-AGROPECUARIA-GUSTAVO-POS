
<!DOCTYPE html>
<html>
<head>
    <title>archivos</title>
 
</head>
<body>
    <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" enctype="multipart/form-data" name="inscripcion">
        <input type="file" name="archivo[]" multiple="multiple">
        <input type="submit" value="Guardar">
    </form>

    <?php
    // Aquí va el código PHP para procesar los archivos cargados
    // ...

    $ruta = "carpeta/";

    if (isset($_FILES["archivo"]) && $_FILES["archivo"]["name"][0]) {
        for ($i = 0; $i < count($_FILES["archivo"]["name"]); $i++) {
            if ($_FILES["archivo"]["type"][$i] == "image/jpeg" || $_FILES["archivo"]["type"][$i] == "image/jpg") {
                if (file_exists($ruta) || @mkdir($ruta)) {
                    // Asignar un nombre personalizado al archivo
                    $nombre_personalizado = "archivo_personalizado_" . $i . ".jpg";

                    $origen_archivo = $_FILES["archivo"]["tmp_name"][$i];
                    $destino_archivo = $ruta . $nombre_personalizado;

                    if (@move_uploaded_file($origen_archivo, $destino_archivo)) {
                        echo "<br>" . $nombre_personalizado . " guardado correctamente";

                        // Redirige después de guardar el archivo
                        echo "<script>cargarContenido('contenido_principal', 'horarios/remplazar/horarios_admin.php');</script>";
                    } else {
                        echo "<br> El archivo " . $nombre_personalizado . " no se ha guardado correctamente";
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