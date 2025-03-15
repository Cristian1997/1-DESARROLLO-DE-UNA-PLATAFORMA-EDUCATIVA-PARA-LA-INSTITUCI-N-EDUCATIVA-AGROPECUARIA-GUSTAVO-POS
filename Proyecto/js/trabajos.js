// TABLA LISTAR TRABAJOS ESTUDIANTES
var tabla_trabajos_entregar;
function listar_trabajos_estudiantes(id_grupo, id_taller) {
    var id_usuario = $("#txtidusuario").val();
    if (id_grupo == null || id_taller == null) {
        id_grupo = 1;
        id_taller = 1;

    }
    tabla_trabajos_entregar = $("#tabla_trabajos_entregar").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/trabajos/controlador_trabajos_listar.php",
            type: 'POST',
            data: {
                id_usuario: id_usuario,
                id_taller: id_taller,
                id_grupo: id_grupo
            }
        },

        "columns": [
            { "defaultContent": "" },
            { "data": "Estudiante" },
            { "data": "titulo" },

            {
                "defaultContent": "<button style='font-size:13px;' type='button' title='Archivo' class='abrir btn btn-default'><i class='fa  fa-eye'></i></button>"
            },

            { "data": "fecha" },

        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_trabajos_entregar_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });
    tabla_trabajos_entregar.on('draw.dt', function () {
        var PageInfo = $('#tabla_trabajos_entregar').DataTable().page.info();
        tabla_trabajos_entregar.column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

}

$('#tabla_trabajos_entregar').on('click', '.abrir', function () {
    var data = tabla_trabajos_entregar.row($(this).parents('tr')).data();
    if (tabla_trabajos_entregar.row(this).child.isShown()) {
        var data = tabla_trabajos_entregar.row(this).data();
    }

    $("#modal_archivos").modal({
        backdrop: 'static',
        keyboard: false
    })

    $("#modal_archivos").modal('show');
    $("#txt_id_taller_ob").val(data.ID);
    $('#txt_archivo').attr("src", "../" + data.archivo);
    $("#foto").attr('src', '../' + data.foto);
    $('#descripcion_ver').val(data.detalles);
    $("#lbl_titulo").html(data.titulo);
    $("#lbl_descripcion").css("white-space", "pre-wrap");
    var notaHtml = (data.nota != null && data.nota != '') ? data.nota : 'No hay nota del estudiante.';
    $("#lbl_descripcion").html(notaHtml);
    $("#txtdocente").html(data.Estudiante);
    $("#txt_materia").html(data.nombre);
    $("#txtgrado").html(data.aula);
    $("#txtfecha").html(data.fecha);
    $("#lbl_nota_docente").css("white-space", "pre-wrap");
    var nota_docenteHtml = (data.nota_docente != null && data.nota_docente != '') ? data.nota_docente : 'No hay Observación para el estudiante.';
    $("#lbl_nota_docente").html(nota_docenteHtml);

});

$('#tabla_trabajos_entregar').on('click', '.calificar', function () {
    var data = tabla_trabajos_entregar.row($(this).parents('tr')).data();
    if (tabla_trabajos_entregar.row(this).child.isShown()) {
        var data = tabla_trabajos_entregar.row(this).data();
    }

    $("#modal_editar").modal({
        backdrop: 'static',
        keyboard: false
    })

    $("#modal_editar").modal('show');

    $("#id_calificaciones").val(data.id_calificaciones).hide();
    $("#txt_nota1_editar").val(data.primera_nota);
    $("#txt_nota2_editar").val(data.segunda_nota);
    $("#txt_nota3_editar").val(data.tercera_nota);
    $("#txt_nota4_editar").val(data.cuarta_nota);
    $("#txt_def_editar").val(data.nota_def).hide();


});

function volver() {

    $("#modal_abrir").modal('hide');
    $("#modal_respuesta").modal('hide');
    $("#modal_ver_comentarios").modal({
        backdrop: 'static',
        keyboard: false
    })

    $("#modal_ver_comentarios").modal('show');
}

function filterGlobal() {
    $('#tabla_trabajos_entregar').DataTable().search(
        $('#global_filter').val(),
    ).draw();
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
                cadena += "<option value='" + data[i][0] + "'>" + "Asignatura:  " + data[i][1] + "  --  " + "Profesor: " + data[i][2] + " </option>";

            }
            $("#cbm_grupos").html(cadena);
            var id = $("#cbm_grupos").val();
            listar_combo_verificar_taller(id);

            if (id.length != '') {
                $("#cbm_grupos").val(id).trigger("change");
            }

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_grupos").html(cadena);
        }
    })
}

// ------------LISTAR COMBOS--------------

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
            $("#cbm_grupos").html(cadena);
            var id = $("#cbm_grupos").val();
            listar_combo_verificar_taller(id);

            if (id.length != '') {
                $("#cbm_grupos").val(id).trigger("change");
            }
        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_grupos").html(cadena);
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

function listar_combo_verificar_taller(id_grupo) {
    var id = $("#txtidusuario").val();
    if (id_grupo == null) {

        id_grupo = 1;
    }
    $.ajax({
        url: "../controlador/trabajos/controlador_combo_talleres_verificar_listar.php",
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

                cadena += "<option value='" + data[i][0] + "'>" + data[i][0] + "</option>";
            }

            $("#cbm_taller").html(cadena);

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_taller").html(cadena);
        }
    })
}

// ------------REGISTRO Y EDICION--------------

function Registrar_calificaciones() {

    var id_calificaciones = $("#id_calificaciones").val();
    var nota_1 = $("#txt_nota1_editar").val();
    var nota_2 = $("#txt_nota2_editar").val();
    var nota_3 = $("#txt_nota3_editar").val();
    var nota_4 = $("#txt_nota4_editar").val();
    nota1 = parseFloat(nota_1);
    nota2 = parseFloat(nota_2);
    nota3 = parseFloat(nota_3);
    nota4 = parseFloat(nota_4);
    if (id_calificaciones == null) {
        return Swal.fire("Mensaje De Error", "Datos Vacios", "error");
    }
    $.ajax({
        "url": "../controlador/calificaciones/controlador_calificaciones_modificar.php",
        type: 'POST',
        data: {
            id_calificaciones: id_calificaciones,
            nota_1: nota1,
            nota_2: nota2,
            nota_3: nota3,
            nota_4: nota4
        }

    }).done(function (resp) {
        if (resp > 0) {
            if (resp == 1) {

                Swal.fire("Mensaje De Confirmacion", "Nota Actualizada correctamente", "success")
                    .then((value) => {
                        $("#modal_editar").modal('hide');
                        tabla_trabajos_entregar.ajax.reload();
                    });
            }
        } else {
            Swal.fire("Mensaje De Error", "Lo sentimos, no se realizar la actualización", "error");
        }
    })
}

function buscar() {
    var id_grupo = $("#cbm_grupos").val();
    var id_taller = $("#cbm_taller").val();

    listar_trabajos_estudiantes(id_grupo, id_taller);
}

function registrar_nota() {
    var id_taller = $("#txt_id_taller_ob").val();
    var comentario = $("#txt_nota").val();

    if (comentario.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los datos vacios", "warning");
    }

    $.ajax({
        url: "../controlador/trabajos/controlador_registrar_nota.php",
        type: "POST",
        data: {
            id_taller: id_taller,
            comentario: comentario
        }
    }).done(function (resp) {

        if (resp > 0) {
            Swal.fire("Mensaje De Confirmación", "Observación Registrada Correctamente", "success").then((value) => {
                tabla_trabajos_entregar.ajax.reload();
                $("#txt_nota").val("");

                var nota_docenteHtml = (comentario != null && comentario != '') ? comentario : 'No hay Observación para el estudiante.';
                $("#lbl_nota_docente").html(nota_docenteHtml);
            });

        } else {
            Swal.fire("Mensaje De Error", "no se pudo registrar los Datos", "error");


        }
    });
}

function recargarModal() {
    $("#modal_archivos").modal("hide");
    setTimeout(function () {

        $("#modal_archivos").modal("show");

        $("#txt_nota").val("");
    }, 500);
}
// --------------------------------ESTUDIANTES-------------------------------------

// ------------TABLA ESTUDIANTES TRABAJOS ENTREGADOS--------------

function listar() {
    var id_grupo = $("#cbm_grupo").val();

    listar_trabajos(id_grupo);
}
var tabla_trabajos_entregar;
function listar_trabajos(id_grupo) {
    var id_usuario = $("#txtidusuario").val();
    if (id_grupo == null) {
        id_grupo = 1;

    }
    tabla_trabajos_entregar = $("#tabla_trabajos_entregar").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/trabajos/controlador_trabajos_listar_estudiante.php",
            type: 'POST',
            data: {
                id_usuario: id_usuario,
                id_grupo: id_grupo
            }
        },

        "columns": [
            { "defaultContent": "" },
            { "data": "Estudiante" },
            { "data": "titulo" },

            {
                "defaultContent": "<button style='font-size:13px;' type='button' title='Archivo' class='abrir btn btn-default'><i class='fa  fa-eye'></i></button>"
            },

            { "data": "fecha" },

        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_trabajos_entregar_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });
    tabla_trabajos_entregar.on('draw.dt', function () {
        var PageInfo = $('#tabla_trabajos_entregar').DataTable().page.info();
        tabla_trabajos_entregar.column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });
}

$('#tabla_trabajos_entregados').on('click', '.abrir', function () {
    var data = tabla_trabajos_entregados.row($(this).parents('tr')).data();
    if (tabla_trabajos_entregados.row(this).child.isShown()) {
        var data = tabla_trabajos_entregar.row(this).data();
    }

    $("#modal_archivos").modal({
        backdrop: 'static',
        keyboard: false
    })

    $("#modal_archivos").modal('show');
    $("#txt_id_taller_ob").val(data.ID);
    $('#txt_archivo').attr("src", "../" + data.archivo);
    $("#foto").attr('src', '../' + data.foto);
    $('#descripcion_ver').val(data.detalles);
    $("#lbl_titulo").html(data.titulo);
    $("#lbl_descripcion").css("white-space", "pre-wrap");
    var notaHtml = (data.nota != null && data.nota != '') ? data.nota : 'No hay nota del estudiante.';
    $("#lbl_descripcion").html(notaHtml);
    $("#txtdocente").html(data.Estudiante);
    $("#txt_materia").html(data.nombre);
    $("#txtgrado").html(data.aula);
    $("#txtfecha").html(data.fecha);
    $("#lbl_nota_docente").css("white-space", "pre-wrap");
    var nota_docenteHtml = (data.nota_docente != null && data.nota_docente != '') ? data.nota_docente : 'No hay Observación para el estudiante.';
    $("#lbl_nota_docente").html(nota_docenteHtml);

});

// ------------LISTAR COMBOS--------------

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