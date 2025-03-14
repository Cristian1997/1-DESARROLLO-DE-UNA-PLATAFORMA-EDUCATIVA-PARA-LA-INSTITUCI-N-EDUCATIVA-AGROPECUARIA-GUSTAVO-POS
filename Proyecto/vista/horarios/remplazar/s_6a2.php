<!DOCTYPE html>
<html>
<head>
    <title>archivos</title>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <form id="archivoForm" enctype="multipart/form-data">
        <input type="file" name="archivo[]" multiple="multiple">
        <input type="button" value="Guardar" onclick="guardarArchivos()" >
    </form>

    <div id="mensaje"></div>

    <script>
        function guardarArchivos() {
            var formData = new FormData($("#archivoForm")[0]);

            $.ajax({
                type: "POST",
                url: "/proyect/vista/horarios/remplazar/guardar_archivos.php", // Nombre del archivo PHP que manejará la lógica de guardado
    
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
</body>
</html>
