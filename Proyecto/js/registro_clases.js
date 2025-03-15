// ------------TABLA CLASES--------------


var tabla_clases;
function listar_registro_de_clases(id_grado, id_asignatura) {
    var id_usuario = $("#txtidusuario").val();
    var id_grupo = $("#cbm_grupo").val();
    if (id_grado == null || id_asignatura == null || id_grupo == null) {
        id_grado = 1;
        id_asignatura = 1;
        id_grupo = 1;
    }
    tabla_clases = $("#tabla_clases").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/clases/controlador_clases_listar.php",
            type: 'POST',
            data: {
                id_usuario: id_usuario,
                id_grado: id_grado,
                id_grupo: id_grupo,
                id_asignatura: id_asignatura
            }
        },
        "columns": [
            { "defaultContent": "" },
            { "data": "fecha" },
            { "data": "titulo" },
            { "defaultContent": "<button style='font-size:13px; margin-right: 1px;' type='button' class='modal_descripcion btn btn-default' title='descripcion' ><i class='fa fa-eye'></i></button>" },

            { "data": "docente" },
            { "data": "Materia" },
            { "data": "grado" },
            {
                "defaultContent": "<button style='font-size:13px;' type='button' class='editar_clase btn btn-primary'><i class='fa fa-edit'></i></button>"
            }
        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_clases_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });
    tabla_clases.on('draw.td', function () {
        var pageinfo = $("#tabla_clases").DataTable().page.info();
        tabla_clases.column(0, { page: 'current' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + pageinfo.start;
        });

    });
}
$("#tabla_clases").on('click', '.editar_clase', function () {
    var data = tabla_clases.row($(this).parents('tr')).data();
    if (tabla_clases.row(this).child.isShown()) {
        var data = tabla_clases.row(this).data();
    }
    $("#modal_editar_clases").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_editar_clases").modal('show');

    $('#id_clases').val(data.ID);
    $('#id_video').val(data.video);
    $('#txt_titulo_editar').val(data.titulo);
    $('#descripcion_editar').val(data.detalles);
    $('#cbm_grupo_editar').val(data.id_grupo).trigger('change');
    $('.js-example-basic-single').select2();
    $('.js').select2();
});
$("#tabla_clases").on('click', '.modal_descripcion', function () {
    var data = tabla_clases.row($(this).parents('tr')).data();
    if (tabla_clases.row(this).child.isShown()) {
        var data = tabla_clases.row(this).data();
    }
    $("#modal_ver_des").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_ver_des").modal('show');

    $('#descripcion_ver').val(data.detalles);
    $("#lbl_titulo").html(data.titulo);
    $("#lbl_descripcion").html(data.detalles);
    $("#txtdocente").html(data.docente);
    $("#txt_materia").html(data.Materia);
    $("#txtgrado").html(data.grado);
    $("#txtfecha").html(data.fecha);

    // Renderizar el video en el modal
    $("#videoContainer").html('<video controls style="width:100%;" src="../' + data.video + '"></video>');
    $("#foto").attr('src', '../' + data.foto);
});

$("#modal_registro_videos").on('click', '.ver_registro_clases', function () {
    var data = tabla_clases.row($(this).parents('tr')).data();
    if (tabla_clases.row(this).child.isShown()) {
        var data = tabla_clases.row(this).data();
    }
    $("#modal_registro_videos").modal({
        backdrop: 'static',
        keyboard: false
    });
    $("#modal_registro_videos").modal('show');
    $("#txttitulo").html(data.titulo);
    $("#txtdescripcion").html(data.detalles);
    $("#txtdocente").html(data.docente);
    $("#txtmateria").html(data.Materia);
    $("#txtgrado").html(data.grado);
    $("#txtfecha").html(data.fecha);

    // Renderizar el video en el modal
    $("#videoContainer").html('<video controls style="width:100%;" src="../' + data.video + '"></video>');
});

// -------------LISTAR COMBOS-----------

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
                $("#id_docente_verifity").val(data[i][0]).hide();
            }
        }
    })
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
                $("#id_docente_verifity").val(data[i][0]).hide();
            }
        }
    })
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
                $("#id_estudiante_verifity").val(data[i][0]).hide();
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

function listar_combo_grupo_editar() {
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
                cadena += "<option value='" + data[i][0] + "'>" + "Asignatura:  " + data[i][1] + "  --  " + "Grado:" + data[i][2] + " </option>";

            }
            $("#cbm_grupo_editar").html(cadena);

            $('.js-example-basic-single').select2();
            $('.js').select2();


        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_grupo_editar").html(cadena);

        }


    })
}

// -------------REGISTROS Y EDITAR-----------

function Registrar_Clases() {
    var fecha_registro = $("#fecha").val();
    var id_grupo = $("#cbm_grupos").val();
    var id_docente = $("#id_docente_verifity").val();
    var titulo = $("#txt_titulo").val();
    var descripcion = $("#descripcion").val();
    var video = $("#txt_video").prop("files")[0];

    if (!video) {
        return Swal.fire("Mensaje De Advertencia", "Seleccione un video", "warning");
    }

    let extenxion = video.name.split('.').pop();
    let nombrevideo = "";
    let fecha = new Date();
    if (video) {
        nombrevideo = titulo + "" + fecha.getDate() + "" + (fecha.getMonth() + 1) + "" + fecha.getFullYear() + "" + fecha.getMinutes() + "" + fecha.getSeconds() + "" + fecha.getMilliseconds() + "." + extenxion;
    }

    if (fecha_registro.length == 0 || id_grupo.length == 0 || titulo.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacíos", "warning");
    }

    let videosize = video.size;
    if (videosize > 629145600) {
        return Swal.fire("Mensaje De Advertencia", "El archivo supera los 600MB.", "warning");
    }

    let formData = new FormData();
    formData.append('f', fecha_registro);
    formData.append('g', id_grupo);
    formData.append('p', id_docente);
    formData.append('t', titulo);
    formData.append('d', descripcion);
    formData.append('nombrevideo', nombrevideo);
    formData.append('video', video);

    $.ajax({
        url: "../controlador/clases/controlador_registro_clases.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        xhr: function () {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function (evt) {
                if (evt.lengthComputable) {
                    var percentComplete = (evt.loaded / evt.total) * 100;
                    // Actualizar la barra de progreso
                    $("#progress_bar").width(percentComplete + "%").text(percentComplete.toFixed(2) + "%");
                }
            }, false);
            return xhr;
        },
        success: function (resp) {
            if (resp > 0) {
                Swal.fire("Mensaje De Confirmacion", "Registro de clases Registrado Correctamente", "success").then(value => {
                    $("#modal_registro").modal('hide');
                    table.ajax.reload();
                    $("#img_lateral").ajax.reload();
                    $("#img_nav").ajax.reload();
                    $("#img_subnav").ajax.reload();
                    limpiar_datos();
                });
            } else {
                Swal.fire("Mensaje De Error", "No se pudo registrar el video", "error");
            }
        },
        error: function (xhr, status, error) {
            Swal.fire("Mensaje De Error", "Error al subir el video, verifica la conexión de internet", "error");
        }
    });
    return false;
}

function editar_clases() {

    var id_clases = $("#id_clases").val();
    var id_docente = $("#id_docente_verifity").val();
    var id_grupo = $("#cbm_grupo_editar").val();
    var titulo = $("#txt_titulo_editar").val();
    var descripcion = $("#descripcion_editar").val();
    var video = $("#txt_video_editar").val();
    var video_actual = $("#id_video").val();
    let extenxion = video.split('.').pop();
    let nombrevideo = "";
    let fecha = new Date();
    if (id_docente == null) {
        Swal.fire("Mensaje de Error", "Dato Vacio", "error");
    }

    if (id_grupo.length == 0 || titulo.length == 0 || descripcion.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }
    if (video != "") {
        let videosize = $("#txt_video_editar")[0].files[0].size;

        if (videosize > 629145600) {
            return Swal.fire("Mensaje De Advertencia", "El video supera los 600Mb.", "warning");
        }
        if (video.length > 0) {
            nombrevideo = titulo + "" + fecha.getDate() + "" + (fecha.getMonth() + 1) + "" + fecha.getFullYear() + "" + fecha.getMinutes() + "" + fecha.getMilliseconds() + "." + extenxion;
            let formData = new FormData();
            let videoObject = $("#txt_video_editar")[0].files[0];

            formData.append('c', id_clases);
            formData.append('p', id_docente);
            formData.append('g', id_grupo);
            formData.append('t', titulo);
            formData.append('d', descripcion);
            formData.append('nombrevideo', nombrevideo);
            formData.append('video', videoObject)

            $.ajax({

                url: "../controlador/clases/controlador_editar_clases.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (resp) {
                    if (resp > 0) {

                        Swal.fire("Mensaje de Confirmación", "Clase modificada Correctamente", "success").then(value => {
                            $("#modal_editar_clases").modal('hide');

                            tabla_clases.ajax.reload();
                        })
                    } else {
                        Swal.fire("Mensaje De Error", "No se pudo editar los datos", "error");
                    }
                }
            });
            return false;
        }
    }
    else {
        $.ajax({
            url: "../controlador/clases/controlador_clases_editar.php",
            type: "POST",
            data: {
                id_clases: id_clases,
                id_docente: id_docente,
                id_grupo: id_grupo,
                titulo: titulo,
                descripcion: descripcion,
                url: video_actual
            }
        }).done(function (resp) {
            if (resp > 0) {

                Swal.fire("Mensaje de Confirmación", "Clase modificada Correctamente", "success").then(value => {
                    $("#modal_editar_clases").modal('hide');

                    tabla_clases.ajax.reload();

                })

            } else {
                Swal.fire("Mensaje De Error", "No se pudo editar los datos", "error");
            }
        })
    }
}

function datos() {

    var id_grado = $("#cbm_grado").val();
    var id_asignatura = $("#cbm_asignatura").val();
    listar_registro_de_clases(id_grado, id_asignatura);

}

// asignacion de clases virtuales

var tabla_asignaciones_clases;
function listar_asignaciones_clases(id_grupo) {
    var id_usuario = $("#txtidusuario").val();
    if (id_grupo == null) {
        id_grupo = 1;
    }
    tabla_asignaciones_clases = $("#tabla_asignaciones_clases").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/clases/controlador_clases_virtuales_listar.php",
            type: 'POST',
            data: {
                id_usuario: id_usuario,
                id_grupo: id_grupo

            }
        },
        "columns": [
            { "defaultContent": "" },
            { "data": "link" },
            {
                "data": "estado",
                render: function (data, type, row) {
                    if (data == 'ACTIVO') {
                        return '<span class="btn btn-success">' + data + '</span>';
                    } else {
                        return '<span class="btn btn-danger">' + data + '</span>';
                    }

                }
            },
            { "data": "fecha" },
            { "defaultContent": "<button style='font-size:13px;' type='button' class='editar_clase_virtual btn btn-primary'><i class='fa fa-edit'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='desactivar btn btn-danger'><i class='fa fa-trash'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='activar btn btn-success'><i class='fa fa-check'></i></button>" }
        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_asignaciones_clases_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });
    tabla_asignaciones_clases.on('draw.td', function () {
        var pageinfo = $("#tabla_asignaciones_clases").DataTable().page.info();
        tabla_asignaciones_clases.column(0, { page: 'current' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + pageinfo.start;
        });

    });
}

$("#tabla_asignaciones_clases").on('click', '.editar_clase_virtual', function () {
    var data = tabla_asignaciones_clases.row($(this).parents('tr')).data();
    if (tabla_asignaciones_clases.row(this).child.isShown()) {
        var data = tabla_asignaciones_clases.row(this).data();
    }
    $("#modal_editar_clases_virtual").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_editar_clases_virtual").modal('show');

    $('#id_editar').val(data.ID);

    $('#txt_link_editar').val(data.link);
    $('#fecha_editar').val(data.fecha);
    $('#cbm_grupo_editar').val(data.id_grupo).trigger('change');
});

function editar_clases_link() {

    var id_link = $("#id_editar").val();
    var linknuevo = $("#txt_link_editar").val();
    var fecha = $("#fecha_editar").val();
    var materia = $("#cbm_grupo_editar").val();
    var id_docente = $("#id_docente_verifity").val();

    if (id_link == null) {
        Swal.fire("Mensaje de Error", "Dato Vacio", "error");
    }

    if (linknuevo.length == 0 || fecha.length == 0 || materia.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }

    $.ajax({
        "url": "../controlador/clases/controlador_modificar_link.php",
        type: 'POST',
        data: {
            id_link: id_link,
            linknuevo: linknuevo,
            fecha: fecha,
            materia: materia,
            id_docente: id_docente
        }
    }).done(function (resp) {
        if (resp == 1) {
            if (resp == 1) {

                Swal.fire("Mensaje De Confirmacion", "Datos Actualizados correctamente", "success")
                    .then((value) => {
                        LimpiarRegistro();
                        $("#modal_editar_clases_virtual").modal('hide');
                        tabla_asignaciones_clases.ajax.reload();
                    });

            }
        } else {
            Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
        }
    })

}

function TraerfechaL() {

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
        url: "../controlador/clases/controlador_editar_link.php",
        type: "POST"

    })
}

function AbrirModalRegistro() {
    $('.js-example-basic-single').select2();
    $("#modal_registro").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_registro").modal('show');
}

/* FUNSION ACTIVAR CLASES VIRTUALES*/
$('#tabla_asignaciones_clases').on('click', '.activar', function () {
    var data = tabla_asignaciones_clases.row($(this).parents('tr')).data();
    if (tabla_asignaciones_clases.row(this).child.isShown()) {
        var data = tabla_asignaciones_clases.row(this).data();
    }
    Swal.fire({
        title: 'Esta seguro de activar la videoconferencia?',
        text: "Una vez hecho esto el usuario  tendra acceso al sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.value) {
            Modificar_Estatus(data.ID, 'ACTIVO');
        }
    })
})
/* FUNSION ACTIVAR CLASES VIRTUALES*/

/* FUNSION DESASTIVAR CLASES REGISTRADOS*/
$('#tabla_asignaciones_clases').on('click', '.desactivar', function () {
    var data = tabla_asignaciones_clases.row($(this).parents('tr')).data();
    if (tabla_asignaciones_clases.row(this).child.isShown()) {
        var data = tabla_asignaciones_clases.row(this).data();
    }
    Swal.fire({
        title: 'Esta seguro de desactivar la videoconferencia?',
        text: "Una vez hecho esto el usuario no tendra acceso al sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.value) {
            Modificar_Estatus(data.ID, 'INACTIVO');
        }
    })
})


function Modificar_Estatus(id, estado) {
    var mensaje = "";
    if (estado == 'INACTIVO') {
        mensaje = "desactivo";
    } else {
        mensaje = "activo";
    }
    $.ajax({
        "url": "../controlador/clases/controlador_modificar_estado_videoconferencias.php",
        type: 'POST',
        data: {
            id: id,
            estado: estado
        }
    }).done(function (resp) {
        if (resp > 0) {
            Swal.fire("Mensaje De Confirmacion", "La videoconferencia se " + mensaje + " con exito", "success")
                .then((value) => {
                    tabla_asignaciones_clases.ajax.reload();
                });
        }
    })


}
/* FUNSION DESASTIVAR CLASES REGISTRADOS*/

function Registrar_asignacion_clases() {
    var fecha_registro = $("#fecha").val();
    var id_grupo = $("#cbm_grupos").val();
    var id_docente = $("#id_docente_verifity").val();
    var link = $("#txt_link").val();
    if (fecha_registro.length == 0 || id_grupo.length == 0 || link.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }
    $.ajax({
        url: "../controlador/clases/controlador_registro_clases_virtuales.php",
        type: "POST",
        data: {
            id_grupo: id_grupo,
            id_docente: id_docente,
            link: link,
            fecha_registro: fecha_registro
        }
    }).done(function (resp) {
        if (resp > 0) {

            Swal.fire("Mensaje De Confirmacion", "videoconferencia Registrada Correctamente ", "success").then(value => {
                $("#modal_registro").modal('hide');

                tabla_asignaciones_clases.ajax.reload();


            });

        } else {
            Swal.fire("Mensaje De Error", "No se pudo registrar la videoconferencia", "error");
        }
    });

}

function buscar() {

    var id_grupo = $("#cbm_grupo").val();


    listar_asignaciones_clases(id_grupo);

}

// listar clases estudiantes

var tabla_grabacion_de_clases;
function listar_grabacion_de_clases(id_grupo) {
    var id_usuario = $("#txtidusuario").val();

    if (id_grupo == null) {
        id_grupo = 1;
    }
    tabla_grabacion_de_clases = $("#tabla_grabacion_de_clases").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/clases/controlador_grabaciones_de_clases_listar.php",
            type: 'POST',
            data: {
                id_usuario: id_usuario,
                id_grupo: id_grupo
            }
        },
        "columns": [
            { "defaultContent": "" },
            { "data": "fecha" },
            { "data": "titulo" },
            { "defaultContent": "<button style='font-size:13px; margin-right: 1px;' type='button' class='modal_descripcion btn btn-default' title='descripcion' ><i class='fa fa-eye'></i></button>" },

            { "data": "docente" },
            { "data": "Materia" },
            { "data": "grado" }

        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_grabacion_de_clases_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });
    tabla_grabacion_de_clases.on('draw.td', function () {
        var pageinfo = $("#tabla_grabacion_de_clases").DataTable().page.info();
        tabla_grabacion_de_clases.column(0, { page: 'current' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + pageinfo.start;
        });

    });
}

$("#tabla_grabacion_de_clases").on('click', '.modal_descripcion', function () {
    var data = tabla_grabacion_de_clases.row($(this).parents('tr')).data();
    if (tabla_grabacion_de_clases.row(this).child.isShown()) {
        var data = tabla_grabacion_de_clases.row(this).data();
    }
    $("#modal_ver_des").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_ver_des").modal('show');
    $('#descripcion_ver').val(data.detalles);
    $("#lbl_titulo").html(data.titulo);
    $("#lbl_descripcion").html(data.detalles);
    $("#txtdocente").html(data.docente);
    $("#txt_materia").html(data.Materia);
    $("#txtgrado").html(data.grado);
    $("#txtfecha").html(data.fecha);

    // Renderizar el video en el modal
    $("#videoContainer").html('<video controls style="width:100%;" src="../' + data.video + '"></video>');
    $("#foto").attr('src', '../' + data.foto);

});

function listar() {
    var id_grupo = $("#cbm_grupo").val();

    listar_grabacion_de_clases(id_grupo);
}

//VIDEOCONFERENCIA

var tabla_videoconferencia_clases;
function listar_videoconferencia_clases(id_grupo) {
    var id_usuario = $("#txtidusuario").val();
    if (id_grupo == null) {
        id_grupo = 1;
    }
    tabla_videoconferencia_clases = $("#tabla_videoconferencia_clases").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/clases/controlador_videoconferencia_de_clases_listar.php",
            type: 'POST',
            data: {
                id_usuario: id_usuario,
                id_grupo: id_grupo

            }
        },
        "columns": [
            { "defaultContent": "" },
            { "data": "fecha" },
            { "data": "link" },
            { "data": "docente" },
            {
                "data": "estado",
                render: function (data, type, row) {
                    if (data == 'ACTIVO') {
                        return '<span class="btn btn-success">' + data + '</span>';
                    } else {
                        return '<span class="btn btn-danger">' + data + '</span>';
                    }

                }
            },

        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_videoconferencia_clases_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });
    tabla_videoconferencia_clases.on('draw.td', function () {
        var pageinfo = $("#tabla_videoconferencia_clases").DataTable().page.info();
        tabla_videoconferencia_clases.column(0, { page: 'current' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + pageinfo.start;
        });

    });
}

function listar_datos() {
    var id_grupo = $("#cbm_grupo").val();

    listar_videoconferencia_clases(id_grupo);
}