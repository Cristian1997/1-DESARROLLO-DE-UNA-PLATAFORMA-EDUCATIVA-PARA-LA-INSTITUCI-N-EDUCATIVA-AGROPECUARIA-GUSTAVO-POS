
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

            $("#cbm_docente").change(function() {
                $("#txtiddocente").val($(this).val());
                listar_datos_docente_materiales_es();
                listar_carpeta_materiales_es();
            });

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_docente").html(cadena);
        }
    });
}

  $("#cbm_docente").change(function() {
    $("#txtiddocente").val($(this).val());
    listar_datos_docente_materiales_es();
    listar_carpeta_materiales_es();
});
//-----------------registrar editar--------------------------------



function crear_carpeta_material(){
    var titulo_carpeta = $("#txt_titulo_carpeta").val();
    var id_usuario = $("#txtidusuario").val();

    if ( !titulo_carpeta) {
        Swal.fire("Mensaje De Advertencia", "Carpeta sin nombre","warning");
        return;
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
            if (resp == -1) {
                Swal.fire("Mensaje De Advertencia", "Ya creaste una carpeta con ese nombre. Por favor, seleccione otro nombre.", "warning");
                return;
            }
    
            if (resp == 1) {
                Swal.fire("Mensaje De Confirmacion", "Nueva carpeta creada", "success")
                    .then((value) => {
                        $("#modal_nueva_carpeta").modal('hide');
                        listar_carpeta_materiales();
                    });
                return;
            }
        }
        
        Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
    });
}


function editar_carpeta_material(){
    var id_carpeta = $("#id_editar_carpeta").val();
    var titulo_carpeta = $("#txt_titulo_carpeta_editar").val();
    var id_usuario = $("#txtidusuario").val();

    if ( !titulo_carpeta) {
        Swal.fire("Mensaje De Advertencia", "Carpeta sin nombre","warning");
        return; 
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
            if (resp == -1) {
                Swal.fire("Mensaje De Advertencia", "Ya creaste una carpeta con ese nombre. Por favor, seleccione otro nombre.", "warning");
                return;
            }
    
            if (resp == 1) {
                Swal.fire("Mensaje De Confirmacion", "Carpeta editada", "success")
                    .then((value) => {
                        $("#modal_editar_carpeta").modal('hide');
                        listar_carpeta_materiales();
                    });
                return;
            }
        }
        
        Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
    });
}



function enviar_archivo() {
    var titulo_material = $("#txt_titulo_material").val();
    var id_material = $("#id_carpeta").val();
    var archivoInput = $("#txt_archivo_subir")[0];
    var archivo = archivoInput.files[0];

  if (!titulo_material) {
    Swal.fire("Mensaje De Advertencia", "Material de apoyo sin nombre", "warning");
    return;
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
        return; 
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

        $("#lista_datos_docente_materiales").empty();

        if (data.data.length > 0) {
            var docenteActual = "";

            data.data.forEach(function(item, index) {
                if (item.docente !== docenteActual) {
                    docenteActual = item.docente;
                    var elementoDocenteHTML = 
                        '<h3 class="widget-user-username">' + item.docente + '</h3>' +
                        '</div>';

                    $("#lista_datos_docente_materiales").append(elementoDocenteHTML);
                }

                var elementoMateriaHTML = '<div class="widget-user-desc-container">' +
                                            '<h5 class="widget-user-desc">' + item.nombre + '</h5>' +
                                          '</div>';

                $("#lista_datos_docente_materiales").append(elementoMateriaHTML);
                if (item.foto) {
                    var fotoURL = "../" + item.foto; 
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

        $("#lista_carpeta_materiales").empty();

        if (data.data.length > 0) {
            data.data.forEach(function(item, index) {
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
    $("#id_carpeta").val(idCarpeta);
    
    $("#titulo_carpeta").text("Materiales de apoyo: " + tituloCarpeta);

    listar_materiales();

    var screenWidth = $(window).width();
    if (screenWidth <= 576) { 
        $("#div_oculto").css("display", "block");
    } else if (screenWidth <= 768) { 
        $("#div_oculto").css("display", "block");
    } else if (screenWidth <= 992) { 
        $("#contenedor-columnas").animate({
            width: "41.20000%"
        }, 500, function() {
            $("#div_oculto").css("display", "block");
        });
    } else if (screenWidth <= 1200) {
        $("#contenedor-columnas").animate({
            width: "41.20000%"
        }, 500, function() {
            $("#div_oculto").css("display", "block");
        });
    } else {
        $("#contenedor-columnas").animate({
            width: "41.20000%"
        }, 500, function() {
            $("#div_oculto").css("display", "block");
        });
    }
}






$(".btn-box-tool").click(function() {
    $("#div_oculto").animate({
        height: 0
    }, 500, function() {
        $(this).css("display", "none"); 
    });

    $("#contenedor-columnas").delay(500).animate({
        width: "100%" 
    }, 500);
});


function editarCarpeta(idCarpeta, tituloCarpeta) {
    $("#id_editar_carpeta").val(idCarpeta);
    
    $("#txt_titulo_carpeta_editar").val(tituloCarpeta);
    
    $("#modal_editar_carpeta").modal("show");
}

function obtenerNombreArchivo(url) {
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
            $("#lista_materiales").html('<tr><td colspan="4"><div class="alert alert-warning" style="margin-bottom: 0;">Carpeta vacía</div></td></tr>');
        }
    }).fail(function() {
        $("#lista_materiales").html('<tr><td colspan="4"><div class="alert alert-danger" style="margin-bottom: 0;">Error al cargar los datos</div></td></tr>');
    });
}


function editarMaterial(idMaterial, tituloMaterial, archivoMaterial) {
    var partesRuta = archivoMaterial.split("\\");
    var nombreArchivo = partesRuta[partesRuta.length - 1];

    $("#id_editar_material").val(idMaterial);
    $("#txt_titulo_material_editar").val(tituloMaterial);
    $("#txt_archivo_material_actual").val(nombreArchivo); 
    $("#archivo_material_actual").attr("data-archivo", archivoMaterial);

    $("#modal_editar_material").modal("show");
}


// -----------------------------------------estudiantes----------------------------------

$(document).ready(function() {
    $("#btn_filtrar_material_docente").click(function() {
        listar_datos_docente_materiales_es();
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

        $("#lista_datos_docente_materiales").empty();

        if (data.data.length > 0) {
            var docenteActual = "";

            data.data.forEach(function(item, index) {
                if (item.docente !== docenteActual) {
                    docenteActual = item.docente;
                    var elementoDocenteHTML = 
                        '<h3 class="widget-user-username">' + item.docente + '</h3>' +
                        '</div>';

                    $("#lista_datos_docente_materiales").append(elementoDocenteHTML);
                }

                var elementoMateriaHTML = '<div class="widget-user-desc-container">' +
                                            '<h5 class="widget-user-desc">' + item.nombre + '</h5>' +
                                          '</div>';

                $("#lista_datos_docente_materiales").append(elementoMateriaHTML);
                if (item.foto) {
                    var fotoURL = "../" + item.foto; 
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

        $("#lista_carpeta_materiales").empty();

        if (data.data.length > 0) {
            data.data.forEach(function(item, index) {
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
    $("#id_carpeta").val(idCarpeta);
    
    $("#titulo_carpeta").text("Materiales de apoyo: " + tituloCarpeta);

    listar_materiales_es();

    var screenWidth = $(window).width();
    if (screenWidth <= 576) { 
        $("#div_oculto").css("display", "block");
    } else if (screenWidth <= 768) { 
        $("#div_oculto").css("display", "block");
    } else if (screenWidth <= 992) { 
        $("#contenedor-columnas").animate({
            width: "41.20000%"
        }, 500, function() {
            $("#div_oculto").css("display", "block");
        });
    } else if (screenWidth <= 1200) { 
        $("#contenedor-columnas").animate({
            width: "41.20000%"
        }, 500, function() {
            $("#div_oculto").css("display", "block");
        });
    } else {
        $("#contenedor-columnas").animate({
            width: "41.20000%"
        }, 500, function() {
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
            $("#lista_materiales").html('<tr><td colspan="4"><div class="alert alert-warning" style="margin-bottom: 0;">Carpeta vacía</div></td></tr>');
        }
    }).fail(function() {
        $("#lista_materiales").html('<tr><td colspan="4"><div class="alert alert-danger" style="margin-bottom: 0;">Error al cargar los datos</div></td></tr>');
    });
}
// -----------------------------------------Fecha limite foro----------------------------------

function TraerfechaM() {
    var data = "2023-11-23";
    const local = new Date();
    const weekInMilliseconds = 7 * 24 * 60 * 60 * 1000; 
    var aWeekAfterData = new Date(data);
    aWeekAfterData.setTime(aWeekAfterData.getTime() + weekInMilliseconds); 

    if (local >= aWeekAfterData) { 
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

        
        userAvatarContainer.style.display = 'block';
    }

