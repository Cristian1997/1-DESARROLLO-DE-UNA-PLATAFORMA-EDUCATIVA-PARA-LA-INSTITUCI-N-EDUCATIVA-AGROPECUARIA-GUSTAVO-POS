<!DOCTYPE html>
<html lang="es">
<head>
    <title>archivos</title>
    <!-- Agregamos la librería de Bootstrap para los modales -->
</head>
<body>
    <!-- Botón para abrir el modal -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" data-backdrop="static" data-keyboard="false">
        Remplazar Imágenes
    </button>

    <!-- Modal -->
    <div class="modal" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Contenido del modal -->
                <div class="modal-header">
                    <h4 class="modal-title">Remplazar Imágenes</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">
                    <!-- Contenido del formulario -->
                    <form id="archivoForm" enctype="multipart/form-data">
                        
                        <input type="file" name="archivo[]" multiple="multiple" onchange="mostrarVistaPrevia()">
                        <br>
                        <select id="nombrePersonalizado" name="nombrePersonalizado">
                            
                            <option value="Horarios_page-0001">Grado 6A</option>
                            <option value="Horarios_page-0002">Grado 6B</option>
                            <option value="Horarios_page-0003">Grado 6C</option>
                                       
                            <option value="Horarios_page-0004">Grado 7A</option>
                            <option value="Horarios_page-0005">Grado 7B</option>
                            <option value="Horarios_page-0006">Grado 7C</option>
                             
                            <option value="Horarios_page-0007">Grado 8A</option>
                            <option value="Horarios_page-0008">Grado 8B</option>
                            <option value="Horarios_page-0009">Grado 8C</option>
                              
                            <option value="Horarios_page-0010">Grado 9A</option>
                            <option value="Horarios_page-0011">Grado 9B</option>
                            <option value="Horarios_page-0012">Grado 9C</option>
                              
                            <option value="Horarios_page-0013">Grado 10A</option>
                            <option value="Horarios_page-0014">Grado 10B</option>
                            <option value="Horarios_page-0015">Grado 10C</option>

                            <option value="Horarios_page-0016">Grado 11A</option>
                            <option value="Horarios_page-0017">Grado 11B</option>
                            <option value="Horarios_page-0018">Grado 11C</option>

                              
                       
                            <!-- Agrega más opciones según sea necesario -->
                                
                        </select>
                        <br>
                        <br>
               
                        
                        <div id="vistaPrevia" class="text-center" style="display:none;">
                            <img id="imagenPrevia" alt="Vista previa de la imagen" width="400">

                           
                        </div>
                        <p style="text-align: center;">Vista previa de la imagen</p>
                        <br>
                        <div class="mt-2 mb-2 text-center">
                            <input type="button" class="btn btn-success" value="Guardar" onclick="guardarArchivos()">
                        </div>
                        
                    </form>
             
                    <div id="mensaje"></div>
                </div>

                <div class="modal-footer">
                    <!-- Botón para cerrar manualmente el modal y recargar la página -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cargar_contenido('contenido_principal','horarios/remplazar/horarios_admin.php')">Finalizar</button>
                </div>
            </div>
        </div>
    </div>

   
    <script>
        function mostrarVistaPrevia() {
            var input = document.querySelector('input[type="file"]');
            var files = input.files;

            if (files && files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#imagenPrevia').attr('src', e.target.result);
                    $('#vistaPrevia').show();
                };

                reader.readAsDataURL(files[0]);
            }
        }

        function guardarArchivos() {
            var formData = new FormData($("#archivoForm")[0]);
            var nombrePersonalizado = $("#nombrePersonalizado").val();
            var nombreCompleto = nombrePersonalizado + ".jpg";
            var timeStamp = new Date().getTime();


            $.ajax({
                type: "POST",
                url: "/copia/vista/horarios/remplazar/guardar_archivos.php",
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#mensaje").html(response);

                    function cargar_contenido(contenedor, contenido) {
    var timeStamp = new Date().getTime();
    $("#" + contenedor).reload(contenido + "?timestamp=" + timeStamp);
}

                },
                error: function(error) {
                    $("#mensaje").html("Error al guardar archivos.");
                }
                
            });
        }

    

    </script>
</body>
</html>
