//-------------TABLA FORO-----------------------

var tabla_foro;
function listar_foros(id_grado, id_asignatura) {
    var id_usuario_doc = $("#txtidusuario").val();
    var id_asignatura = $("#cbm_grupo").val();

    if (id_grado == null || id_asignatura == null) {
        id_grado = 1;
        id_asignatura = 1;
    }
    tabla_foro = $("#tabla_foro").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/foro/controlador_foro_listar.php",
            type: 'POST',
            data: {
                id_usuario_doc: id_usuario_doc,
                id_asignatura: id_asignatura,
                id_grado: id_grado
            }
        },

        "columns": [
            { "defaultContent": "" },
            { "data": "titulo" },
            {
                "data": "foro_estado",
                render: function (data, type, row) {
                    if (data == 'ACTIVO') {
                        return "<span class='label label-success'>" + data + "</span>";
                    } else {
                        return "<span class='label label-danger'>" + data + "</span>";
                    }
                }
            },
            { "data": "fecha" },

            { "defaultContent": "<button style='font-size:13px;' type='button' class='editar_fecha btn btn-success'><i class='fa fa-calendar-plus-o'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='editar_foro btn btn-primary'><i class='fa fa-edit'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='ver_foro btn btn-primary'><i class='fa fa-comments'></i></button>" }
        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_foro_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });
    tabla_foro.on('draw.dt', function () {
        var PageInfo = $('#tabla_foro').DataTable().page.info();
        tabla_foro.column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });
}

// ---------------------------modales----------------------------------

$('#tabla_foro').on('click', '.AbrirModalRegistro', function () {
    var data = tabla_foro.row($(this).parents('tr')).data();
    if (tabla_foro.row(this).child.isShown()) {
        var data = tabla_foro.row(this).data();
    }

    $("#modal_registro").modal({
        backdrop: 'static',
        keyboard: false
    })

    $("#modal_registro").modal('show');


});

function decodeEntities(encodedString) {
    var textArea = document.createElement('textarea');
    textArea.innerHTML = encodedString;
    return textArea.value;
}

$('#tabla_foro').on('click', '.editar_foro', function () {
    var data = tabla_foro.row($(this).parents('tr')).data();
    if (tabla_foro.row(this).child.isShown()) {
        var data = tabla_foro.row(this).data();
    }
    $("#modal_editar").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_editar").modal('show');
    $("#id_foro").val(data.ID).hide();
    $("#cbm_grupo_editar").val(data.id_grupo).trigger('change');
    $("#titulo_foro_editar").val(decodeEntities(data.titulo));
    $("#descripcion_foro_editar").val(decodeEntities(data.descripcion));
});

$('#tabla_foro').on('click', '.editar_fecha', function () {
    var data = tabla_foro.row($(this).parents('tr')).data();
    if (tabla_foro.row(this).child.isShown()) {
        var data = tabla_foro.row(this).data();
    }
    $("#modal_fecha").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_fecha").modal('show');
    $('#id_foros').val(data.ID).hide();
    $("#fecha_editar").val(data.fecha);
});

// ---------------------------Funciones de registro y editar ----------------------------------

function registrar_foro() {
    var fecha_limite = $("#fecha").val();
    var tema_foro = $("#titulo_foro").val();
    var descripcion_foro = $("#descripcion_foro").val();
    var id_grupo = $("#cbm_grupos").val();
    var id_docente = $("#id_docente_verifity").val();
    if (fecha_limite.length == 0 || tema_foro.length == 0 || descripcion_foro.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }
    $.ajax({
        url: "../controlador/foro/controlador_registro_foro.php",
        type: "POST",
        data: {
            fecha_limite: fecha_limite,
            tema_foro: tema_foro,
            descripcion_foro: descripcion_foro,
            id_grupo: id_grupo,
            id_docente: id_docente

        }
    }).done(function (resp) {
        if (resp > 0) {

            Swal.fire("Mensaje De Confirmacion", "Foro registrado Correctamente ", "success").then(value => {
                $("#modal_registro").modal('hide');

                tabla_foro.ajax.reload();


            });

        } else {
            Swal.fire("Mensaje De Error", "No se pudo registrar el foro", "error");
        }
    });

}

function registrar_comentario_foro() {
    var id_grupo = $("#txtidgrupo").val();
    var id_foro = $("#txtidforo").val();
    var id_docente = $("#id_docente_verifity").val();
    var comentario = $("#txt_comentario").val();

    if (comentario.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }
    $.ajax({
        url: "../controlador/foro/controlador_registro_comentario_foro.php",
        type: "POST",
        data: {

            id_foro: id_foro,
            id_grupo: id_grupo,
            id_docente: id_docente,
            comentario: comentario
        }
    }).done(function (resp) {
        if (resp > 0) {

            Swal.fire("Mensaje De Confirmacion", "Comentario registrado Correctamente ", "success").then(value => {


                recargarComentarios();

                $("#txt_comentario").val(""); // Limpiar el campo de comentario
            });

        } else {
            Swal.fire("Mensaje De Error", "No se pudo registrar el comentario", "error");
        }
    });

}

function registrar_comentario_foro_respuesta() {

    var id_foro = $("#id_foro_respuesta").val();
    var id_docente = $("#id_docente_verifity").val();
    var id_principal = $("#id_principal").val();
    var comentario = $("#txt_comentario_respuesta").val();
    var id_responde_a = $("#id_responde_a").val();
    if (comentario.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }
    $.ajax({
        url: "../controlador/foro/controlador_registro_comentario_foro_respuesta.php",
        type: "POST",
        data: {

            id_foro: id_foro,
            id_docente: id_docente,
            id_principal: id_principal,
            comentario: comentario,
            id_responde_a: id_responde_a
        }
    }).done(function (resp) {
        if (resp > 0) {

            Swal.fire("Mensaje De Confirmacion", "Respuesta registrada Correctamente ", "success").then(value => {

                recargarRespuestas(id_foro, id_principal, id_docente_verifity);

                $("#txt_comentario_respuesta").val(""); // Limpiar el campo de comentario
            });

        } else {
            Swal.fire("Mensaje De Error", "No se pudo registrar la respuesta", "error");
        }
    });

}

function editar_comentario_foro_respuesta() {

    var id_foro = $("#id_foro_respuesta").val();
    var id_principal = $("#id_principal").val();
    var id_foro_cometario = $("#txt_id_comentario_editar_respuesta").val();
    var comentario = $("#txt_comentario_respuesta").val();
    if (comentario.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }
    $.ajax({
        url: "../controlador/foro/controlador_foro_comentario_editar_respuesta.php",
        type: "POST",
        data: {
            id_foro_cometario: id_foro_cometario,
            comentario: comentario
        }
    }).done(function (resp) {
        if (resp > 0) {

            Swal.fire("Mensaje De Confirmacion", "Respuesta editada Correctamente ", "success").then(value => {

                $('#btnCancelarResponder').hide();
                $('#btnregistarrespuesta').show();

                $('#btnEditarrespuesta').hide();
                recargarRespuestas(id_foro, id_principal, id_docente_verifity);

                $("#txt_comentario_respuesta").val(""); // Limpiar el campo de comentario


            });

        } else {
            Swal.fire("Mensaje De Error", "No se pudo editar la respuesta", "error");
        }
    });
}

function editar_foro() {
    var id_foro = $("#id_foro").val();
    var tema_foro = $("#titulo_foro_editar").val();
    var descripcion_foro = $("#descripcion_foro_editar").val();
    var id_grupo = $("#cbm_grupo_editar").val();
    var id_docente = $("#id_docente_verifity").val();
    if (tema_foro.length == 0 || descripcion_foro.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }
    $.ajax({
        url: "../controlador/foro/controlador_foro_editar.php",
        type: "POST",
        data: {
            id_foro: id_foro,
            tema_foro: tema_foro,
            descripcion_foro: descripcion_foro,
            id_grupo: id_grupo,
            id_docente: id_docente

        }
    }).done(function (resp) {
        if (resp > 0) {

            Swal.fire("Mensaje De Confirmacion", "Foro registrado Correctamente ", "success").then(value => {
                $("#modal_editar").modal('hide');
                recargarComentarios();
                tabla_foro.ajax.reload();



            });

        } else {
            Swal.fire("Mensaje De Error", "No se pudo registrar el foro", "error");
        }
    });

}

function editar_comentario_foro() {
    var id_foro_cometario = $("#txt_id_comentario_editar").val();
    var comentario = $("#txt_comentario").val();
    if (comentario.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }
    $.ajax({
        url: "../controlador/foro/controlador_foro_comentario_editar.php",
        type: "POST",
        data: {
            id_foro_cometario: id_foro_cometario,
            comentario: comentario
        }
    }).done(function (resp) {
        if (resp > 0) {

            Swal.fire("Mensaje De Confirmacion", "Comentario editado Correctamente ", "success").then(value => {

                recargarComentarios();
                $('#btnregistar').show();
                $('#btnEditar').hide();
                $('#btnCancelarEditar').hide();

                $("#txt_comentario").val(""); // Limpiar el campo de comentario
            });

        } else {
            Swal.fire("Mensaje De Error", "No se pudo editar el comentario", "error");
        }
    });

}

function editar_fecha() {
    var id_foros = $("#id_foros").val();
    var fecha = $("#fecha_editar").val();
    var date;

    const monthNames = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
    const local = new Date();

    let day = local.getDate(),
        month = local.getMonth() + 1,  // Sumar 1 al mes actual
        year = local.getFullYear();
    date = `${year}-${month < 10 ? '0' + month : month}-${day < 10 ? '0' + day : day}`;

    if (fecha < date) {
        return Swal.fire("Mensaje De Advertencia", "La Fecha ingresada ---" + fecha + "--- es menor que la fecha actual ---" + date + "--- ", "warning");
    }

    $.ajax({
        url: "../controlador/foro/controlador_editar_fechas_foro.php",
        type: "POST",
        data: {
            id_foros: id_foros,
            fecha: fecha
        }
    }).done(function (resp) {
        if (resp > 0) {
            Swal.fire("Mensaje de Confirmación", "Fecha Modificada Correctamente", "success").then((value) => {
                $("#modal_fecha").modal('hide');
                tabla_foro.ajax.reload();
            });
        } else {
            Swal.fire("Mensaje De Error", "No se pudo Modificar la Fecha", "error");
        }
    });
}

// -------------------------------------Listar combos----------------------------------


function listar_combo_verificar_docente() {
    var id = $("#txtidusuario").val();
    $.ajax({
        url: "../controlador/calificaciones/controlador_combo_docente_verificar_listar.php",
        type: "POST",
        data: {
            id: id
        }
    }).done(function (resp) {
        let data = JSON.parse(resp);


        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                $("#id_docente_verifity").val(data[i][2])();

            }
        }
    })
}

function listar_combo_grupo() {
    var id = $("#txtidusuario").val();
    $.ajax({
        url: "../controlador/talleres/controlador_combo_grupo_listar.php",
        type: "POST",
        data: {
            id: id
        }
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + "Asignatura:  " + data[i][1] + "  --  " + "Grado: " + data[i][2] + " </option>";

            }
            $("#cbm_grupo").html(cadena);
            id = $("#cbm_grupo").val();
            listar_combo_grado(id);
            listar_combo_asignatura(id);

            if (id.length != '') {
                $("#cbm_grupo_listar").val(id).trigger("change");
            }

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_grupo").html(cadena);
        }
    })
}

function listar_combo_grupos() {
    var id = $("#txtidusuario").val();
    $.ajax({
        url: "../controlador/talleres/controlador_combo_grupo_listar.php",
        type: "POST",
        data: {
            id: id
        }
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + "Asignatura:  " + data[i][1] + "  --  " + "Grado: " + data[i][2] + " </option>";

            }
            $("#cbm_grupos").html(cadena);

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_grupos").html(cadena);

        }
    })
}

function listar_combo_materia() {
    var id = $("#txtidusuario").val();
    $.ajax({
        url: "../controlador/calificaciones/controlador_combo_materia_listar.php",
        type: "POST",
        data: {
            id: id
        }
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + "Asignatura:  " + data[i][1] + "  --  " + "Profesor: " + data[i][2] + " </option>";

            }
            $("#cbm_grupo").html(cadena);
            id = $("#cbm_grupo").val();
            listar_combo_grado(id);
            listar_combo_asignatura(id);

            if (id.length != '') {
                $("#cbm_grupo_listar").val(id).trigger("change");

            }

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_grupo").html(cadena);

        }
    })
}

function listar_combo_grado(id_grupo) {
    var id = $("#txtidusuario").val();
    if (id_grupo == null) {
        id_grupo = 1;
    }

    $.ajax({
        url: "../controlador/calificaciones/controlador_combo_grado_listar.php",
        type: "POST",
        data: {
            id: id,
            id_grupo: id_grupo
        }
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + " </option>";

            }
            $("#cbm_grado").html(cadena);

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_grado").html(cadena);

        }

    })
}

// -----------------------------------------Docente----------------------------------   

function datos() {

    var id_grado = $("#cbm_grado").val();
    var id_asignatura = $("#cbm_asignatura").val();
    var id_usuario_doc = $("#id_docente_verifity").val();
    listar_foros(id_grado, id_asignatura, id_usuario_doc);
}

$(document).ready(function () {
    // Función para mostrar los comentarios del foro seleccionado
    function comentarios_foro(id_foro, id_grupo, id_docente_verifity) {
        $.ajax({
            url: "../controlador/foro/controlador_foro_comentarios.php",
            type: "POST",
            data: {
                id_foro: id_foro,
                id_grupo: id_grupo
            }
        }).done(function (resp) {
            let data = JSON.parse(resp);
            var llenaData = "";
            var contador = data.length; // Contador de comentarios

            if (data.length > 0) {
                for (var i = 0; i < data.length; i++) {
                    // Verificar si el ID del docente coincide con el ID del comentario

                    var botonEliminar = '';
                    if (!$("#comentario_foro_area").attr("hidden") && id_docente_verifity === data[i].id_comentario) {
                        botonEliminar = '<button type="button" class="eliminar_comentario btn btn-default btn-xs pull-right" onclick="eliminarComentario(' + data[i].id_comentario_us + ')"><i class="fa fa-trash-o"></i> Eliminar comentario</button>';
                    }

                    var botonEditar = '';
                    if (!$("#comentario_foro_area").attr("hidden") && id_docente_verifity === data[i].id_comentario) {
                        botonEditar = '<button type="button" class="editar_comentario btn btn-default btn-xs pull-right" data-comentario="' + data[i].comentario + '" data-idcomentario="' + data[i].id_comentario_us + '"><i class="fa fa-pencil"></i> Editar comentario</button>';
                    }

                    var botonResponder = '';
                    if (!$("#comentario_foro_area").attr("hidde")) {
                        botonResponder = '<button type="button" class="responder_comentario btn btn-default btn-xs pull-left" ' +
                            'data-id="' + data[i].id_comentario_us + '" ' +
                            'data-foto="' + data[i].foto + '" ' +
                            'data-nombre="' + data[i][7] + '" ' +
                            'data-fecha="' + data[i][5] + '" ' +
                            'data-comentario="' + data[i][4] + '" ' +
                            'data-id-foro="' + data[i].id_foro + '" ' +
                            'data-id-responde_a="' + data[i].id_comentario + '">' +
                            '<i class="fa fa-comments"></i> Responder</button>';
                    }

                    llenaData += '<div class="box-body">' +
                        '<div class="box-body">' +
                        '</div>' +
                        '<div class="box-footer box-comments">' +
                        '<div class="box-comment">' +
                        '<img src="../' + data[i].foto + '" class="img-circle" alt="User Image" style="width: 50px;">' +
                        '<div class="comment-text">' +
                        '<span class="username">' +
                        ' ' + data[i][7] +
                        '<span class="text-muted pull-right">Fecha de comentario: ' + data[i][5] + '</span>' +
                        '</span>' +
                        data[i][4] +
                        ' <br>' +
                        ' <br>' +
                        botonResponder + // Agregar el botón de responder
                        botonEliminar + // Agregar el botón de eliminación
                        botonEditar + // Agregar el botón de edición

                        '<input type="hidden" class="txt_id_comentario_us" value="' + data[i].id_comentario_us + '" readonly>' + // Agregar el id_comentario_us como valor

                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';
                }

                // Mostrar los comentarios en el div con id "comentarios_foro"
                $('#comentarios_foro').html(llenaData);

                // Actualizar el contador de comentarios en el HTML
                actualizarContadorComentarios(contador);
            } else {
                // Si no hay comentarios, mostrar mensaje
                $('#comentarios_foro').html('<div class="alert alert-warning">Nadie ha participado en el foro aún.</div>');

                // Actualizar el contador de comentarios en el HTML
                actualizarContadorComentarios(contador);


            }
        });
    }

    // Función para actualizar el contador de comentarios en el HTML
    function actualizarContadorComentarios(contador) {
        $('#txt_contador').text(contador);
    }

    // Función para editar el comentario
    $(document).on('click', '.editar_comentario', function () {
        var comentario = $(this).data('comentario');
        var idComentario = $(this).data('idcomentario');
        $("#txt_comentario").val(comentario);
        $("#txt_id_comentario_editar").val(idComentario);
        // Ocultar el botón de "Registrar comentario"
        $('#btnregistar').hide();

        // Mostrar el botón de "Editar comentario"
        $('#btnEditar').show();
        $('#btnCancelarEditar').show();

    });


    // Función para cancelar editar el comentario
    $(document).on('click', '.cancelar_editar_comentario_foro', function () {
        $('#btnregistar').show();
        $('#btnEditar').hide();
        $('#btnCancelarEditar').hide();
        $("#txt_comentario").val(""); // Limpiar el campo de comentario
    });


    // -----------modal respuestas-------------   
    // Función para cargar las respuestas
    function cargarRespuestas(id_foro, id_principal, id_docente_verifity) {
        var id_docente_verifity = $('#id_docente_verifity').val();
        $.ajax({
            url: "../controlador/foro/controlador_foro_comentarios_respuestas.php",
            type: "POST",
            data: {
                id_foro: id_foro,
                id_principal: id_principal
            },
            success: function (respuesta) {
                // Limpiar el contenedor de respuestas antes de cargar nuevas respuestas
                $('#respuestas_foro').empty();

                var respuestas = JSON.parse(respuesta);

                // Contador de respuestas
                var contadorRespuestas = respuestas.length;

                // Mostrar el contador de respuestas
                $('#txt_contador_respuestas').text(contadorRespuestas);

                // Verificar si hay respuestas
                if (contadorRespuestas > 0) {
                    respuestas.forEach(function (respuesta) {

                        var botonEliminarRespuesta = '';
                        if (!$("#comentario_foro_area_respuesta").attr("hidden") && id_docente_verifity === respuesta.id_respuesta) {
                            botonEliminarRespuesta = '<button type="button" class="eliminar_respuesta btn btn-default btn-xs pull-right" onclick="eliminarRespuesta(' + respuesta.id_comentario_us + ')"><i class="fa fa-trash-o"></i> Eliminar respuesta</button>';
                        }
                        var botonEditarRespuesta = '';
                        if (!$("#comentario_foro_area_respuesta").attr("hidden") && id_docente_verifity === respuesta.id_respuesta) {
                            botonEditarRespuesta = '<button type="button" class="editar_respuesta btn btn-default btn-xs pull-right" data-id="' + respuesta.id_comentario_us + '" data-comentario="' + respuesta.comentario_respuesta + '"><i class="fa fa-pencil"></i> Editar respuesta</button>';
                        }
                        var botonResponder = '';
                        if (!$("#comentario_foro_area_respuesta").attr("hidden")) {
                            botonResponder = '<button type="button" class="responder_respuesta btn btn-default btn-xs pull-left" data-id="' + respuesta.id_respuesta + '" data-responde_a="' + respuesta.id_respuesta + '" data-nombre="' + respuesta.nombre + '"><i class="fa fa-comments"></i> Responder</button>';
                        }
                        var htmlRespuesta =
                            '<div class="box-footer box-comments" style="margin-bottom: 10px;">' +
                            '<div class="box-comment">' +
                            '<img src="../' + respuesta.foto + '" class="img-circle" alt="User Image" style="width: 50px;">' +
                            '<div class="comment-text">' +
                            '<span class="username">' +
                            ' ' + respuesta.nombre + '<span class="text-muted"><small> Responde a--> </small></span>' + respuesta.responde_a +
                            '<span class="text-muted pull-right">Fecha de respuesta: ' + respuesta.fecha_respuesta + '</span>' +
                            '</span>' +
                            '<p style="margin-top: 18px;">' + respuesta.comentario_respuesta + '</p>' + // Ajuste del margen superior
                            botonEliminarRespuesta + // Agregar el botón de eliminación
                            botonEditarRespuesta + // Agregar el botón de edición
                            botonResponder + // Agregar el botón de responder
                            '</div>' +
                            '</div>' +
                            '</div>';

                        // Agregar la respuesta al contenedor de respuestas
                        $('#respuestas_foro').append(htmlRespuesta);
                    });
                } else {
                    // Si no hay respuestas, mostrar mensaje
                    $('#respuestas_foro').html('<div class="alert alert-warning">Nadie ha respondido a este comentario aún.</div>');
                }
            },
            error: function (xhr, status, error) {
            }
        });
    }

    // Función para editar la respuesta
    $(document).on('click', '.editar_respuesta', function () {
        var comentario = $(this).data('comentario');
        var idRespuesta = $(this).data('id');
        $("#txt_comentario_respuesta").val(comentario);
        $("#txt_id_comentario_editar_respuesta").val(idRespuesta);
        // Ocultar el botón de "Registrar respuesta"
        $('#btnregistarrespuesta').hide();
        // Mostrar el botón de "Editar respuesta"
        $('#btnEditarrespuesta').show();
        $('#btnCancelarResponder').show();
    });


    $(document).on('click', '.responder_respuesta', function () {
        var responde_a = $(this).data('responde_a');
        var nombre = $(this).data('nombre');

        $('#id_responde_a').val(responde_a);

        $('#lbl_responder_a').html('<b>' + nombre + '</b>');

        $('#modal_respuestas').animate({
            scrollTop: $('#txt_comentario_respuesta').offset().top - $('#modal_respuestas').offset().top
        }, 'slow');
    });

    $(document).on('click', '.responder_modal', function () {
        var responde_a = $(this).data('id-responde_a');
        var nombre = $(this).closest('.box').find('.username a').text();

        $('#id_responde_a').val(responde_a);

        $('#lbl_responder_a').html('<b>' + nombre + '</b>');

        $('#modal_respuestas').animate({
            scrollTop: $('#txt_comentario_respuesta').offset().top - $('#modal_respuestas').offset().top
        }, 'slow');

    });

    $(document).on('click', '.responder_comentario', function () {
        var id_comentario_us = $(this).data('id');
        var foto = $(this).data('foto');
        var nombre = $(this).data('nombre');
        var fecha = $(this).data('fecha');
        var comentario = $(this).data('comentario');
        var id_foro = $(this).data('id-foro');
        var id_responde_a = $(this).data('id-responde_a');

        $('#id_principal').val(id_comentario_us);
        $('#id_foro_respuesta').val(id_foro);
        $('#id_responde_a').val(id_responde_a);
        $('#img_modal').attr('src', '../' + foto);
        $('#lbl_username').html('<a href="#">' + nombre + '</a>');
        $('#lbl_fecha').html(fecha);
        $('#lbl_comentario_principal').html(comentario);
        $('#lbl_responder_a').html('<b>' + nombre + '</b>');

        $('#btnResponderModal').data('id-responde_a', id_responde_a);

        $("#modal_respuestas").modal({
            backdrop: 'static',
            keyboard: false
        });
        $("#modal_respuestas").modal('show');
        var id_foro = $('#id_foro_respuesta').val();
        var id_principal = $('#id_principal').val();

        $('#btnregistarrespuesta').show();
        $('#btnEditarrespuesta').hide();


        cargarRespuestas(id_foro, id_principal);
    });

    // Función para cancelar editar respuesta
    $(document).on('click', '.cancelar_responder_comentario_foro', function () {
        $('#btnregistarrespuesta').show();
        $('#btnEditarrespuesta').hide();
        $('#btnCancelarResponder').hide();
        $("#txt_comentario_respuesta").val("");
    });

    $(document).on('click', '.ver_foro', function () {
        var rowData = tabla_foro.row($(this).closest('tr')).data();
        var id_foro = rowData.ID;
        var id_grupo = rowData.id_grupo;
        var id_docente_verifity = $('#id_docente_verifity').val();
        comentarios_foro(id_foro, id_grupo, id_docente_verifity);
        $('#btnregistar').show();
        $('#btnEditar').hide();
        $('#btnCancelarEditar').hide();
        $('#btnCancelarResponder').hide();


    });
});

$(document).ready(function () {

    function mostrarContenedorForo() {
        $('#foro').show();
    }

    function capturarDatosDelForo(rowData) {
        var titulo = rowData.titulo;
        var descripcion = rowData.descripcion;
        var id = rowData.ID;
        var idGrupo = rowData.id_grupo;
        var nombre = rowData.nombre;
        var fecha = rowData.fecha_foro;
        var fotoUsuario = "../" + rowData.foto;
        var comentarios = rowData.comentarios;
        var estadoForo = rowData.foro_estado;

        actualizarInformacionDelForo(titulo, descripcion, id, idGrupo, nombre, fecha, fotoUsuario, comentarios, estadoForo);
    }

    function actualizarInformacionDelForo(titulo, descripcion, id, idGrupo, nombre, fecha, fotoUsuario, comentarios, estadoForo) {
        document.getElementById('txttitulo').innerHTML = titulo;
        document.getElementById('txtdescripcion').innerHTML = descripcion;
        document.getElementById('txtdescripcion').style.whiteSpace = "pre-wrap";
        document.getElementById('txtidforo').value = id;
        document.getElementById('txtidgrupo').value = idGrupo;
        document.getElementById('txtnombre').innerHTML = nombre;
        document.getElementById('txtfechaforo').innerHTML = fecha;
        document.getElementById('imagenUsuario').src = fotoUsuario;

        // Verificar el estado del foro y mostrar/ocultar el área de comentario
        if (estadoForo === "INACTIVO") {
            $("#comentario_foro_area").attr("hidden", true);
        } else {
            $("#comentario_foro_area").removeAttr("hidden");
        }

        if (estadoForo === "INACTIVO") {
            $("#comentario_foro_area_respuesta").attr("hidden", true);
        } else {
            $("#comentario_foro_area_respuesta").removeAttr("hidden");
        }


        $('#modal_respuestas').on('shown.bs.modal', function () {
            if (estadoForo === "INACTIVO") {
                $("#btnResponderModal").hide();
            } else {
                $("#btnResponderModal").show();
            }
        });

        $('#modal_respuestas').on('hidden.bs.modal', function () {
            $("#btnResponderModal").show();
        });

    }

    $(document).on('click', '.ver_foro', function () {
        var rowData = tabla_foro.row($(this).closest('tr')).data();
        capturarDatosDelForo(rowData);
        mostrarContenedorForo();
    });

    function titulo_descripcion() {
        $.ajax({
            "url": "../controlador/foro/controlador_foro_listar.php",
            type: 'POST'
        }).done(function (resp) {
            var data = JSON.parse(resp);
            document.getElementById('txttitulo').innerHTML = data[0].titulo;
            document.getElementById('txtdescripcion').innerHTML = data[0].descripcion;
            document.getElementById('txtnombre').innerHTML = data[0].nombre;
            document.getElementById('txtfechaforo').innerHTML = data[0].fecha;
            document.getElementById('imagenUsuario').src = "../" + data[0].fotoUsuario;

        });
    }
});

function eliminarComentario(id_comentario_us) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Quieres eliminar este comentario?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value == true) {
            $.ajax({
                url: "../controlador/foro/controlador_eliminar_comentario_foro.php",
                type: "POST",
                data: {
                    id_comentario_us: id_comentario_us
                }
            }).done(function (respuesta) {
                if (respuesta > 0) {
                    Swal.fire("Mensaje De Confirmación", "El comentario se eliminó con éxito", "success")
                        .then((value) => {
                            recargarComentarios();
                        });
                } else {
                    Swal.fire("Error", "Hubo un error al eliminar el comentario", "error");
                }
            }).fail(function () {
                Swal.fire("Error", "No se pudo completar la solicitud", "error");
            });
        }
    });
}

function eliminarRespuesta(id_comentario_us) {
    var id_foro = $("#id_foro_respuesta").val();
    var id_principal = $("#id_principal").val();

    Swal.fire({
        title: '¿Estás seguro?',
        text: '¿Quieres eliminar esta respuesta?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: "../controlador/foro/controlador_eliminar_comentario_foro_respuesta.php",
                type: "POST",
                data: {
                    id_comentario_us: id_comentario_us
                }
            }).done(function (respuesta) {
                if (respuesta > 0) {
                    Swal.fire("Mensaje De Confirmación", "La respuesta se eliminó con éxito", "success")
                        .then((value) => {
                            recargarRespuestas(id_foro, id_principal, id_docente_verifity);
                        });
                } else {
                    Swal.fire("Error", "Hubo un error al eliminar la respuesta", "error");
                }
            }).fail(function () {
                Swal.fire("Error", "No se pudo completar la solicitud", "error");
            });
        }
    });
}

// Función para recargar los comentarios y el contador
function recargarComentarios() {
    var id_foro = $('#txtidforo').val();
    var id_grupo = $('#txtidgrupo').val();
    var id_docente_verifity = $('#id_docente_verifity').val();

    $.ajax({
        url: "../controlador/foro/controlador_foro_comentarios.php",
        type: "POST",
        data: {
            id_foro: id_foro,
            id_grupo: id_grupo
        }
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var llenaData = "";
        var contador = 0;

        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                var botonEliminar = '';
                if (!$("#comentario_foro_area").attr("hidden") && id_docente_verifity === data[i].id_comentario) {
                    botonEliminar = '<button type="button" class="eliminar_comentario btn btn-default btn-xs pull-right" onclick="eliminarComentario(' + data[i].id_comentario_us + ')"><i class="fa fa-trash-o"></i> Eliminar comentario</button>';
                }

                var botonEditar = '';
                if (!$("#comentario_foro_area").attr("hidden") && id_docente_verifity === data[i].id_comentario) {
                    botonEditar = '<button type="button" class="editar_comentario btn btn-default btn-xs pull-right" data-comentario="' + data[i].comentario + '" data-idcomentario="' + data[i].id_comentario_us + '"><i class="fa fa-pencil"></i> Editar comentario</button>';
                }

                var botonResponder = '';
                if (!$("#comentario_foro_area").attr("hidden")) {
                    botonResponder = '<button type="button" class="responder_comentario btn btn-default btn-xs pull-left" ' +
                        'data-id="' + data[i].id_comentario_us + '" ' +
                        'data-foto="' + data[i].foto + '" ' +
                        'data-nombre="' + data[i][7] + '" ' +
                        'data-fecha="' + data[i][5] + '" ' +
                        'data-comentario="' + data[i][4] + '" ' +
                        'data-id-foro="' + data[i].id_foro + '" ' +
                        'data-id-responde_a="' + data[i].id_comentario + '">' +
                        '<i class="fa fa-comments"></i> Responder</button>';
                }

                llenaData += '<div class="box-body">' +
                    '<div class="box-body">' +
                    '</div>' +
                    '<div class="box-footer box-comments">' +
                    '<div class="box-comment">' +
                    '<img src="../' + data[i].foto + '" class="img-circle" alt="User Image" style="width: 50px;">' +
                    '<div class="comment-text">' +
                    '<span class="username">' +
                    ' ' + data[i][7] +
                    '<span class="text-muted pull-right">Fecha de comentario: ' + data[i][5] + '</span>' +
                    '</span>' +
                    data[i][4] +
                    ' <br>' +
                    ' <br>' +
                    botonResponder + // Agregar el botón de responder
                    botonEliminar + // Agregar el botón de eliminación
                    botonEditar + // Agregar el botón de edición

                    '<input type="hidden" class="txt_id_comentario_us" value="' + data[i].id_comentario_us + '" readonly>' + // Agregar el id_comentario_us como valor

                    '</div>' +
                    '</div>' +
                    '</div>' +
                    '</div>';

                contador++; // Incrementar el contador
            }

            // Mostrar los comentarios en el div con id "comentarios_foro"
            $('#comentarios_foro').html(llenaData);
        }

        // Actualizar el contador
        document.getElementById('txt_contador').innerHTML = contador;
    });
}

// Función para recargar las respuestas en el modal
function recargarRespuestas(id_foro, id_principal, id_docente_verifity) {

    var id_docente_verifity = $('#id_docente_verifity').val();
    $.ajax({
        url: "../controlador/foro/controlador_foro_comentarios_respuestas.php",
        type: "POST",
        data: {
            id_foro: id_foro,
            id_principal: id_principal
        },
        success: function (respuesta) {
            $('#respuestas_foro').empty();

            var respuestas = JSON.parse(respuesta);

            var contadorRespuestas = respuestas.length;

            $('#txt_contador_respuestas').text(contadorRespuestas);

            if (contadorRespuestas > 0) {
                respuestas.forEach(function (respuesta) {
                    var botonEliminarRespuesta = '';
                    if (id_docente_verifity === respuesta.id_respuesta) {
                        botonEliminarRespuesta = '<button type="button" class="eliminar_respuesta btn btn-default btn-xs pull-right" onclick="eliminarRespuesta(' + respuesta.id_comentario_us + ')"><i class="fa fa-trash-o"></i> Eliminar respuesta</button>';
                    }

                    var botonEditarRespuesta = '';
                    if (id_docente_verifity === respuesta.id_respuesta) {
                        botonEditarRespuesta = '<button type="button" class="editar_respuesta btn btn-default btn-xs pull-right" data-id="' + respuesta.id_comentario_us + '" data-comentario="' + respuesta.comentario_respuesta + '"><i class="fa fa-pencil"></i> Editar respuesta</button>';
                    }

                    var botonResponder = '<button type="button" class="responder_respuesta btn btn-default btn-xs pull-left" data-id="' + respuesta.id_respuesta + '" data-responde_a="' + respuesta.id_respuesta + '" data-nombre="' + respuesta.nombre + '"><i class="fa fa-comments"></i> Responder</button>';

                    var htmlRespuesta =
                        '<div class="box-footer box-comments" style="margin-bottom: 10px;">' +
                        '<div class="box-comment">' +
                        '<img src="../' + respuesta.foto + '" class="img-circle" alt="User Image" style="width: 50px;">' +
                        '<div class="comment-text">' +
                        '<span class="username">' +
                        ' ' + respuesta.nombre + '<span class="text-muted"><small> Responde a--> </small></span>' + respuesta.responde_a +
                        '<span class="text-muted pull-right">Fecha de respuesta: ' + respuesta.fecha_respuesta + '</span>' +
                        '</span>' +
                        '<p style="margin-top: 18px;">' + respuesta.comentario_respuesta + '</p>' + // Ajuste del margen superior
                        botonEliminarRespuesta + // Agregar el botón de eliminación
                        botonEditarRespuesta + // Agregar el botón de edición
                        botonResponder + // Agregar el botón de responder
                        '</div>' +
                        '</div>' +
                        '</div>';

                    // Agregar la respuesta al contenedor de respuestas
                    $('#respuestas_foro').append(htmlRespuesta);
                });
            } else {
                // Si no hay respuestas, mostrar mensaje
                $('#respuestas_foro').html('<div class="alert alert-warning">Nadie ha respondido a este comentario aún.</div>');
            }
        },
        error: function (xhr, status, error) {
            // Manejar errores si es necesario
        }
    });
}

// -----------------------------------------Estudiante----------------------------------

function listar() {

    var id_grado = $("#cbm_grado").val();
    var id_asignatura = $("#cbm_gruposs").val();
    var id_usuario_doc = $("#id_docente_verifity").val();
    listar_foros_es(id_grado, id_asignatura, id_usuario_doc);


}

var tabla_foro;
function listar_foros_es(id_grado, id_asignatura) {
    var id_usuario_doc = $("#id_docente_verifity_est").val();
    if (id_grado == null || id_asignatura == null) {
        id_grado = 1;
        id_asignatura = 1;
    }
    tabla_foro = $("#tabla_foro").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/foro/controlador_foro_listar.php",
            type: 'POST',
            data: {
                id_usuario_doc: id_usuario_doc,
                id_asignatura: id_asignatura,
                id_grado: id_grado
            }
        },

        "columns": [
            { "defaultContent": "" },
            { "data": "titulo" },
            {
                "data": "foro_estado",
                render: function (data, type, row) {
                    if (data == 'ACTIVO') {
                        return "<span class='label label-success'>" + data + "</span>";
                    } else {
                        return "<span class='label label-danger'>" + data + "</span>";
                    }
                }
            },
            { "data": "fecha" },
            {
                "defaultContent": "<button style='font-size:13px;' type='button' class='ver_foro btn btn-primary'><i class='fa fa-comments'></i></button>"
            }
        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_foro_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });
    tabla_foro.on('draw.dt', function () {
        var PageInfo = $('#tabla_foro').DataTable().page.info();
        tabla_foro.column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });
}


function listar_combo_verificar_estudiante() {
    var id = $("#txtidusuario").val();
    $.ajax({
        url: "../controlador/calificaciones/controlador_combo_estudiante_verificar_listar.php",
        type: "POST",
        data: {
            id: id
        }
    }).done(function (resp) {
        let data = JSON.parse(resp);


        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                $("#id_docente_verifity").val(data[i][1]);

            }
        }
    })
}

function listar_combo_materia() {
    var id = $("#txtidusuario").val();

    $.ajax({
        url: "../controlador/calificaciones/controlador_combo_materia_listar.php",
        type: "POST",
        data: { id: id }
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + "Asignatura: " + data[i][1] + "  --  " + "Profesor: " + data[i][2] + "</option>";
            }
            $("#cbm_gruposs").html(cadena);

            $("#cbm_gruposs").change(function () {
                var docente = data[$(this).prop('selectedIndex')][5];
                $("#id_docente_verifity_est").val(docente);
            });

            var primerDocente = data[0][5];
            $("#id_docente_verifity_est").val(primerDocente);

            id = $("#cbm_gruposs").val();
            listar_combo_grado(id);
            listar_combo_asignatura(id);

            if (id.length != '') {
                $("#cbm_grupo_listar").val(id).trigger("change");
            }
        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_gruposs").html(cadena);
            $("#id_docente_verifity_est").val('');
        }
    });
}

function listar_combo_verificar_docentes() {
    var id = $("#txtidusuario").val();
    $.ajax({
        url: "../controlador/calificaciones/controlador_combo_docentes_verificar_listar.php",
        type: "POST",
        data: {
            id: id
        }
    }).done(function (resp) {
        let data = JSON.parse(resp);


        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                $("#id_docente_verifity_es").val(data[i][3]);

            }
        }
    })
}

// -----------------------------------------Fecha limite foro----------------------------------

function TraerfechaF() {

    var data = "2023-11-23";
    var date;

    const monthNames = ["01", "02", "03", "04", "05", "06",
        "07", "08", "09", "10", "11", "12"
    ];
    const local = new Date();

    let day = local.getDate(),
        month = local.getMonth(),
        year = local.getFullYear();

    date = `${year}-${monthNames[month]}-${day}`;

    if (data != date) {

        actualizar_estado();

    }
}

function actualizar_estado() {
    $.ajax({
        url: "../controlador/foro/controlador_editar_estado_foro.php",
        type: "POST"


    })
}