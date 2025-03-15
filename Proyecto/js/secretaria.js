var table_secretaria;
function listar_grupos() {

    table_secretaria = $("#tabla_secretaria").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/secretaria/controlador_secretaria_listar.php",
            type: 'POST'
        },
        "columns": [
            { "data": "Posicion" },
            { "data": "aula" },
            { "data": "docente" },
            { "data": "nombre" },
            { "data": "fecha_asignacion" },

            {
                "data": "status",
                render: function (data, type, row) {
                    if (data == 'ACTIVO') {
                        return "<span class='label label-success'>" + data + "</span>";
                    } else {
                        return "<span class='label label-danger'>" + data + "</span>";
                    }
                }
            },

            { "defaultContent": "<button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fa fa-edit'>" }
        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_secretaria_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });

    function filterGlobal() {
        $('#tabla_secretaria').DataTable().search(
            $('#global_filter').val()
        ).draw();
    }

}


function abrir_registro() {

    $("#modal_registro").modal({ backdrop: 'static', keyboard: false })
    $("#modal_registro").modal('show');
    $('.js-example-basic-single').select2();
    $('.js-example-basic-single1').select2();
    $('.js-example-basic-single2').select2();
}

$('#tabla_secretaria').on('click', '.activar', function () {
    var data = table_secretaria.row($(this).parents('tr')).data();
    if (table_secretaria.row(this).child.isShown()) {
        var data = table_secretaria.row(this).data();
    }
    Swal.fire({
        title: 'Esta seguro de activar al usuario?',
        text: "Una vez hecho esto el usuario  tendra acceso al sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.value) {
            Modificar_Estatus(data.id_curso, 'ACTIVO');
        }
    })
})

$('#tabla_secretaria').on('click', '.desactivar', function () {
    var data = table_secretaria.row($(this).parents('tr')).data();
    if (table_secretaria.row(this).child.isShown()) {
        var data = table_secretaria.row(this).data();
    }
    Swal.fire({
        title: 'Esta seguro de desactivar al usuario?',
        text: "Una vez hecho esto el usuario no tendra acceso al sistema",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si'
    }).then((result) => {
        if (result.value) {
            Modificar_Estatus(data.id_curso, 'INACTIVO');
        }
    })
})


function Modificar_Estatus(ID, estatus) {
    var mensaje = "";
    if (estatus == 'INACTIVO') {
        mensaje = "desactivo";
    } else {
        mensaje = "activo";
    }
    $.ajax({
        "url": "../controlador/secretaria/controlador_modificar_estatus_grupo.php",
        type: 'POST',
        data: {
            ID: ID,
            estatus: estatus
        }
    }).done(function (resp) {
        if (resp > 0) {
            Swal.fire("Mensaje De Confirmacion", "El usuario se " + mensaje + " con exito", "success")
                .then((value) => {
                    table_secretaria.ajax.reload();
                });
        }
    })


}
$('#tabla_secretaria').on('click', '.editar', function () {
    var data = table_secretaria.row($(this).parents('tr')).data();
    if (table_secretaria.row(this).child.isShown()) {
        var data = table_secretaria.row(this).data();
    }
    $("#modal_editar").modal({ backdrop: 'static', keyboard: false })
    $("#modal_editar  ").modal('show');
    $('.js-example-basic-single').select2();
    $('.js-example-basic-single1').select2();
    $('.js-example-basic-single2').select2();
    $("#id_grupo").val(data.ID).hide();
    $("#cbm_grupo_editar").val(data.id_aula).trigger('change');
    $("#cbm_docente_editar").val(data.id_docente).trigger('change');
    $("#cbm_asignatura_editar").val(data.id_curso).trigger('change');

})
function listar_combo_rol_docente() {

    $.ajax({
        url: "../controlador/secretaria/controlador_combo_docente_listar.php",
        type: "POST"
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + " </option>";

            } -
                $("#cbm_docente").html(cadena);


        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_docente").html(cadena);

        }


    })
}

function listar_combo_rol_docente_editar() {

    $.ajax({
        url: "../controlador/secretaria/controlador_combo_docente_listar.php",
        type: "POST"
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + " </option>";

            }

            $("#cbm_docente_editar").html(cadena);

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";

            $("#cbm_docente_editar").html(cadena);
        }


    })
}

function listar_combo_grado() {

    $.ajax({
        url: "../controlador/secretaria/controlador_combo_grado_listar.php",
        type: "POST"
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + " </option>";

            }
            $("#cbm_grupo").html(cadena);


        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_grupo").html(cadena);

        }


    })
}
function listar_combo_grado_editar() {

    $.ajax({
        url: "../controlador/secretaria/controlador_combo_grado_listar.php",
        type: "POST"
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + " </option>";

            }

            $("#cbm_grupo_editar").html(cadena);

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";

            $("#cbm_grupo_editar").html(cadena);
        }


    })
}
function listar_combo_asignatura() {

    $.ajax({
        url: "../controlador/secretaria/controlador_combo_asignatura_listar.php",
        type: "POST"
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + " </option>";

            }
            $("#cbm_asignatura").html(cadena);


        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_asignatura").html(cadena);

        }


    })

}

function listar_combo_asignatura_editar() {

    $.ajax({
        url: "../controlador/secretaria/controlador_combo_asignatura_listar.php",
        type: "POST"
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + " </option>";

            }

            $("#cbm_asignatura_editar").html(cadena);

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";

            $("#cbm_asignatura_editar").html(cadena);
        }


    })

}
function traerdatos() {
    $.ajax({
        url: "../controlador/secretaria/controlador_traer_datos.php",
        type: "POST"
    }).done(function (resp) {
        var data = JSON.parse(resp);

        if (data > 0) {
            $("#id_grupo").val(data[0][1]);
            $("#txt_asignatura").val(data[0][3]);
            $("#txt_docente").val(data[0][2]);

        }
    })
}
function Registrar_Grupo() {
    var docente = $("#cbm_docente").val();
    var asignatura = $("#cbm_asignatura").val();
    var grupo = $("#cbm_grupo").val();
    if (docente.length == 0 || asignatura.length == 0 || grupo.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }

    $.ajax({
        url: "../controlador/secretaria/controlador_registrar_grupo.php",
        type: "POST",
        data: {
            docente: docente,
            asignatura: asignatura,
            grupo: grupo

        }
    }).done(function (resp) {
        if (resp > 0) {
            if (resp == 1) {
                Swal.fire("Mensaje De Confirmacion", "Nuevo Grupo, registrado correctamente", "success").then((value) => {

                    table_secretaria.ajax.reload();
                    $("#modal_registro").modal('hide');

                });
            } else {
                Swal.fire("Mensaje De Advertencia ", "lo sentimos,  ya esta asignado este grupo  para esa asignatura", "warning");
            }

        }
        else {
            Swal.fire("Mensaje de Error", "no se pudo completar el registro", "error");
        }
    })
}


function modificar_grupo() {
    var id_detalles_curso = $("#id_grupo").val();
    var id_docente = $("#cbm_docente_editar").val();
    var id_asignatura = $("#cbm_asignatura_editar").val();
    var id_grupo = $("#cbm_grupo_editar").val();
    if (id_detalles_curso == null) {
        return Swal.fire("Mensaje De Error", "no se encontraron datos", "error");
    }
    if (id_grupo.length == 0 || id_docente.length == 0 || id_asignatura.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }
    $.ajax({
        url: "../controlador/secretaria/controlador_modificar_grupo.php",
        type: "POST",
        data: {
            id_detalles_curso: id_detalles_curso,
            id_grupo: id_grupo,
            id_docente: id_docente,
            id_asignatura: id_asignatura
        }
    }).done(function (resp) {
        if (resp > 0) {

            if (resp == 1) {
                Swal.fire("Mensaje De Confirmacion", "Datos Actualizados Correctamente", "success").then((value) => {

                    table_secretaria.ajax.reload();
                    $("#modal_editar").modal('hide');

                });
            } else {
                Swal.fire("Mensaje De Advertencia ", "lo sentimos,  ya esta asignado este grupo  para esa asignatura", "warning");
            }

        } else {
            Swal.fire("Mensaje De Error", "no se pudo actualizar los Datos", "error");
        }
    })
}

var table_grupo;
function listar_asignacion_grupo(id_grupo, id_docente) {
    if (id_grupo == null) {
        id_grupo = 0;
        id_docente = 0;
    }

    table_grupo = $("#tabla_grupos").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/secretaria/controlador_grupo_listar.php",
            type: 'POST',
            data: {
                id_grupo: id_grupo,
                id_docente: id_docente
            }
        },
        "columns": [
            { "defaultContent": "" },
            { "data": "grupo" },
            { "data": "docente" },
            { "data": "estudiantes" }




        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_grupos_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });
    table_grupo.on('draw.td', function () {
        var pageinfo = $("#tabla_grupos").DataTable().page.info();
        table_grupo.column(0, { page: 'current' }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + pageinfo.start;
        });
    });

}
function listar_combo_grupo(id_docente) {


    $.ajax({
        url: "../controlador/secretaria/controlador_combo_grupo_listar.php",
        type: "POST",
        data: {
            id_docente: id_docente
        }
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + " -- " + data[i][2] + "  </option>";

            }

            $("#cbm_grupos").html(cadena);


        } else {
            if (cadena == '') {

            }
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";

            $("#cbm_grupos").html(cadena);
        }


    })

}
function listar_combo_grupos(id_docente) {
    if (id_docente == null) {
        id_docente = 0;
    }
    $.ajax({
        url: "../controlador/secretaria/controlador_combo_grupo_listar.php",
        type: "POST",
        data: {
            id_docente: id_docente
        }
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";


        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + " -- " + data[i][2] + "  </option>";



            }

            $("#cbm_grupo_listar").html(cadena);
            var id = $("#cbm_grupo_listar").val();

            if (id == "") {
                $("#cbm_grupo_verifity").val(id).trigger('change');

            }
            listar_combo_grupo_verifity(id);


            verificar();


        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_grupo_listar").html(cadena);


        }


    })

}
function listar_combo_grupos_estudiantes(id_docente, id_curso, id_aula) {

    if (id_docente == null || id_curso == null || id_aula == null) {
        id_docente = 0;
        id_curso = 0;
        id_aula = 0;
    }

    $.ajax({
        url: "../controlador/secretaria/controlador_combo_grupo_estudiante_listar.php",
        type: "POST",
        data: {

            id_docente: id_docente,
            id_curso: id_curso,
            id_aula: id_aula
        }
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";

        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + " </option>";



            }

            $("#cbm_estudiante").html(cadena);
            var id = $("#cbm_estudiante").val();

            if (id == "") {
                $("#cbm_calificaciones").val(id).trigger('change');
            }
            listar_combo_grupos_calificaciones(id);
            verificar();




        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_estudiante").html(cadena);
        }


    })

}

function listar_combo_grupos_calificaciones(id_estudiante) {

    if (id_estudiante == null) {
        id_estudiante = 0;

    }

    $.ajax({
        url: "../controlador/secretaria/controlador_combo_grupo_calificaciones_estudiante_listar.php",
        type: "POST",
        data: {

            id_estudiante: id_estudiante
        }
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";

        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][0] + " </option>";



            }

            $("#cbm_calificaciones").html(cadena);



        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_calificaciones").html(cadena);
        }


    })

}
function listar_combo_grupo_verifity(id_grupo) {

    $.ajax({
        url: "../controlador/secretaria/controlador_combo_grupo_verifity_listar.php",
        type: "POST",
        data: {

            id_grupo: id_grupo
        }
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][0] + " </option>";
                listar_combo_grupos_estudiantes(data[i][2], data[i][1], data[i][3]);

            }

            $("#cbm_grupo_verifity").html(cadena);

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";

            $("#cbm_grupo_verifity").html(cadena);
        }


    })

}

function listar_combo_profesores() {

    $.ajax({
        url: "../controlador/secretaria/controlador_combo_docentes_listar.php",
        type: "POST"
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + " </option>";

            }

            $("#cbm_profesor").html(cadena);

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";

            $("#cbm_profesor").html(cadena);
        }


    })

}

function listar_combo_docente() {

    $.ajax({
        url: "../controlador/secretaria/controlador_combo_docentes_listar.php",
        type: "POST"
    }).done(function (resp) {
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {

            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + " </option>";

            }

            $("#cbm_docente").html(cadena);


        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";

            $("#cbm_docente").html(cadena);

        }


    })

}

function verificar() {
    var id_grupo = $("#cbm_grupo_listar").val();

    var id_docente = $("#cbm_docente").val();

    listar_combo_verificar_estudiante(id_docente, id_grupo);

}

function datos() {

    var id_grupo = $("#cbm_grupos").val();
    var id_docente = $("#cbm_profesor").val();
    listar_combo_grupo(id_docente);
    listar_asignacion_grupo(id_grupo, id_docente);
}

function registar() {

    var id_grupo = $("#cbm_grupo_listar").val();
    var id_docente = $("#cbm_docente").val();
    var id_calificaciones = $("#cbm_calificaciones").val();


    $.ajax({
        url: '../controlador/secretaria/controlador_registrar_estudiantes.php',
        type: 'POST',
        data: {

            id_calificaciones: id_calificaciones,
            id_grupo: id_grupo,
            id_docente: id_docente

        }
    }).done(function (resp) {
        if (resp > 0) {
            if (resp == 1) {
                Swal.fire({
                    title: 'Estudiantes Registrado correctamente',
                    text: 'Datos de Confirmaci\u00f3n',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si'
                }).then((result) => {
                    if (result.value) {
                        $("#modal_registro").modal('show');
                    } else {

                        $("#modal_registro").modal('hide');

                    }
                })
                table_grupo.ajax.reload();

            }
            else {
                Swal.fire("Mensaje De Advertencia", "Estudiantes ya se encuentra registrado a este grupo ", "warning");

            }
        } else {
            Swal.fire("Mensaje De Error", "Lo sentimos  no se pudo completar el registro", "error");
        }
    })
}