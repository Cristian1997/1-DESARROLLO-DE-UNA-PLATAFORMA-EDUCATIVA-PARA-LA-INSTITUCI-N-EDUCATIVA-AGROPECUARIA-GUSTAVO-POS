
//-----------------modales--------------------------------

$(document).ready(function() {
    $(document).on('click', '.nueva_carpeta', function() {
       
        // Mostrar el modal
        $("#modal_nueva_carpeta").modal({ backdrop: 'static', keyboard: false });
        $("#modal_nueva_carpeta").modal('show');
    });
});


$(document).ready(function() {
    $(document).on('click', '.nuevo_material', function() {
       
        // Mostrar el modal
        $("#modal_nuevo_material").modal({ backdrop: 'static', keyboard: false });
        $("#modal_nuevo_material").modal('show');
    });
});


//------------------------combos-------------------------------


function listar_combo_docentes() {
    var id = $("#txtidusuario").val();
    $.ajax({
        url: "../controlador/talleres/controlador_combo_docente_asunto_listar.php",
        type: 'POST',
        data: {
            id: id
        }
    }).done(function(resp) {
        var data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][1] + "'>" + data[i][0] + "</option>";
            }
            $("#cbm_docente").html(cadena);

            // Cuando se seleccione un docente, actualiza el campo oculto txtiddocente
            $("#cbm_docente").change(function() {
                $("#txtiddocente").val($(this).val());
                // Después de seleccionar un docente, llama a las funciones para listar los datos y la carpeta de materiales
                listar_datos_docente_materiales_es();
                listar_carpeta_materiales_es();
            });

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_docente").html(cadena);
        }
    });
}

  // Cuando se seleccione un docente, actualiza el campo oculto txtiddocente
  $("#cbm_docente").change(function() {
    $("#txtiddocente").val($(this).val());
    // Después de seleccionar un docente, llama a las funciones para listar los datos y la carpeta de materiales
    listar_datos_docente_materiales_es();
    listar_carpeta_materiales_es();
});
//-----------------registrar editar--------------------------------



function crear_carpeta_material(){
    var titulo_carpeta = $("#txt_titulo_carpeta").val();
    var id_usuario = $("#txtidusuario").val();

    if ( !titulo_carpeta) {
        Swal.fire("Mensaje De Advertencia", "Carpeta sin nombre","warning");
        return; // Añadimos este return para salir de la función si los datos están vacíos
    }

    $.ajax({
        url:"../controlador/material/controlador_nueva_carpeta_material.php",
        type:"POST",
        data:{
            titulo_carpeta:titulo_carpeta,
            id_usuario:id_usuario
        }
    }).done(function (resp) {
        if (resp != "") {
            // Comprobamos si la respuesta es -1, que indica que el chat ya existe
            if (resp == -1) {
                Swal.fire("Mensaje De Advertencia", "Ya creaste una carpeta con ese nombre. Por favor, seleccione otro nombre.", "warning");
                return;
            }
    
            // Comprobamos si la respuesta es 1, que indica que se registró correctamente
            if (resp == 1) {
                Swal.fire("Mensaje De Confirmacion", "Nueva carpeta creada", "success")
                    .then((value) => {
                        $("#modal_nueva_carpeta").modal('hide');
                        listar_carpeta_materiales();
                    });
                return;
            }
        }
        
        // Si la respuesta no es -1 ni 1, mostramos mensaje de error
        Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
    });
}


function editar_carpeta_material(){
    var id_carpeta = $("#id_editar_carpeta").val();
    var titulo_carpeta = $("#txt_titulo_carpeta_editar").val();
    var id_usuario = $("#txtidusuario").val();

    if ( !titulo_carpeta) {
        Swal.fire("Mensaje De Advertencia", "Carpeta sin nombre","warning");
        return; // Añadimos este return para salir de la función si los datos están vacíos
    }

    $.ajax({
        url:"../controlador/material/controlador_editar_carpeta_material.php",
        type:"POST",
        data:{
            id_carpeta:id_carpeta,
            titulo_carpeta:titulo_carpeta,
            id_usuario:id_usuario
        }
    }).done(function (resp) {
        if (resp != "") {
            // Comprobamos si la respuesta es -1, que indica que el chat ya existe
            if (resp == -1) {
                Swal.fire("Mensaje De Advertencia", "Ya creaste una carpeta con ese nombre. Por favor, seleccione otro nombre.", "warning");
                return;
            }
    
            // Comprobamos si la respuesta es 1, que indica que se registró correctamente
            if (resp == 1) {
                Swal.fire("Mensaje De Confirmacion", "Carpeta editada", "success")
                    .then((value) => {
                        $("#modal_editar_carpeta").modal('hide');
                        listar_carpeta_materiales();
                    });
                return;
            }
        }
        
        // Si la respuesta no es -1 ni 1, mostramos mensaje de error
        Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
    });
}



function enviar_archivo() {
    var titulo_material = $("#txt_titulo_material").val();
    var id_material = $("#id_carpeta").val();
    var archivoInput = $("#txt_archivo_subir")[0];
    var archivo = archivoInput.files[0];

  // Verificar si id_chat y mensaje están vacíos
  if (!titulo_material) {
    Swal.fire("Mensaje De Advertencia", "Material de apoyo sin nombre", "warning");
    return; // Salir de la función si los datos están vacíos
}

    if (!archivo) {
        return Swal.fire("Mensaje De Advertencia", "Adjunte el archivo", "warning");
    }


    // Extensiones permitidas
    var extensionesPermitidas = ["pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx"];
    var extension = archivo.name.split('.').pop().toLowerCase();

    if (extensionesPermitidas.indexOf(extension) === -1) {
        return Swal.fire("Mensaje De Advertencia", "Solo se permiten archivos PDF, Word, Excel y PowerPoint", "warning");
    }

    var caracteresNoDeseados = [":", ",", ";", "!"];

    // Generar un nombre de archivo aleatorio
    var fecha = new Date();
    var nombreAleatorio = Math.random().toString(36).substring(7);
    var nombrearchivo = nombreAleatorio + "_" + fecha.getDate() + "" + (fecha.getMonth() + 1) + "" + fecha.getFullYear() + "" + fecha.getMinutes() + "" + fecha.getMilliseconds() + "." + extension;

    // Reemplazar los caracteres no deseados con "_"
    caracteresNoDeseados.forEach(function(caracter) {
        nombrearchivo = nombrearchivo.replace(new RegExp("\\" + caracter, "g"), "_");
    });

    var formData = new FormData();
    formData.append('titulo_material', titulo_material);
    formData.append('id_material', id_material);
    formData.append('nombrearchivo', nombrearchivo);
    formData.append('archivo', archivo);

    $.ajax({
        url: "../controlador/material/controlador_nuevo_material_archivo.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(resp) {
            if (resp > 0) {
                Swal.fire("Mensaje de Confirmación", "Material agregado correctamente", "success").then((value) => {
                    $("#modal_nuevo_material").modal('hide');
                    listar_materiales();
                });
            } else {
                Swal.fire("Mensaje De Error", "No se pudo agregar el material", "error");
            }
        }
    });

    return false;
}



function editar_archivo() {
    var titulo_material = $("#txt_titulo_material_editar").val();
    var id_material = $("#id_editar_material").val();
    var archivo_actual = $("#txt_archivo_material_actual").val(); 

    // Verificar si el título del material está vacío
    if (!titulo_material) {
        Swal.fire("Mensaje De Advertencia", "Material de apoyo sin nombre", "warning");
        return; // Salir de la función si el título está vacío
    }

    // Obtener el archivo seleccionado si existe
    var archivoInput = $("#txt_archivo_subir_editar")[0];
    var archivo = null;
    if (archivoInput.files.length > 0) {
        archivo = archivoInput.files[0];

        // Extensiones permitidas
        var extensionesPermitidas = ["pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx"];
        var extension = archivo.name.split('.').pop().toLowerCase();

        if (extensionesPermitidas.indexOf(extension) === -1) {
            return Swal.fire("Mensaje De Advertencia", "Solo se permiten archivos PDF, Word, Excel y PowerPoint", "warning");
        }

        var caracteresNoDeseados = [":", ",", ";", "!"];

        // Generar un nombre de archivo aleatorio
        var fecha = new Date();
        var nombreAleatorio = Math.random().toString(36).substring(7);
        var nombrearchivo = nombreAleatorio + "_" + fecha.getDate() + "" + (fecha.getMonth() + 1) + "" + fecha.getFullYear() + "" + fecha.getMinutes() + "" + fecha.getMilliseconds() + "." + extension;

        // Reemplazar los caracteres no deseados con "_"
        caracteresNoDeseados.forEach(function(caracter) {
            nombrearchivo = nombrearchivo.replace(new RegExp("\\" + caracter, "g"), "_");
        });
    }

    var formData = new FormData();
    formData.append('titulo_material', titulo_material);
    formData.append('id_material', id_material);
    formData.append('archivo_actual', archivo_actual);


    // Agregar el archivo al formData si existe
    if (archivo) {
        formData.append('nombrearchivo', nombrearchivo);
        formData.append('archivo', archivo);
    }

    $.ajax({
        url: "../controlador/material/controlador_editar_material_archivo.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(resp) {
            if (resp > 0) {
                Swal.fire("Mensaje de Confirmación", "Material editado correctamente", "success").then((value) => {
                    $("#modal_editar_material").modal('hide');
                    listar_materiales();
                });
            } else {
                Swal.fire("Mensaje De Error", "No se pudo editar el material", "error");
            }
        }
    });

    return false;
}



function eliminarMaterial(idMaterial, nombreArchivo) {
    // Asignar el nombre del archivo al campo oculto
  
  $("#txt_archivo_material_actual_eliminar").val(nombreArchivo);

    var archivo_actual = $("#txt_archivo_material_actual_eliminar").val(); 
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Este material de apoyo será eliminado permanentemente.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "../controlador/material/controlador_eliminar_material.php",
                type: "POST",
                data: {
                    id_material: idMaterial,
                    archivo_actual: archivo_actual 
                }
            }).done(function(resp) {
                if (resp == 1) {
                    Swal.fire("Mensaje de Confirmación", "Material eliminado correctamente", "success").then((value) => {
                        listar_materiales();
                    });
                } else {
                    Swal.fire("Mensaje De Error", "No se pudo eliminar el material", "error");
                }
            }).fail(function() {
                Swal.fire("Mensaje De Error", "No se pudo completar la solicitud", "error");
            });
        }
    });
}

function obtenerNombreArchivo(rutaCompleta) {
    return rutaCompleta.split("/").pop();
}


//--------------------material de apoyo-------------------------

function listar_datos_docente_materiales() {
    var id_usuario_es = $("#txtidusuario").val();

    $.ajax({
        url: "../controlador/material/controlador_listar_datos_docente_materiales.php",
        type: "POST",
        data: {
            id_usuario_es: id_usuario_es
        }
    }).done(function(resp) {
        let data = JSON.parse(resp);

        // Limpia el contenido actual antes de mostrar los nuevos datos
        $("#lista_datos_docente_materiales").empty();

        if (data.data.length > 0) {
            var docenteActual = ""; // Variable para almacenar el nombre del docente actual

            data.data.forEach(function(item, index) {
                // Verifica si el nombre del docente actual es diferente al nombre del docente en este item
                if (item.docente !== docenteActual) {
                    // Si es diferente, actualiza el nombre del docente y agrega el elemento HTML del docente
                    docenteActual = item.docente;
                    var elementoDocenteHTML = 
                        '<h3 class="widget-user-username">' + item.docente + '</h3>' +
                        '</div>';

                    $("#lista_datos_docente_materiales").append(elementoDocenteHTML);
                }

                // Agrega el nombre de la materia asociada con este docente
                var elementoMateriaHTML = '<div class="widget-user-desc-container">' +
                                            '<h5 class="widget-user-desc">' + item.nombre + '</h5>' +
                                          '</div>';

                $("#lista_datos_docente_materiales").append(elementoMateriaHTML);
                // Actualiza la imagen del usuario si hay una URL proporcionada en el campo 'foto'
                if (item.foto) {
                    var fotoURL = "../" + item.foto; // Concatena "../" con la URL de la foto
                    // Encuentra el elemento de imagen y actualiza el atributo 'src'
                    $("#user-avatar").attr("src", fotoURL);
                }
            });
        }
    });
}


function listar_carpeta_materiales() {
    var id_usuario_es = $("#txtidusuario").val();

    $.ajax({
        url: "../controlador/material/controlador_listar_carpeta_materiales.php",
        type: "POST",
        data: {
            id_usuario_es: id_usuario_es
        }
    }).done(function(resp) {
        let data = JSON.parse(resp);

        // Limpia el contenido actual antes de mostrar los nuevos datos
        $("#lista_carpeta_materiales").empty();

        if (data.data.length > 0) {
            data.data.forEach(function(item, index) {
                // Agrega el título de la carpeta junto con los botones para ver y editar los materiales
                var elementoCarpetaHTML = '<li>' +
                    '<a style="display: flex; justify-content: space-between;">' +
                    '<span style="word-wrap: break-word; max-width: calc(100% - 100px); margin-right: 10px;">' + item.titulo + '</span>' +
                    '<span>' +
                    '<button class="btn btn-primary custom-btn" style="width: 100px; height: 23px; font-size: 12px; padding: 1px;" onclick="mostrarIdCarpeta(' + item.ID + ', \'' + item.titulo + '\')">Ver Materiales</button>' +
                    '<button class="btn btn-success custom-btn" style="width: 60px; height: 23px; font-size: 12px; padding: 1px; margin-left: 5px;" onclick="editarCarpeta(' + item.ID + ', \'' + item.titulo + '\')">Editar</button>' +
                    '</span>' +
                    '</a>' +
                    '</li>';

                $("#lista_carpeta_materiales").append(elementoCarpetaHTML);
            });
        }
    });
}


function mostrarIdCarpeta(idCarpeta, tituloCarpeta) {
    // Mostrar la ID de la carpeta en el input
    $("#id_carpeta").val(idCarpeta);
    
    // Mostrar el título en el <h3>
    $("#titulo_carpeta").text("Materiales de apoyo: " + tituloCarpeta);

    listar_materiales();

    // Verificar el ancho de la pantalla antes de ejecutar la animación
    var screenWidth = $(window).width();
    if (screenWidth <= 576) { // Extra small devices (telefonos) - menor o igual a 576px
        // En dispositivos extra pequeños (telefonos), no se ejecuta la animación y se muestra el div directamente
        $("#div_oculto").css("display", "block");
    } else if (screenWidth <= 768) { // Small devices (tabletas) - menor o igual a 768px
        // En dispositivos pequeños (tabletas), no se ejecuta la animación y se muestra el div directamente
        $("#div_oculto").css("display", "block");
    } else if (screenWidth <= 992) { // Medium devices (desktops, laptops) - menor o igual a 992px
        // En dispositivos medianos (escritorios, laptops), se ejecuta la animación con un ancho equivalente a col-md-5
        $("#contenedor-columnas").animate({
            width: "41.20000%"
        }, 500, function() {
            // Una vez que la animación de cambio de columnas ha terminado, hacemos visible el div oculto
            $("#div_oculto").css("display", "block");
        });
    } else if (screenWidth <= 1200) { // Large devices (escritorios grandes) - menor o igual a 1200px
        // En dispositivos grandes (escritorios grandes), también se ejecuta la animación con un ancho equivalente a col-md-5
        $("#contenedor-columnas").animate({
            width: "41.20000%"
        }, 500, function() {
            // Una vez que la animación de cambio de columnas ha terminado, hacemos visible el div oculto
            $("#div_oculto").css("display", "block");
        });
    } else {
        // En dispositivos aún mayores, se ejecuta la animación con un ancho equivalente a col-md-5
        $("#contenedor-columnas").animate({
            width: "41.20000%"
        }, 500, function() {
            // Una vez que la animación de cambio de columnas ha terminado, hacemos visible el div oculto
            $("#div_oculto").css("display", "block");
        });
    }
}






// Evento clic para el botón que tiene la clase btn-box-tool
$(".btn-box-tool").click(function() {
    // Ocultamos el div oculto con una animación de abajo hacia arriba
    $("#div_oculto").animate({
        height: 0
    }, 500, function() {
        $(this).css("display", "none"); // Una vez que la animación de ocultar ha terminado, ocultamos el div
    });

    // Agregamos un retraso de 5 milisegundos antes de animar el cambio de estructura de columnas
    $("#contenedor-columnas").delay(500).animate({
        width: "100%" // Ancho original del contenedor
    }, 500);
});


function editarCarpeta(idCarpeta, tituloCarpeta) {
    // Asigna el ID de la carpeta al campo correspondiente del modal
    $("#id_editar_carpeta").val(idCarpeta);
    
    // Asigna el título de la carpeta al campo correspondiente del modal
    $("#txt_titulo_carpeta_editar").val(tituloCarpeta);
    
    // Abre el modal
    $("#modal_editar_carpeta").modal("show");
}

function obtenerNombreArchivo(url) {
    // Divide la URL por las barras diagonales y toma la última parte, que debería ser el nombre del archivo
    var partes = url.split('/');
    return partes[partes.length - 1];
}

function listar_materiales() {
    var id_materiales = $("#id_carpeta").val();

    $.ajax({
        url: "../controlador/material/controlador_listar_materiales.php",
        type: "POST",
        data: {
            id_materiales: id_materiales
        }
    }).done(function(resp) {
        let data = JSON.parse(resp);

        $("#lista_materiales").empty();

        if (data.hasOwnProperty('data') && data.data.length > 0) {
            data.data.forEach(function(item, index) {
                var filaMaterialHTML = '<tr>' +
                '<td>' + item.titulo + '</td>' +
                '<td><span class="label label-success">' + item.estado + '</span></td>' +
                '<td><a href="../' + item.archivo + '" download="' + obtenerNombreArchivo(item.archivo) + '">Descargar material</a></td>' +
                '<td>' +
                '<button type="button" class="btn btn-primary btn-sm" onclick="editarMaterial(' + item.ID + ', \'' + item.titulo + '\', \'' + item.archivo + '\')"><i class="fa fa-edit"></i></button>&nbsp;' +
                '<button type="button" class="btn btn-danger btn-sm" onclick="eliminarMaterial(' + item.ID + ', \'' + obtenerNombreArchivo(item.archivo) + '\')"><i class="fa fa-trash-o"></i></button>'
                '</td>' +
                '</tr>';
            
                $("#lista_materiales").append(filaMaterialHTML);
            });
        } else {
            // Mostrar mensaje de carpeta vacía sin espacios adicionales
            $("#lista_materiales").html('<tr><td colspan="4"><div class="alert alert-warning" style="margin-bottom: 0;">Carpeta vacía</div></td></tr>');
        }
    }).fail(function() {
        // Si falla la solicitud, mostrar un mensaje de error sin espacios adicionales
        $("#lista_materiales").html('<tr><td colspan="4"><div class="alert alert-danger" style="margin-bottom: 0;">Error al cargar los datos</div></td></tr>');
    });
}


function editarMaterial(idMaterial, tituloMaterial, archivoMaterial) {
    // Extraer el nombre del archivo de la ruta completa
    var partesRuta = archivoMaterial.split("\\");
    var nombreArchivo = partesRuta[partesRuta.length - 1];

    // Asigna la información al modal
    $("#id_editar_material").val(idMaterial);
    $("#txt_titulo_material_editar").val(tituloMaterial);
    $("#txt_archivo_material_actual").val(nombreArchivo); // Muestra solo el nombre del archivo
    $("#archivo_material_actual").attr("data-archivo", archivoMaterial); // Guarda el nombre del archivo completo en un atributo de datos

    // Abre el modal
    $("#modal_editar_material").modal("show");
}


// -----------------------------------------estudiantes----------------------------------

$(document).ready(function() {
    // Evento que se dispara cuando se hace clic en el botón para ejecutar las funciones
    $("#btn_filtrar_material_docente").click(function() {
        // Llama a la función para listar los datos del docente
        listar_datos_docente_materiales_es();
        // Llama a la función para listar las carpetas de materiales del docente
        listar_carpeta_materiales_es();
    });

function listar_datos_docente_materiales_es() {
    var id_usuario_es = $("#cbm_docente").val();

    $.ajax({
        url: "../controlador/material/controlador_listar_datos_docente_materiales.php",
        type: "POST",
        data: {
            id_usuario_es: id_usuario_es
        }
    }).done(function(resp) {
        let data = JSON.parse(resp);

        // Limpia el contenido actual antes de mostrar los nuevos datos
        $("#lista_datos_docente_materiales").empty();

        if (data.data.length > 0) {
            var docenteActual = ""; // Variable para almacenar el nombre del docente actual

            data.data.forEach(function(item, index) {
                // Verifica si el nombre del docente actual es diferente al nombre del docente en este item
                if (item.docente !== docenteActual) {
                    // Si es diferente, actualiza el nombre del docente y agrega el elemento HTML del docente
                    docenteActual = item.docente;
                    var elementoDocenteHTML = 
                        '<h3 class="widget-user-username">' + item.docente + '</h3>' +
                        '</div>';

                    $("#lista_datos_docente_materiales").append(elementoDocenteHTML);
                }

                // Agrega el nombre de la materia asociada con este docente
                var elementoMateriaHTML = '<div class="widget-user-desc-container">' +
                                            '<h5 class="widget-user-desc">' + item.nombre + '</h5>' +
                                          '</div>';

                $("#lista_datos_docente_materiales").append(elementoMateriaHTML);
                // Actualiza la imagen del usuario si hay una URL proporcionada en el campo 'foto'
                if (item.foto) {
                    var fotoURL = "../" + item.foto; // Concatena "../" con la URL de la foto
                    // Encuentra el elemento de imagen y actualiza el atributo 'src'
                    $("#user-avatar").attr("src", fotoURL);
                }
            });
        }
    });
}


function listar_carpeta_materiales_es() {
    var id_usuario_es = $("#cbm_docente").val();

    $.ajax({
        url: "../controlador/material/controlador_listar_carpeta_materiales.php",
        type: "POST",
        data: {
            id_usuario_es: id_usuario_es
        }
    }).done(function(resp) {
        let data = JSON.parse(resp);

        // Limpia el contenido actual antes de mostrar los nuevos datos
        $("#lista_carpeta_materiales").empty();

        if (data.data.length > 0) {
            data.data.forEach(function(item, index) {
                // Agrega el título de la carpeta junto con los botones para ver y editar los materiales
                var elementoCarpetaHTML = '<li>' +
                    '<a style="display: flex; justify-content: space-between;">' +
                    '<span style="word-wrap: break-word; max-width: calc(100% - 100px); margin-right: 10px;">' + item.titulo + '</span>' +
                    '<span>' +
                    '<button class="btn btn-primary custom-btn" style="width: 100px; height: 23px; font-size: 12px; padding: 1px;" onclick="mostrarIdCarpetaES(' + item.ID + ', \'' + item.titulo + '\')">Ver Materiales</button>' +
                    '</span>' +
                    '</a>' +
                    '</li>';

                $("#lista_carpeta_materiales").append(elementoCarpetaHTML);
            });
        }
    });
}
});


function mostrarIdCarpetaES(idCarpeta, tituloCarpeta) {
    // Mostrar la ID de la carpeta en el input
    $("#id_carpeta").val(idCarpeta);
    
    // Mostrar el título en el <h3>
    $("#titulo_carpeta").text("Materiales de apoyo: " + tituloCarpeta);

    listar_materiales_es();

    // Verificar el ancho de la pantalla antes de ejecutar la animación
    var screenWidth = $(window).width();
    if (screenWidth <= 576) { // Extra small devices (telefonos) - menor o igual a 576px
        // En dispositivos extra pequeños (telefonos), no se ejecuta la animación y se muestra el div directamente
        $("#div_oculto").css("display", "block");
    } else if (screenWidth <= 768) { // Small devices (tabletas) - menor o igual a 768px
        // En dispositivos pequeños (tabletas), no se ejecuta la animación y se muestra el div directamente
        $("#div_oculto").css("display", "block");
    } else if (screenWidth <= 992) { // Medium devices (desktops, laptops) - menor o igual a 992px
        // En dispositivos medianos (escritorios, laptops), se ejecuta la animación con un ancho equivalente a col-md-5
        $("#contenedor-columnas").animate({
            width: "41.20000%"
        }, 500, function() {
            // Una vez que la animación de cambio de columnas ha terminado, hacemos visible el div oculto
            $("#div_oculto").css("display", "block");
        });
    } else if (screenWidth <= 1200) { // Large devices (escritorios grandes) - menor o igual a 1200px
        // En dispositivos grandes (escritorios grandes), también se ejecuta la animación con un ancho equivalente a col-md-5
        $("#contenedor-columnas").animate({
            width: "41.20000%"
        }, 500, function() {
            // Una vez que la animación de cambio de columnas ha terminado, hacemos visible el div oculto
            $("#div_oculto").css("display", "block");
        });
    } else {
        // En dispositivos aún mayores, se ejecuta la animación con un ancho equivalente a col-md-5
        $("#contenedor-columnas").animate({
            width: "41.20000%"
        }, 500, function() {
            // Una vez que la animación de cambio de columnas ha terminado, hacemos visible el div oculto
            $("#div_oculto").css("display", "block");
        });
    }
}



function listar_materiales_es() {
    var id_materiales = $("#id_carpeta").val();

    $.ajax({
        url: "../controlador/material/controlador_listar_materiales.php",
        type: "POST",
        data: {
            id_materiales: id_materiales
        }
    }).done(function(resp) {
        let data = JSON.parse(resp);

        $("#lista_materiales").empty();

        if (data.hasOwnProperty('data') && data.data.length > 0) {
            data.data.forEach(function(item, index) {
                var filaMaterialHTML = '<tr>' +
                '<td>' + item.titulo + '</td>' +
                '<td><span class="label label-success">' + item.estado + '</span></td>' +
                '<td><a href="../' + item.archivo + '" download="' + obtenerNombreArchivo(item.archivo) + '">Descargar material</a></td>' +
                '</tr>';
            
                $("#lista_materiales").append(filaMaterialHTML);
            });
        } else {
            // Mostrar mensaje de carpeta vacía sin espacios adicionales
            $("#lista_materiales").html('<tr><td colspan="4"><div class="alert alert-warning" style="margin-bottom: 0;">Carpeta vacía</div></td></tr>');
        }
    }).fail(function() {
        // Si falla la solicitud, mostrar un mensaje de error sin espacios adicionales
        $("#lista_materiales").html('<tr><td colspan="4"><div class="alert alert-danger" style="margin-bottom: 0;">Error al cargar los datos</div></td></tr>');
    });
}
// -----------------------------------------Fecha limite foro----------------------------------

function TraerfechaM() {
    var data = "2023-11-23";
    const local = new Date();
    const weekInMilliseconds = 7 * 24 * 60 * 60 * 1000; // Una semana en milisegundos
    var aWeekAfterData = new Date(data);
    aWeekAfterData.setTime(aWeekAfterData.getTime() + weekInMilliseconds); // Incrementa la fecha en una semana

    if (local >= aWeekAfterData) { // Compara si la fecha actual es una semana después de la fecha establecida
        actualizar_estado();
    }
}

function actualizar_estado() {
    $.ajax({
        url: "../controlador/material/controlador_editar_estado_material.php",
        type: "POST"
    });
}



    function mostrarNuevaImagen() {
        var userAvatarContainer = document.getElementById('user-avatar-container');
        var userAvatar = document.getElementById('user-avatar');

        // Mostrar el contenedor
        userAvatarContainer.style.display = 'block';
    }

