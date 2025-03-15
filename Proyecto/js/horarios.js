
var tabla_horarios;
function listar_horarios() {
}
tabla_horarios = $("#tabla_horarios").DataTable({
    "ordering": false,
    "bLengthChange": true,
    "searching": { "regex": false },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    "pageLength": 10,
    "destroy": true,
    "async": false,
    "processing": true,
    "ajax": {
        "url": "../controlador/horarios/controlador_listar_horarios.php",
        type: 'POST',
    },
    "order": [[1, 'asc']],
    "columns": [
        { "defaultContent": "" },
        { "data": "aula" },
        {
            "defaultContent": "<button style='font-size:13px; margin-right: 1px;' type='button' class='ver_horarios btn btn-default' title='Ver horario'><i class='fa fa-eye'></i></button>&nbsp;"
        },

        { "defaultContent": "<button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fa fa-edit'></i></button>" }
    ],

    "language": idioma_espanol,
    select: true
});
document.getElementById("tabla_horarios_filter").style.display = "none";
$('input.global_filter').on('keyup click', function () {
    filterGlobal();
});
$('input.column_filter').on('keyup click', function () {
    filterColumn($(this).parents('tr').attr('data-column'));
});
function filterGlobal() {
    $('#tabla_horarios').DataTable().search(
        $('#global_filter').val()
    ).draw();
}
tabla_horarios.on('draw.dt', function () {
    var PageInfo = $('#tabla_horarios').DataTable().page.info();
    tabla_horarios.column(0, {
        page: 'current'
    }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1 + PageInfo.start;
    });
});

//----------------TABLA DOCENTES---------------------
var tabla_horarios_docente;
function listar_horarios_docente() {
    tabla_horarios_docente = $("#tabla_horarios_docente").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/horarios/controlador_listar_horarios_docente.php",
            type: 'POST',
        },
        "order": [[1, 'asc']],
        "columns": [
            { "defaultContent": "" },
            { "data": "docente" },
            {
                "defaultContent": "<button style='font-size:13px; margin-right: 1px;' type='button' class='ver_horario_docente btn btn-default' title='Ver horario'><i class='fa fa-eye'></i></button>&nbsp;"
            },
            { "defaultContent": "<button style='font-size:13px;' type='button' class='editar_docente btn btn-primary'><i class='fa fa-edit'></i></button>" }
        ],
        "language": idioma_espanol,
        select: true
    });

    document.getElementById("tabla_horarios_docente_filter").style.display = "none";

    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });

    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });

    function filterGlobal() {
        $('#tabla_horarios_docente').DataTable().search(
            $('#global_filter').val()
        ).draw();
    }

    tabla_horarios_docente.on('draw.dt', function () {
        var PageInfo = $('#tabla_horarios_docente').DataTable().page.info();
        tabla_horarios_docente.column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });
}

//-------------modales---------------------------------

function registrar_horarios() {
    $("#modal_registro_horarios").modal({ backdrop: 'static', keyboard: false })
    $("#modal_registro_horarios").modal('show');
    $('.js-example-basic-single').select2();
    $('.js').select2();
}

function registrar_horarios_docentes() {
    $("#modal_registro_horarios_docente").modal({ backdrop: 'static', keyboard: false })
    $("#modal_registro_horarios_docente").modal('show');
    $('.js-example-basic-single').select2();
    $('.js').select2();
}

function ver_horario_estudiante() {
    $("#modal_ver_horarios_estudiante").modal({ backdrop: 'static', keyboard: false })
    $("#modal_ver_horarios_estudiante").modal('show');
    Horario_Estudiante();
}

function ver_horario_docente() {
    $("#modal_ver_horarios_docente").modal({ backdrop: 'static', keyboard: false })
    $("#modal_ver_horarios_docente").modal('show');
    Horario_Docente();
}


$('#tabla_horarios').on('click', '.editar', function () {
    var data = tabla_horarios.row($(this).parents('tr')).data();
    if (tabla_horarios.row(this).child.isShown()) {
        var data = tabla_horarios.row(this).data();
    }

    $("#modal_editar_horarios").modal({ backdrop: 'static', keyboard: false })
    $("#modal_editar_horarios").modal('show');
    $("#txt_id_horario").val(data.ID);
    $("#txt_grado_editar").html(data.aula);
    $("#bloque_1_editar").val(data.bloque_1);
    $("#bloque_2_editar").val(data.bloque_2);
    $("#bloque_3_editar").val(data.bloque_3);
    $("#bloque_4_editar").val(data.bloque_4);
    $("#bloque_5_editar").val(data.bloque_5);
    $("#bloque_6_editar").val(data.bloque_6);

    $("#cbm_lunes_1_editar").val(data.id_lunes_1).trigger("change");
    $("#cbm_lunes_2_editar").val(data.id_lunes_2).trigger("change");
    $("#cbm_lunes_3_editar").val(data.id_lunes_3).trigger("change");
    $("#cbm_lunes_4_editar").val(data.id_lunes_4).trigger("change");
    $("#cbm_lunes_5_editar").val(data.id_lunes_5).trigger("change");
    $("#cbm_lunes_6_editar").val(data.id_lunes_6).trigger("change");

    $("#cbm_martes_1_editar").val(data.id_martes_1).trigger("change");
    $("#cbm_martes_2_editar").val(data.id_martes_2).trigger("change");
    $("#cbm_martes_3_editar").val(data.id_martes_3).trigger("change");
    $("#cbm_martes_4_editar").val(data.id_martes_4).trigger("change");
    $("#cbm_martes_5_editar").val(data.id_martes_5).trigger("change");
    $("#cbm_martes_6_editar").val(data.id_martes_6).trigger("change");

    $("#cbm_miercoles_1_editar").val(data.id_miercoles_1).trigger("change");
    $("#cbm_miercoles_2_editar").val(data.id_miercoles_2).trigger("change");
    $("#cbm_miercoles_3_editar").val(data.id_miercoles_3).trigger("change");
    $("#cbm_miercoles_4_editar").val(data.id_miercoles_4).trigger("change");
    $("#cbm_miercoles_5_editar").val(data.id_miercoles_5).trigger("change");
    $("#cbm_miercoles_6_editar").val(data.id_miercoles_6).trigger("change");

    $("#cbm_jueves_1_editar").val(data.id_jueves_1).trigger("change");
    $("#cbm_jueves_2_editar").val(data.id_jueves_2).trigger("change");
    $("#cbm_jueves_3_editar").val(data.id_jueves_3).trigger("change");
    $("#cbm_jueves_4_editar").val(data.id_jueves_4).trigger("change");
    $("#cbm_jueves_5_editar").val(data.id_jueves_5).trigger("change");
    $("#cbm_jueves_6_editar").val(data.id_jueves_6).trigger("change");

    $("#cbm_viernes_1_editar").val(data.id_viernes_1).trigger("change");
    $("#cbm_viernes_2_editar").val(data.id_viernes_2).trigger("change");
    $("#cbm_viernes_3_editar").val(data.id_viernes_3).trigger("change");
    $("#cbm_viernes_4_editar").val(data.id_viernes_4).trigger("change");
    $("#cbm_viernes_5_editar").val(data.id_viernes_5).trigger("change");
    $("#cbm_viernes_6_editar").val(data.id_viernes_6).trigger("change");

    $('.js-example-basic-single').select2();
    $('.js').select2();

})

$(document).ready(function () {
    $(document).on('click', '#tabla_horarios_docente .editar_docente', function () {
        console.log("Botón 'Editar' clickeado");
        var data = tabla_horarios_docente.row($(this).parents('tr')).data();
        console.log("Data:", data);


        $("#modal_editar_horarios_docente").modal({ backdrop: 'static', keyboard: false })
        $("#modal_editar_horarios_docente").modal('show');
        $("#txt_id_horario_docente").val(data.ID);
        $("#txt_docente_editar").html(data.docente);
        $("#bloque_1_editar").val(data.bloque_1);
        $("#bloque_2_editar").val(data.bloque_2);
        $("#bloque_3_editar").val(data.bloque_3);
        $("#bloque_4_editar").val(data.bloque_4);
        $("#bloque_5_editar").val(data.bloque_5);
        $("#bloque_6_editar").val(data.bloque_6);

        $("#cbm_lunes_1_editar").val(data.lunes_1).trigger("change");
        $("#cbm_lunes_2_editar").val(data.lunes_2).trigger("change");
        $("#cbm_lunes_3_editar").val(data.lunes_3).trigger("change");
        $("#cbm_lunes_4_editar").val(data.lunes_4).trigger("change");
        $("#cbm_lunes_5_editar").val(data.lunes_5).trigger("change");
        $("#cbm_lunes_6_editar").val(data.lunes_6).trigger("change");

        $("#cbm_martes_1_editar").val(data.martes_1).trigger("change");
        $("#cbm_martes_2_editar").val(data.martes_2).trigger("change");
        $("#cbm_martes_3_editar").val(data.martes_3).trigger("change");
        $("#cbm_martes_4_editar").val(data.martes_4).trigger("change");
        $("#cbm_martes_5_editar").val(data.martes_5).trigger("change");
        $("#cbm_martes_6_editar").val(data.martes_6).trigger("change");

        $("#cbm_miercoles_1_editar").val(data.miercoles_1).trigger("change");
        $("#cbm_miercoles_2_editar").val(data.miercoles_2).trigger("change");
        $("#cbm_miercoles_3_editar").val(data.miercoles_3).trigger("change");
        $("#cbm_miercoles_4_editar").val(data.miercoles_4).trigger("change");
        $("#cbm_miercoles_5_editar").val(data.miercoles_5).trigger("change");
        $("#cbm_miercoles_6_editar").val(data.miercoles_6).trigger("change");

        $("#cbm_jueves_1_editar").val(data.jueves_1).trigger("change");
        $("#cbm_jueves_2_editar").val(data.jueves_2).trigger("change");
        $("#cbm_jueves_3_editar").val(data.jueves_3).trigger("change");
        $("#cbm_jueves_4_editar").val(data.jueves_4).trigger("change");
        $("#cbm_jueves_5_editar").val(data.jueves_5).trigger("change");
        $("#cbm_jueves_6_editar").val(data.jueves_6).trigger("change");

        $("#cbm_viernes_1_editar").val(data.viernes_1).trigger("change");
        $("#cbm_viernes_2_editar").val(data.viernes_2).trigger("change");
        $("#cbm_viernes_3_editar").val(data.viernes_3).trigger("change");
        $("#cbm_viernes_4_editar").val(data.viernes_4).trigger("change");
        $("#cbm_viernes_5_editar").val(data.viernes_5).trigger("change");
        $("#cbm_viernes_6_editar").val(data.viernes_6).trigger("change");


        // Para lunes del 1 al 6
        $("#cbm_grado_editar_lunes_1").val(data.grado_lunes_1).trigger("change");
        $("#cbm_grado_editar_lunes_2").val(data.grado_lunes_2).trigger("change");
        $("#cbm_grado_editar_lunes_3").val(data.grado_lunes_3).trigger("change");
        $("#cbm_grado_editar_lunes_4").val(data.grado_lunes_4).trigger("change");
        $("#cbm_grado_editar_lunes_5").val(data.grado_lunes_5).trigger("change");
        $("#cbm_grado_editar_lunes_6").val(data.grado_lunes_6).trigger("change");

        // Para martes del 1 al 6
        $("#cbm_grado_editar_martes_1").val(data.grado_martes_1).trigger("change");
        $("#cbm_grado_editar_martes_2").val(data.grado_martes_2).trigger("change");
        $("#cbm_grado_editar_martes_3").val(data.grado_martes_3).trigger("change");
        $("#cbm_grado_editar_martes_4").val(data.grado_martes_4).trigger("change");
        $("#cbm_grado_editar_martes_5").val(data.grado_martes_5).trigger("change");
        $("#cbm_grado_editar_martes_6").val(data.grado_martes_6).trigger("change");

        // Para miércoles del 1 al 6
        $("#cbm_grado_editar_miercoles_1").val(data.grado_miercoles_1).trigger("change");
        $("#cbm_grado_editar_miercoles_2").val(data.grado_miercoles_2).trigger("change");
        $("#cbm_grado_editar_miercoles_3").val(data.grado_miercoles_3).trigger("change");
        $("#cbm_grado_editar_miercoles_4").val(data.grado_miercoles_4).trigger("change");
        $("#cbm_grado_editar_miercoles_5").val(data.grado_miercoles_5).trigger("change");
        $("#cbm_grado_editar_miercoles_6").val(data.grado_miercoles_6).trigger("change");

        // Para jueves del 1 al 6
        $("#cbm_grado_editar_jueves_1").val(data.grado_jueves_1).trigger("change");
        $("#cbm_grado_editar_jueves_2").val(data.grado_jueves_2).trigger("change");
        $("#cbm_grado_editar_jueves_3").val(data.grado_jueves_3).trigger("change");
        $("#cbm_grado_editar_jueves_4").val(data.grado_jueves_4).trigger("change");
        $("#cbm_grado_editar_jueves_5").val(data.grado_jueves_5).trigger("change");
        $("#cbm_grado_editar_jueves_6").val(data.grado_jueves_6).trigger("change");

        // Para viernes del 1 al 6
        $("#cbm_grado_editar_viernes_1").val(data.grado_viernes_1).trigger("change");
        $("#cbm_grado_editar_viernes_2").val(data.grado_viernes_2).trigger("change");
        $("#cbm_grado_editar_viernes_3").val(data.grado_viernes_3).trigger("change");
        $("#cbm_grado_editar_viernes_4").val(data.grado_viernes_4).trigger("change");
        $("#cbm_grado_editar_viernes_5").val(data.grado_viernes_5).trigger("change");
        $("#cbm_grado_editar_viernes_6").val(data.grado_viernes_6).trigger("change");



        $('.js-example-basic-single').select2();
        $('.js').select2();


    });
});



$(document).ready(function () {
    $(document).on('click', '#tabla_horarios_docente .ver_horario_docente', function () {
        console.log("Botón 'Editar' clickeado");
        var data = tabla_horarios_docente.row($(this).closest('tr')).data();
        console.log("Data:", data);

        $("#modal_ver_horarios_docente").modal({ backdrop: 'static', keyboard: false });
        $("#modal_ver_horarios_docente").modal('show');

        if (data) {
            $("#txt_grado").html(data.docente);

            for (var dia = 0; dia < 5; dia++) {
                for (var bloque = 1; bloque <= 6; bloque++) {
                    var campoID = "#txt_" + ["lunes", "martes", "miercoles", "jueves", "viernes"][dia] + "_" + bloque;
                    var celda = $(campoID);
                    var asignacion = data[["lunes", "martes", "miercoles", "jueves", "viernes"][dia] + "_" + bloque];

                    if (asignacion === "SIN ASIGNACIÓN") {
                        celda.text(asignacion);
                    } else {
                        celda.html(asignacion + "<br>Grado: " + data["grado_" + ["lunes", "martes", "miercoles", "jueves", "viernes"][dia] + "_" + bloque]);
                    }

                    if (asignacion === "SIN ASIGNACIÓN") {
                        celda.css("background-color", "#FFCCCC"); // Rojo claro
                    } else {
                        celda.css("background-color", "#CCFFCC"); // Verde claro
                    }
                }
            }
        } else {
            console.log("No se encontraron datos para esta fila.");
        }
    });
});





$('#tabla_horarios').on('click', '.ver_horarios', function () {
    var data = tabla_horarios.row($(this).parents('tr')).data();
    if (tabla_horarios.row(this).child.isShown()) {
        var data = tabla_horarios.row(this).data();
    }

    $("#modal_ver_horarios").modal({ backdrop: 'static', keyboard: false })
    $("#modal_ver_horarios").modal('show');

    $("#txt_grado").html(data.aula);
    $("#txt_bloque_1").html(data.bloque_1);
    $("#txt_bloque_2").html(data.bloque_2);
    $("#txt_bloque_3").html(data.bloque_3);
    $("#txt_bloque_4").html(data.bloque_4);
    $("#txt_bloque_5").html(data.bloque_5);
    $("#txt_bloque_6").html(data.bloque_6);
    $("#txt_lunes_1").html(data.lunes_1);
    $("#txt_lunes_2").html(data.lunes_2);
    $("#txt_lunes_3").html(data.lunes_3);
    $("#txt_lunes_4").html(data.lunes_4);
    $("#txt_lunes_5").html(data.lunes_5);
    $("#txt_lunes_6").html(data.lunes_6);

    $("#txt_martes_1").html(data.martes_1);
    $("#txt_martes_2").html(data.martes_2);
    $("#txt_martes_3").html(data.martes_3);
    $("#txt_martes_4").html(data.martes_4);
    $("#txt_martes_5").html(data.martes_5);
    $("#txt_martes_6").html(data.martes_6);

    $("#txt_miercoles_1").html(data.miercoles_1);
    $("#txt_miercoles_2").html(data.miercoles_2);
    $("#txt_miercoles_3").html(data.miercoles_3);
    $("#txt_miercoles_4").html(data.miercoles_4);
    $("#txt_miercoles_5").html(data.miercoles_5);
    $("#txt_miercoles_6").html(data.miercoles_6);

    $("#txt_jueves_1").html(data.jueves_1);
    $("#txt_jueves_2").html(data.jueves_2);
    $("#txt_jueves_3").html(data.jueves_3);
    $("#txt_jueves_4").html(data.jueves_4);
    $("#txt_jueves_5").html(data.jueves_5);
    $("#txt_jueves_6").html(data.jueves_6);

    $("#txt_viernes_1").html(data.viernes_1);
    $("#txt_viernes_2").html(data.viernes_2);
    $("#txt_viernes_3").html(data.viernes_3);
    $("#txt_viernes_4").html(data.viernes_4);
    $("#txt_viernes_5").html(data.viernes_5);
    $("#txt_viernes_6").html(data.viernes_6);
})

//----------------------combos------------------------------------
function listar_combo_grado() {
    $.ajax({
        "url": "../controlador/estudiante/controlador_combo_grado.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + "</option>";
            }
            $("#cbm_grado").html(cadena);
            $("#cbm_grado_editar").html(cadena);
        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_grado").html(cadena);
            $("#cbm_grado_editar").html(cadena);
        }
    })
}

function listar_combo_grado_docente() {
    $.ajax({
        "url": "../controlador/estudiante/controlador_combo_grado_docente.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][1] + "'>" + data[i][1] + "</option>";
            }
            // Para lunes del 1 al 6
            $("#cbm_grado_lunes_1").html(cadena);
            $("#cbm_grado_editar_lunes_1").html(cadena);

            $("#cbm_grado_lunes_2").html(cadena);
            $("#cbm_grado_editar_lunes_2").html(cadena);

            $("#cbm_grado_lunes_3").html(cadena);
            $("#cbm_grado_editar_lunes_3").html(cadena);

            $("#cbm_grado_lunes_4").html(cadena);
            $("#cbm_grado_editar_lunes_4").html(cadena);

            $("#cbm_grado_lunes_5").html(cadena);
            $("#cbm_grado_editar_lunes_5").html(cadena);

            $("#cbm_grado_lunes_6").html(cadena);
            $("#cbm_grado_editar_lunes_6").html(cadena);

            // Para martes del 1 al 6
            $("#cbm_grado_martes_1").html(cadena);
            $("#cbm_grado_editar_martes_1").html(cadena);

            $("#cbm_grado_martes_2").html(cadena);
            $("#cbm_grado_editar_martes_2").html(cadena);

            $("#cbm_grado_martes_3").html(cadena);
            $("#cbm_grado_editar_martes_3").html(cadena);

            $("#cbm_grado_martes_4").html(cadena);
            $("#cbm_grado_editar_martes_4").html(cadena);

            $("#cbm_grado_martes_5").html(cadena);
            $("#cbm_grado_editar_martes_5").html(cadena);

            $("#cbm_grado_martes_6").html(cadena);
            $("#cbm_grado_editar_martes_6").html(cadena);

            // Para miércoles del 1 al 6
            $("#cbm_grado_miercoles_1").html(cadena);
            $("#cbm_grado_editar_miercoles_1").html(cadena);

            $("#cbm_grado_miercoles_2").html(cadena);
            $("#cbm_grado_editar_miercoles_2").html(cadena);

            $("#cbm_grado_miercoles_3").html(cadena);
            $("#cbm_grado_editar_miercoles_3").html(cadena);

            $("#cbm_grado_miercoles_4").html(cadena);
            $("#cbm_grado_editar_miercoles_4").html(cadena);

            $("#cbm_grado_miercoles_5").html(cadena);
            $("#cbm_grado_editar_miercoles_5").html(cadena);

            $("#cbm_grado_miercoles_6").html(cadena);
            $("#cbm_grado_editar_miercoles_6").html(cadena);

            // Para jueves del 1 al 6
            $("#cbm_grado_jueves_1").html(cadena);
            $("#cbm_grado_editar_jueves_1").html(cadena);

            $("#cbm_grado_jueves_2").html(cadena);
            $("#cbm_grado_editar_jueves_2").html(cadena);

            $("#cbm_grado_jueves_3").html(cadena);
            $("#cbm_grado_editar_jueves_3").html(cadena);

            $("#cbm_grado_jueves_4").html(cadena);
            $("#cbm_grado_editar_jueves_4").html(cadena);

            $("#cbm_grado_jueves_5").html(cadena);
            $("#cbm_grado_editar_jueves_5").html(cadena);

            $("#cbm_grado_jueves_6").html(cadena);
            $("#cbm_grado_editar_jueves_6").html(cadena);

            // Para viernes del 1 al 6
            $("#cbm_grado_viernes_1").html(cadena);
            $("#cbm_grado_editar_viernes_1").html(cadena);

            $("#cbm_grado_viernes_2").html(cadena);
            $("#cbm_grado_editar_viernes_2").html(cadena);

            $("#cbm_grado_viernes_3").html(cadena);
            $("#cbm_grado_editar_viernes_3").html(cadena);

            $("#cbm_grado_viernes_4").html(cadena);
            $("#cbm_grado_editar_viernes_4").html(cadena);

            $("#cbm_grado_viernes_5").html(cadena);
            $("#cbm_grado_editar_viernes_5").html(cadena);

            $("#cbm_grado_viernes_6").html(cadena);
            $("#cbm_grado_editar_viernes_6").html(cadena);

        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            // Para lunes del 1 al 6
            $("#cbm_grado_lunes_1").html(cadena);
            $("#cbm_grado_editar_lunes_1").html(cadena);

            $("#cbm_grado_lunes_2").html(cadena);
            $("#cbm_grado_editar_lunes_2").html(cadena);

            $("#cbm_grado_lunes_3").html(cadena);
            $("#cbm_grado_editar_lunes_3").html(cadena);

            $("#cbm_grado_lunes_4").html(cadena);
            $("#cbm_grado_editar_lunes_4").html(cadena);

            $("#cbm_grado_lunes_5").html(cadena);
            $("#cbm_grado_editar_lunes_5").html(cadena);

            $("#cbm_grado_lunes_6").html(cadena);
            $("#cbm_grado_editar_lunes_6").html(cadena);

            // Para martes del 1 al 6
            $("#cbm_grado_martes_1").html(cadena);
            $("#cbm_grado_editar_martes_1").html(cadena);

            $("#cbm_grado_martes_2").html(cadena);
            $("#cbm_grado_editar_martes_2").html(cadena);

            $("#cbm_grado_martes_3").html(cadena);
            $("#cbm_grado_editar_martes_3").html(cadena);

            $("#cbm_grado_martes_4").html(cadena);
            $("#cbm_grado_editar_martes_4").html(cadena);

            $("#cbm_grado_martes_5").html(cadena);
            $("#cbm_grado_editar_martes_5").html(cadena);

            $("#cbm_grado_martes_6").html(cadena);
            $("#cbm_grado_editar_martes_6").html(cadena);

            // Para miércoles del 1 al 6
            $("#cbm_grado_miercoles_1").html(cadena);
            $("#cbm_grado_editar_miercoles_1").html(cadena);

            $("#cbm_grado_miercoles_2").html(cadena);
            $("#cbm_grado_editar_miercoles_2").html(cadena);

            $("#cbm_grado_miercoles_3").html(cadena);
            $("#cbm_grado_editar_miercoles_3").html(cadena);

            $("#cbm_grado_miercoles_4").html(cadena);
            $("#cbm_grado_editar_miercoles_4").html(cadena);

            $("#cbm_grado_miercoles_5").html(cadena);
            $("#cbm_grado_editar_miercoles_5").html(cadena);

            $("#cbm_grado_miercoles_6").html(cadena);
            $("#cbm_grado_editar_miercoles_6").html(cadena);

            // Para jueves del 1 al 6
            $("#cbm_grado_jueves_1").html(cadena);
            $("#cbm_grado_editar_jueves_1").html(cadena);

            $("#cbm_grado_jueves_2").html(cadena);
            $("#cbm_grado_editar_jueves_2").html(cadena);

            $("#cbm_grado_jueves_3").html(cadena);
            $("#cbm_grado_editar_jueves_3").html(cadena);

            $("#cbm_grado_jueves_4").html(cadena);
            $("#cbm_grado_editar_jueves_4").html(cadena);

            $("#cbm_grado_jueves_5").html(cadena);
            $("#cbm_grado_editar_jueves_5").html(cadena);

            $("#cbm_grado_jueves_6").html(cadena);
            $("#cbm_grado_editar_jueves_6").html(cadena);

            // Para viernes del 1 al 6
            $("#cbm_grado_viernes_1").html(cadena);
            $("#cbm_grado_editar_viernes_1").html(cadena);

            $("#cbm_grado_viernes_2").html(cadena);
            $("#cbm_grado_editar_viernes_2").html(cadena);

            $("#cbm_grado_viernes_3").html(cadena);
            $("#cbm_grado_editar_viernes_3").html(cadena);

            $("#cbm_grado_viernes_4").html(cadena);
            $("#cbm_grado_editar_viernes_4").html(cadena);

            $("#cbm_grado_viernes_5").html(cadena);
            $("#cbm_grado_editar_viernes_5").html(cadena);

            $("#cbm_grado_viernes_6").html(cadena);
            $("#cbm_grado_editar_viernes_6").html(cadena);

        }
    })
}


function listar_combo_docentes() {
    $.ajax({
        "url": "../controlador/horarios/controlador_combo_docentes.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][2] + "'>" + data[i][1] + "</option>";
            }
            $("#cbm_docentes").html(cadena);
            $("#cbm_docentes_editar").html(cadena);
        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_docentes").html(cadena);
            $("#cbm_docentes_editar").html(cadena);
        }
    })
}



function listar_combo_cursos() {
    $.ajax({
        "url": "../controlador/horarios/controlador_combo_cursos.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + "</option>";
            }
            // Para lunes del 1 al 6
            $("#cbm_lunes_1").html(cadena);
            $("#cbm_lunes_1_editar").html(cadena);

            $("#cbm_lunes_2").html(cadena);
            $("#cbm_lunes_2_editar").html(cadena);

            $("#cbm_lunes_3").html(cadena);
            $("#cbm_lunes_3_editar").html(cadena);

            $("#cbm_lunes_4").html(cadena);
            $("#cbm_lunes_4_editar").html(cadena);

            $("#cbm_lunes_5").html(cadena);
            $("#cbm_lunes_5_editar").html(cadena);

            $("#cbm_lunes_6").html(cadena);
            $("#cbm_lunes_6_editar").html(cadena);

            // Para martes del 1 al 6
            $("#cbm_martes_1").html(cadena);
            $("#cbm_martes_1_editar").html(cadena);

            $("#cbm_martes_2").html(cadena);
            $("#cbm_martes_2_editar").html(cadena);

            $("#cbm_martes_3").html(cadena);
            $("#cbm_martes_3_editar").html(cadena);

            $("#cbm_martes_4").html(cadena);
            $("#cbm_martes_4_editar").html(cadena);

            $("#cbm_martes_5").html(cadena);
            $("#cbm_martes_5_editar").html(cadena);

            $("#cbm_martes_6").html(cadena);
            $("#cbm_martes_6_editar").html(cadena);

            // Para miércoles del 1 al 6
            $("#cbm_miercoles_1").html(cadena);
            $("#cbm_miercoles_1_editar").html(cadena);

            $("#cbm_miercoles_2").html(cadena);
            $("#cbm_miercoles_2_editar").html(cadena);

            $("#cbm_miercoles_3").html(cadena);
            $("#cbm_miercoles_3_editar").html(cadena);

            $("#cbm_miercoles_4").html(cadena);
            $("#cbm_miercoles_4_editar").html(cadena);

            $("#cbm_miercoles_5").html(cadena);
            $("#cbm_miercoles_5_editar").html(cadena);

            $("#cbm_miercoles_6").html(cadena);
            $("#cbm_miercoles_6_editar").html(cadena);

            // Para jueves del 1 al 6
            $("#cbm_jueves_1").html(cadena);
            $("#cbm_jueves_1_editar").html(cadena);

            $("#cbm_jueves_2").html(cadena);
            $("#cbm_jueves_2_editar").html(cadena);

            $("#cbm_jueves_3").html(cadena);
            $("#cbm_jueves_3_editar").html(cadena);

            $("#cbm_jueves_4").html(cadena);
            $("#cbm_jueves_4_editar").html(cadena);

            $("#cbm_jueves_5").html(cadena);
            $("#cbm_jueves_5_editar").html(cadena);

            $("#cbm_jueves_6").html(cadena);
            $("#cbm_jueves_6_editar").html(cadena);

            // Para viernes del 1 al 6
            $("#cbm_viernes_1").html(cadena);
            $("#cbm_viernes_1_editar").html(cadena);

            $("#cbm_viernes_2").html(cadena);
            $("#cbm_viernes_2_editar").html(cadena);

            $("#cbm_viernes_3").html(cadena);
            $("#cbm_viernes_3_editar").html(cadena);

            $("#cbm_viernes_4").html(cadena);
            $("#cbm_viernes_4_editar").html(cadena);

            $("#cbm_viernes_5").html(cadena);
            $("#cbm_viernes_5_editar").html(cadena);

            $("#cbm_viernes_6").html(cadena);
            $("#cbm_viernes_6_editar").html(cadena);


        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            // Para lunes del 1 al 6
            $("#cbm_lunes_1").html(cadena);
            $("#cbm_lunes_1_editar").html(cadena);

            $("#cbm_lunes_2").html(cadena);
            $("#cbm_lunes_2_editar").html(cadena);

            $("#cbm_lunes_3").html(cadena);
            $("#cbm_lunes_3_editar").html(cadena);

            $("#cbm_lunes_4").html(cadena);
            $("#cbm_lunes_4_editar").html(cadena);

            $("#cbm_lunes_5").html(cadena);
            $("#cbm_lunes_5_editar").html(cadena);

            $("#cbm_lunes_6").html(cadena);
            $("#cbm_lunes_6_editar").html(cadena);

            // Para martes del 1 al 6
            $("#cbm_martes_1").html(cadena);
            $("#cbm_martes_1_editar").html(cadena);

            $("#cbm_martes_2").html(cadena);
            $("#cbm_martes_2_editar").html(cadena);

            $("#cbm_martes_3").html(cadena);
            $("#cbm_martes_3_editar").html(cadena);

            $("#cbm_martes_4").html(cadena);
            $("#cbm_martes_4_editar").html(cadena);

            $("#cbm_martes_5").html(cadena);
            $("#cbm_martes_5_editar").html(cadena);

            $("#cbm_martes_6").html(cadena);
            $("#cbm_martes_6_editar").html(cadena);

            // Para miércoles del 1 al 6
            $("#cbm_miercoles_1").html(cadena);
            $("#cbm_miercoles_1_editar").html(cadena);

            $("#cbm_miercoles_2").html(cadena);
            $("#cbm_miercoles_2_editar").html(cadena);

            $("#cbm_miercoles_3").html(cadena);
            $("#cbm_miercoles_3_editar").html(cadena);

            $("#cbm_miercoles_4").html(cadena);
            $("#cbm_miercoles_4_editar").html(cadena);

            $("#cbm_miercoles_5").html(cadena);
            $("#cbm_miercoles_5_editar").html(cadena);

            $("#cbm_miercoles_6").html(cadena);
            $("#cbm_miercoles_6_editar").html(cadena);

            // Para jueves del 1 al 6
            $("#cbm_jueves_1").html(cadena);
            $("#cbm_jueves_1_editar").html(cadena);

            $("#cbm_jueves_2").html(cadena);
            $("#cbm_jueves_2_editar").html(cadena);

            $("#cbm_jueves_3").html(cadena);
            $("#cbm_jueves_3_editar").html(cadena);

            $("#cbm_jueves_4").html(cadena);
            $("#cbm_jueves_4_editar").html(cadena);

            $("#cbm_jueves_5").html(cadena);
            $("#cbm_jueves_5_editar").html(cadena);

            $("#cbm_jueves_6").html(cadena);
            $("#cbm_jueves_6_editar").html(cadena);

            // Para viernes del 1 al 6
            $("#cbm_viernes_1").html(cadena);
            $("#cbm_viernes_1_editar").html(cadena);

            $("#cbm_viernes_2").html(cadena);
            $("#cbm_viernes_2_editar").html(cadena);

            $("#cbm_viernes_3").html(cadena);
            $("#cbm_viernes_3_editar").html(cadena);

            $("#cbm_viernes_4").html(cadena);
            $("#cbm_viernes_4_editar").html(cadena);

            $("#cbm_viernes_5").html(cadena);
            $("#cbm_viernes_5_editar").html(cadena);

            $("#cbm_viernes_6").html(cadena);
            $("#cbm_viernes_6_editar").html(cadena);

        }
    })
}


function listar_combo_cursos_docentes() {
    $.ajax({
        "url": "../controlador/horarios/controlador_combo_cursos_docentes.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][1] + "'>" + data[i][1] + "</option>";
            }
            // Para lunes del 1 al 6
            $("#cbm_lunes_1").html(cadena);
            $("#cbm_lunes_1_editar").html(cadena);

            $("#cbm_lunes_2").html(cadena);
            $("#cbm_lunes_2_editar").html(cadena);

            $("#cbm_lunes_3").html(cadena);
            $("#cbm_lunes_3_editar").html(cadena);

            $("#cbm_lunes_4").html(cadena);
            $("#cbm_lunes_4_editar").html(cadena);

            $("#cbm_lunes_5").html(cadena);
            $("#cbm_lunes_5_editar").html(cadena);

            $("#cbm_lunes_6").html(cadena);
            $("#cbm_lunes_6_editar").html(cadena);

            // Para martes del 1 al 6
            $("#cbm_martes_1").html(cadena);
            $("#cbm_martes_1_editar").html(cadena);

            $("#cbm_martes_2").html(cadena);
            $("#cbm_martes_2_editar").html(cadena);

            $("#cbm_martes_3").html(cadena);
            $("#cbm_martes_3_editar").html(cadena);

            $("#cbm_martes_4").html(cadena);
            $("#cbm_martes_4_editar").html(cadena);

            $("#cbm_martes_5").html(cadena);
            $("#cbm_martes_5_editar").html(cadena);

            $("#cbm_martes_6").html(cadena);
            $("#cbm_martes_6_editar").html(cadena);

            // Para miércoles del 1 al 6
            $("#cbm_miercoles_1").html(cadena);
            $("#cbm_miercoles_1_editar").html(cadena);

            $("#cbm_miercoles_2").html(cadena);
            $("#cbm_miercoles_2_editar").html(cadena);

            $("#cbm_miercoles_3").html(cadena);
            $("#cbm_miercoles_3_editar").html(cadena);

            $("#cbm_miercoles_4").html(cadena);
            $("#cbm_miercoles_4_editar").html(cadena);

            $("#cbm_miercoles_5").html(cadena);
            $("#cbm_miercoles_5_editar").html(cadena);

            $("#cbm_miercoles_6").html(cadena);
            $("#cbm_miercoles_6_editar").html(cadena);

            // Para jueves del 1 al 6
            $("#cbm_jueves_1").html(cadena);
            $("#cbm_jueves_1_editar").html(cadena);

            $("#cbm_jueves_2").html(cadena);
            $("#cbm_jueves_2_editar").html(cadena);

            $("#cbm_jueves_3").html(cadena);
            $("#cbm_jueves_3_editar").html(cadena);

            $("#cbm_jueves_4").html(cadena);
            $("#cbm_jueves_4_editar").html(cadena);

            $("#cbm_jueves_5").html(cadena);
            $("#cbm_jueves_5_editar").html(cadena);

            $("#cbm_jueves_6").html(cadena);
            $("#cbm_jueves_6_editar").html(cadena);

            // Para viernes del 1 al 6
            $("#cbm_viernes_1").html(cadena);
            $("#cbm_viernes_1_editar").html(cadena);

            $("#cbm_viernes_2").html(cadena);
            $("#cbm_viernes_2_editar").html(cadena);

            $("#cbm_viernes_3").html(cadena);
            $("#cbm_viernes_3_editar").html(cadena);

            $("#cbm_viernes_4").html(cadena);
            $("#cbm_viernes_4_editar").html(cadena);

            $("#cbm_viernes_5").html(cadena);
            $("#cbm_viernes_5_editar").html(cadena);

            $("#cbm_viernes_6").html(cadena);
            $("#cbm_viernes_6_editar").html(cadena);


        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            // Para lunes del 1 al 6
            $("#cbm_lunes_1").html(cadena);
            $("#cbm_lunes_1_editar").html(cadena);

            $("#cbm_lunes_2").html(cadena);
            $("#cbm_lunes_2_editar").html(cadena);

            $("#cbm_lunes_3").html(cadena);
            $("#cbm_lunes_3_editar").html(cadena);

            $("#cbm_lunes_4").html(cadena);
            $("#cbm_lunes_4_editar").html(cadena);

            $("#cbm_lunes_5").html(cadena);
            $("#cbm_lunes_5_editar").html(cadena);

            $("#cbm_lunes_6").html(cadena);
            $("#cbm_lunes_6_editar").html(cadena);

            // Para martes del 1 al 6
            $("#cbm_martes_1").html(cadena);
            $("#cbm_martes_1_editar").html(cadena);

            $("#cbm_martes_2").html(cadena);
            $("#cbm_martes_2_editar").html(cadena);

            $("#cbm_martes_3").html(cadena);
            $("#cbm_martes_3_editar").html(cadena);

            $("#cbm_martes_4").html(cadena);
            $("#cbm_martes_4_editar").html(cadena);

            $("#cbm_martes_5").html(cadena);
            $("#cbm_martes_5_editar").html(cadena);

            $("#cbm_martes_6").html(cadena);
            $("#cbm_martes_6_editar").html(cadena);

            // Para miércoles del 1 al 6
            $("#cbm_miercoles_1").html(cadena);
            $("#cbm_miercoles_1_editar").html(cadena);

            $("#cbm_miercoles_2").html(cadena);
            $("#cbm_miercoles_2_editar").html(cadena);

            $("#cbm_miercoles_3").html(cadena);
            $("#cbm_miercoles_3_editar").html(cadena);

            $("#cbm_miercoles_4").html(cadena);
            $("#cbm_miercoles_4_editar").html(cadena);

            $("#cbm_miercoles_5").html(cadena);
            $("#cbm_miercoles_5_editar").html(cadena);

            $("#cbm_miercoles_6").html(cadena);
            $("#cbm_miercoles_6_editar").html(cadena);

            // Para jueves del 1 al 6
            $("#cbm_jueves_1").html(cadena);
            $("#cbm_jueves_1_editar").html(cadena);

            $("#cbm_jueves_2").html(cadena);
            $("#cbm_jueves_2_editar").html(cadena);

            $("#cbm_jueves_3").html(cadena);
            $("#cbm_jueves_3_editar").html(cadena);

            $("#cbm_jueves_4").html(cadena);
            $("#cbm_jueves_4_editar").html(cadena);

            $("#cbm_jueves_5").html(cadena);
            $("#cbm_jueves_5_editar").html(cadena);

            $("#cbm_jueves_6").html(cadena);
            $("#cbm_jueves_6_editar").html(cadena);

            // Para viernes del 1 al 6
            $("#cbm_viernes_1").html(cadena);
            $("#cbm_viernes_1_editar").html(cadena);

            $("#cbm_viernes_2").html(cadena);
            $("#cbm_viernes_2_editar").html(cadena);

            $("#cbm_viernes_3").html(cadena);
            $("#cbm_viernes_3_editar").html(cadena);

            $("#cbm_viernes_4").html(cadena);
            $("#cbm_viernes_4_editar").html(cadena);

            $("#cbm_viernes_5").html(cadena);
            $("#cbm_viernes_5_editar").html(cadena);

            $("#cbm_viernes_6").html(cadena);
            $("#cbm_viernes_6_editar").html(cadena);

        }
    })
}

//----------------------registrar y editar-----------------------------


function Registrar_Horario() {
    var grado = $("#cbm_grado").val();

    var bloque_1 = $("#bloque_1").val();
    var bloque_2 = $("#bloque_2").val();
    var bloque_3 = $("#bloque_3").val();
    var bloque_4 = $("#bloque_4").val();
    var bloque_5 = $("#bloque_5").val();
    var bloque_6 = $("#bloque_6").val();

    var lunes_1 = $("#cbm_lunes_1").val();
    var lunes_2 = $("#cbm_lunes_2").val();
    var lunes_3 = $("#cbm_lunes_3").val();
    var lunes_4 = $("#cbm_lunes_4").val();
    var lunes_5 = $("#cbm_lunes_5").val();
    var lunes_6 = $("#cbm_lunes_6").val();

    // Para martes del 1 al 6
    var martes_1 = $("#cbm_martes_1").val();
    var martes_2 = $("#cbm_martes_2").val();
    var martes_3 = $("#cbm_martes_3").val();
    var martes_4 = $("#cbm_martes_4").val();
    var martes_5 = $("#cbm_martes_5").val();
    var martes_6 = $("#cbm_martes_6").val();

    // Para miércoles del 1 al 6
    var miercoles_1 = $("#cbm_miercoles_1").val();
    var miercoles_2 = $("#cbm_miercoles_2").val();
    var miercoles_3 = $("#cbm_miercoles_3").val();
    var miercoles_4 = $("#cbm_miercoles_4").val();
    var miercoles_5 = $("#cbm_miercoles_5").val();
    var miercoles_6 = $("#cbm_miercoles_6").val();

    // Para jueves del 1 al 6
    var jueves_1 = $("#cbm_jueves_1").val();
    var jueves_2 = $("#cbm_jueves_2").val();
    var jueves_3 = $("#cbm_jueves_3").val();
    var jueves_4 = $("#cbm_jueves_4").val();
    var jueves_5 = $("#cbm_jueves_5").val();
    var jueves_6 = $("#cbm_jueves_6").val();

    // Para viernes del 1 al 6
    var viernes_1 = $("#cbm_viernes_1").val();
    var viernes_2 = $("#cbm_viernes_2").val();
    var viernes_3 = $("#cbm_viernes_3").val();
    var viernes_4 = $("#cbm_viernes_4").val();
    var viernes_5 = $("#cbm_viernes_5").val();
    var viernes_6 = $("#cbm_viernes_6").val();

    if (grado.length === 0 || lunes_1.length === 0 || lunes_2.length === 0 || lunes_3.length === 0 || lunes_4.length === 0 || lunes_5.length === 0 || lunes_6.length === 0 ||
        martes_1.length === 0 || martes_2.length === 0 || martes_3.length === 0 || martes_4.length === 0 || martes_5.length === 0 || martes_6.length === 0 ||
        miercoles_1.length === 0 || miercoles_2.length === 0 || miercoles_3.length === 0 || miercoles_4.length === 0 || miercoles_5.length === 0 || miercoles_6.length === 0 ||
        jueves_1.length === 0 || jueves_2.length === 0 || jueves_3.length === 0 || jueves_4.length === 0 || jueves_5.length === 0 || jueves_6.length === 0 ||
        viernes_1.length === 0 || viernes_2.length === 0 || viernes_3.length === 0 || viernes_4.length === 0 || viernes_5.length === 0 || viernes_6.length === 0 ||
        bloque_1.length === 0 || bloque_2.length === 0 || bloque_3.length === 0 || bloque_4.length === 0 || bloque_5.length === 0 || bloque_6.length === 0) {
        Swal.fire('Mensaje De Advertencia', 'Llene todos los campos vacíos', 'warning');
        return;
    }

    $.ajax({
        url: "../controlador/horarios/controlador_horario_registro.php",
        type: 'POST',
        data: {
            grado: grado,
            bloque_1: bloque_1,
            bloque_2: bloque_2,
            bloque_3: bloque_3,
            bloque_4: bloque_4,
            bloque_5: bloque_5,
            bloque_6: bloque_6,
            lunes_1: lunes_1,
            lunes_2: lunes_2,
            lunes_3: lunes_3,
            lunes_4: lunes_4,
            lunes_5: lunes_5,
            lunes_6: lunes_6,
            martes_1: martes_1,
            martes_2: martes_2,
            martes_3: martes_3,
            martes_4: martes_4,
            martes_5: martes_5,
            martes_6: martes_6,
            miercoles_1: miercoles_1,
            miercoles_2: miercoles_2,
            miercoles_3: miercoles_3,
            miercoles_4: miercoles_4,
            miercoles_5: miercoles_5,
            miercoles_6: miercoles_6,
            jueves_1: jueves_1,
            jueves_2: jueves_2,
            jueves_3: jueves_3,
            jueves_4: jueves_4,
            jueves_5: jueves_5,
            jueves_6: jueves_6,
            viernes_1: viernes_1,
            viernes_2: viernes_2,
            viernes_3: viernes_3,
            viernes_4: viernes_4,
            viernes_5: viernes_5,
            viernes_6: viernes_6
        }
    }).done(function (resp) {
        if (resp != "") {
            if (resp == -1) {
                Swal.fire("Mensaje De Advertencia", "El grado ya existe en la base de datos. Por favor, seleccione otro grado.", "warning");
                return;
            }

            if (resp == 1) {
                Swal.fire("Mensaje De Confirmacion", "Datos correctamente, Nuevo Horario Registrado", "success")
                    .then((value) => {
                        $("#modal_registro_horarios").modal('hide');
                        tabla_horarios.ajax.reload();
                    });
                return;
            }
        }

        Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
    });


}


function Editar_Horario() {

    var id_horario = $("#txt_id_horario").val();

    var bloque_1 = $("#bloque_1_editar").val();
    var bloque_2 = $("#bloque_2_editar").val();
    var bloque_3 = $("#bloque_3_editar").val();
    var bloque_4 = $("#bloque_4_editar").val();
    var bloque_5 = $("#bloque_5_editar").val();
    var bloque_6 = $("#bloque_6_editar").val();

    var lunes_1 = $("#cbm_lunes_1_editar").val();
    var lunes_2 = $("#cbm_lunes_2_editar").val();
    var lunes_3 = $("#cbm_lunes_3_editar").val();
    var lunes_4 = $("#cbm_lunes_4_editar").val();
    var lunes_5 = $("#cbm_lunes_5_editar").val();
    var lunes_6 = $("#cbm_lunes_6_editar").val();

    // Para martes del 1 al 6
    var martes_1 = $("#cbm_martes_1_editar").val();
    var martes_2 = $("#cbm_martes_2_editar").val();
    var martes_3 = $("#cbm_martes_3_editar").val();
    var martes_4 = $("#cbm_martes_4_editar").val();
    var martes_5 = $("#cbm_martes_5_editar").val();
    var martes_6 = $("#cbm_martes_6_editar").val();

    // Para miércoles del 1 al 6
    var miercoles_1 = $("#cbm_miercoles_1_editar").val();
    var miercoles_2 = $("#cbm_miercoles_2_editar").val();
    var miercoles_3 = $("#cbm_miercoles_3_editar").val();
    var miercoles_4 = $("#cbm_miercoles_4_editar").val();
    var miercoles_5 = $("#cbm_miercoles_5_editar").val();
    var miercoles_6 = $("#cbm_miercoles_6_editar").val();

    // Para jueves del 1 al 6
    var jueves_1 = $("#cbm_jueves_1_editar").val();
    var jueves_2 = $("#cbm_jueves_2_editar").val();
    var jueves_3 = $("#cbm_jueves_3_editar").val();
    var jueves_4 = $("#cbm_jueves_4_editar").val();
    var jueves_5 = $("#cbm_jueves_5_editar").val();
    var jueves_6 = $("#cbm_jueves_6_editar").val();

    // Para viernes del 1 al 6
    var viernes_1 = $("#cbm_viernes_1_editar").val();
    var viernes_2 = $("#cbm_viernes_2_editar").val();
    var viernes_3 = $("#cbm_viernes_3_editar").val();
    var viernes_4 = $("#cbm_viernes_4_editar").val();
    var viernes_5 = $("#cbm_viernes_5_editar").val();
    var viernes_6 = $("#cbm_viernes_6_editar").val();


    if (id_horario.length === 0 || lunes_1.length === 0 || lunes_2.length === 0 || lunes_3.length === 0 || lunes_4.length === 0 || lunes_5.length === 0 || lunes_6.length === 0 ||
        martes_1.length === 0 || martes_2.length === 0 || martes_3.length === 0 || martes_4.length === 0 || martes_5.length === 0 || martes_6.length === 0 ||
        miercoles_1.length === 0 || miercoles_2.length === 0 || miercoles_3.length === 0 || miercoles_4.length === 0 || miercoles_5.length === 0 || miercoles_6.length === 0 ||
        jueves_1.length === 0 || jueves_2.length === 0 || jueves_3.length === 0 || jueves_4.length === 0 || jueves_5.length === 0 || jueves_6.length === 0 ||
        viernes_1.length === 0 || viernes_2.length === 0 || viernes_3.length === 0 || viernes_4.length === 0 || viernes_5.length === 0 || viernes_6.length === 0 ||
        bloque_1.length === 0 || bloque_2.length === 0 || bloque_3.length === 0 || bloque_4.length === 0 || bloque_5.length === 0 || bloque_6.length === 0) {
        Swal.fire('Mensaje De Advertencia', 'Llene todos los campos vacíos', 'warning');
        return;
    }

    $.ajax({
        url: "../controlador/horarios/controlador_horario_editar.php",
        type: 'POST',
        data: {
            id_horario: id_horario,
            bloque_1: bloque_1,
            bloque_2: bloque_2,
            bloque_3: bloque_3,
            bloque_4: bloque_4,
            bloque_5: bloque_5,
            bloque_6: bloque_6,
            lunes_1: lunes_1,
            lunes_2: lunes_2,
            lunes_3: lunes_3,
            lunes_4: lunes_4,
            lunes_5: lunes_5,
            lunes_6: lunes_6,
            martes_1: martes_1,
            martes_2: martes_2,
            martes_3: martes_3,
            martes_4: martes_4,
            martes_5: martes_5,
            martes_6: martes_6,
            miercoles_1: miercoles_1,
            miercoles_2: miercoles_2,
            miercoles_3: miercoles_3,
            miercoles_4: miercoles_4,
            miercoles_5: miercoles_5,
            miercoles_6: miercoles_6,
            jueves_1: jueves_1,
            jueves_2: jueves_2,
            jueves_3: jueves_3,
            jueves_4: jueves_4,
            jueves_5: jueves_5,
            jueves_6: jueves_6,
            viernes_1: viernes_1,
            viernes_2: viernes_2,
            viernes_3: viernes_3,
            viernes_4: viernes_4,
            viernes_5: viernes_5,
            viernes_6: viernes_6
        }
    }).done(function (resp) {
        if (resp != "") {

            if (resp == 1) {
                Swal.fire("Mensaje De Confirmacion", "Datos correctamente, Horario Editado", "success")
                    .then((value) => {
                        $("#modal_editar_horarios").modal('hide');
                        tabla_horarios.ajax.reload();
                    });
                return;
            }
        }

        Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
    });


}


function Horario_Estudiante() {
    var id = $("#txtidusuario").val();
    $.ajax({
        "url": "../controlador/horarios/controlador_listar_horario_estudiante.php",
        type: 'POST',
        data: {
            id: id
        },
    }).done(function (resp) {
        var data = JSON.parse(resp);



        $("#txt_grado_estudiante").html(data.data[0].aula);
        $("#txt_bloque_1_estudiante").html(data.data[0].bloque_1);
        $("#txt_bloque_2_estudiante").html(data.data[0].bloque_2);
        $("#txt_bloque_3_estudiante").html(data.data[0].bloque_3);
        $("#txt_bloque_4_estudiante").html(data.data[0].bloque_4);
        $("#txt_bloque_5_estudiante").html(data.data[0].bloque_5);
        $("#txt_bloque_6_estudiante").html(data.data[0].bloque_6);

        $("#txt_lunes_1_estudiante").html(data.data[0].lunes_1);
        $("#txt_lunes_2_estudiante").html(data.data[0].lunes_2);
        $("#txt_lunes_3_estudiante").html(data.data[0].lunes_3);
        $("#txt_lunes_4_estudiante").html(data.data[0].lunes_4);
        $("#txt_lunes_5_estudiante").html(data.data[0].lunes_5);
        $("#txt_lunes_6_estudiante").html(data.data[0].lunes_6);

        $("#txt_martes_1_estudiante").html(data.data[0].martes_1);
        $("#txt_martes_2_estudiante").html(data.data[0].martes_2);
        $("#txt_martes_3_estudiante").html(data.data[0].martes_3);
        $("#txt_martes_4_estudiante").html(data.data[0].martes_4);
        $("#txt_martes_5_estudiante").html(data.data[0].martes_5);
        $("#txt_martes_6_estudiante").html(data.data[0].martes_6);

        $("#txt_miercoles_1_estudiante").html(data.data[0].miercoles_1);
        $("#txt_miercoles_2_estudiante").html(data.data[0].miercoles_2);
        $("#txt_miercoles_3_estudiante").html(data.data[0].miercoles_3);
        $("#txt_miercoles_4_estudiante").html(data.data[0].miercoles_4);
        $("#txt_miercoles_5_estudiante").html(data.data[0].miercoles_5);
        $("#txt_miercoles_6_estudiante").html(data.data[0].miercoles_6);

        $("#txt_jueves_1_estudiante").html(data.data[0].jueves_1);
        $("#txt_jueves_2_estudiante").html(data.data[0].jueves_2);
        $("#txt_jueves_3_estudiante").html(data.data[0].jueves_3);
        $("#txt_jueves_4_estudiante").html(data.data[0].jueves_4);
        $("#txt_jueves_5_estudiante").html(data.data[0].jueves_5);
        $("#txt_jueves_6_estudiante").html(data.data[0].jueves_6);

        $("#txt_viernes_1_estudiante").html(data.data[0].viernes_1);
        $("#txt_viernes_2_estudiante").html(data.data[0].viernes_2);
        $("#txt_viernes_3_estudiante").html(data.data[0].viernes_3);
        $("#txt_viernes_4_estudiante").html(data.data[0].viernes_4);
        $("#txt_viernes_5_estudiante").html(data.data[0].viernes_5);
        $("#txt_viernes_6_estudiante").html(data.data[0].viernes_6);


    });
}

//----------------horario docente-------------------

function Registrar_Horario_Docente() {
    var grado = $("#cbm_docentes").val();

    var bloque_1 = $("#bloque_1").val();
    var bloque_2 = $("#bloque_2").val();
    var bloque_3 = $("#bloque_3").val();
    var bloque_4 = $("#bloque_4").val();
    var bloque_5 = $("#bloque_5").val();
    var bloque_6 = $("#bloque_6").val();

    var lunes_1 = $("#cbm_lunes_1").val();
    var lunes_2 = $("#cbm_lunes_2").val();
    var lunes_3 = $("#cbm_lunes_3").val();
    var lunes_4 = $("#cbm_lunes_4").val();
    var lunes_5 = $("#cbm_lunes_5").val();
    var lunes_6 = $("#cbm_lunes_6").val();

    // Para martes del 1 al 6
    var martes_1 = $("#cbm_martes_1").val();
    var martes_2 = $("#cbm_martes_2").val();
    var martes_3 = $("#cbm_martes_3").val();
    var martes_4 = $("#cbm_martes_4").val();
    var martes_5 = $("#cbm_martes_5").val();
    var martes_6 = $("#cbm_martes_6").val();

    // Para miércoles del 1 al 6
    var miercoles_1 = $("#cbm_miercoles_1").val();
    var miercoles_2 = $("#cbm_miercoles_2").val();
    var miercoles_3 = $("#cbm_miercoles_3").val();
    var miercoles_4 = $("#cbm_miercoles_4").val();
    var miercoles_5 = $("#cbm_miercoles_5").val();
    var miercoles_6 = $("#cbm_miercoles_6").val();

    // Para jueves del 1 al 6
    var jueves_1 = $("#cbm_jueves_1").val();
    var jueves_2 = $("#cbm_jueves_2").val();
    var jueves_3 = $("#cbm_jueves_3").val();
    var jueves_4 = $("#cbm_jueves_4").val();
    var jueves_5 = $("#cbm_jueves_5").val();
    var jueves_6 = $("#cbm_jueves_6").val();

    // Para viernes del 1 al 6
    var viernes_1 = $("#cbm_viernes_1").val();
    var viernes_2 = $("#cbm_viernes_2").val();
    var viernes_3 = $("#cbm_viernes_3").val();
    var viernes_4 = $("#cbm_viernes_4").val();
    var viernes_5 = $("#cbm_viernes_5").val();
    var viernes_6 = $("#cbm_viernes_6").val();

    // Para lunes del 1 al 6
    var grado_lunes_1 = $("#cbm_grado_lunes_1").val();
    var grado_lunes_2 = $("#cbm_grado_lunes_2").val();
    var grado_lunes_3 = $("#cbm_grado_lunes_3").val();
    var grado_lunes_4 = $("#cbm_grado_lunes_4").val();
    var grado_lunes_5 = $("#cbm_grado_lunes_5").val();
    var grado_lunes_6 = $("#cbm_grado_lunes_6").val();

    // Para martes del 1 al 6
    var grado_martes_1 = $("#cbm_grado_martes_1").val();
    var grado_martes_2 = $("#cbm_grado_martes_2").val();
    var grado_martes_3 = $("#cbm_grado_martes_3").val();
    var grado_martes_4 = $("#cbm_grado_martes_4").val();
    var grado_martes_5 = $("#cbm_grado_martes_5").val();
    var grado_martes_6 = $("#cbm_grado_martes_6").val();

    // Para miércoles del 1 al 6
    var grado_miercoles_1 = $("#cbm_grado_miercoles_1").val();
    var grado_miercoles_2 = $("#cbm_grado_miercoles_2").val();
    var grado_miercoles_3 = $("#cbm_grado_miercoles_3").val();
    var grado_miercoles_4 = $("#cbm_grado_miercoles_4").val();
    var grado_miercoles_5 = $("#cbm_grado_miercoles_5").val();
    var grado_miercoles_6 = $("#cbm_grado_miercoles_6").val();

    // Para jueves del 1 al 6
    var grado_jueves_1 = $("#cbm_grado_jueves_1").val();
    var grado_jueves_2 = $("#cbm_grado_jueves_2").val();
    var grado_jueves_3 = $("#cbm_grado_jueves_3").val();
    var grado_jueves_4 = $("#cbm_grado_jueves_4").val();
    var grado_jueves_5 = $("#cbm_grado_jueves_5").val();
    var grado_jueves_6 = $("#cbm_grado_jueves_6").val();

    // Para viernes del 1 al 6
    var grado_viernes_1 = $("#cbm_grado_viernes_1").val();
    var grado_viernes_2 = $("#cbm_grado_viernes_2").val();
    var grado_viernes_3 = $("#cbm_grado_viernes_3").val();
    var grado_viernes_4 = $("#cbm_grado_viernes_4").val();
    var grado_viernes_5 = $("#cbm_grado_viernes_5").val();
    var grado_viernes_6 = $("#cbm_grado_viernes_6").val();



    if (grado_lunes_1.length === 0 || grado_lunes_2.length === 0 || grado_lunes_3.length === 0 || grado_lunes_4.length === 0 || grado_lunes_5.length === 0 || grado_lunes_6.length === 0 ||
        grado_martes_1.length === 0 || grado_martes_2.length === 0 || grado_martes_3.length === 0 || grado_martes_4.length === 0 || grado_martes_5.length === 0 || grado_martes_6.length === 0 ||
        grado_miercoles_1.length === 0 || grado_miercoles_2.length === 0 || grado_miercoles_3.length === 0 || grado_miercoles_4.length === 0 || grado_miercoles_5.length === 0 || grado_miercoles_6.length === 0 ||
        grado_jueves_1.length === 0 || grado_jueves_2.length === 0 || grado_jueves_3.length === 0 || grado_jueves_4.length === 0 || grado_jueves_5.length === 0 || grado_jueves_6.length === 0 ||
        grado_viernes_1.length === 0 || grado_viernes_2.length === 0 || grado_viernes_3.length === 0 || grado_viernes_4.length === 0 || grado_viernes_5.length === 0 || grado_viernes_6.length === 0 || grado.length === 0 || lunes_1.length === 0 || lunes_2.length === 0 || lunes_3.length === 0 || lunes_4.length === 0 || lunes_5.length === 0 || lunes_6.length === 0 ||
        martes_1.length === 0 || martes_2.length === 0 || martes_3.length === 0 || martes_4.length === 0 || martes_5.length === 0 || martes_6.length === 0 ||
        miercoles_1.length === 0 || miercoles_2.length === 0 || miercoles_3.length === 0 || miercoles_4.length === 0 || miercoles_5.length === 0 || miercoles_6.length === 0 ||
        jueves_1.length === 0 || jueves_2.length === 0 || jueves_3.length === 0 || jueves_4.length === 0 || jueves_5.length === 0 || jueves_6.length === 0 ||
        viernes_1.length === 0 || viernes_2.length === 0 || viernes_3.length === 0 || viernes_4.length === 0 || viernes_5.length === 0 || viernes_6.length === 0 ||
        bloque_1.length === 0 || bloque_2.length === 0 || bloque_3.length === 0 || bloque_4.length === 0 || bloque_5.length === 0 || bloque_6.length === 0) {
        Swal.fire('Mensaje De Advertencia', 'Llene todos los campos vacíos', 'warning');
        return;
    }

    $.ajax({
        url: "../controlador/horarios/controlador_horario_registro_docente.php",
        type: 'POST',
        data: {
            grado: grado,
            bloque_1: bloque_1,
            bloque_2: bloque_2,
            bloque_3: bloque_3,
            bloque_4: bloque_4,
            bloque_5: bloque_5,
            bloque_6: bloque_6,
            lunes_1: lunes_1,
            lunes_2: lunes_2,
            lunes_3: lunes_3,
            lunes_4: lunes_4,
            lunes_5: lunes_5,
            lunes_6: lunes_6,
            martes_1: martes_1,
            martes_2: martes_2,
            martes_3: martes_3,
            martes_4: martes_4,
            martes_5: martes_5,
            martes_6: martes_6,
            miercoles_1: miercoles_1,
            miercoles_2: miercoles_2,
            miercoles_3: miercoles_3,
            miercoles_4: miercoles_4,
            miercoles_5: miercoles_5,
            miercoles_6: miercoles_6,
            jueves_1: jueves_1,
            jueves_2: jueves_2,
            jueves_3: jueves_3,
            jueves_4: jueves_4,
            jueves_5: jueves_5,
            jueves_6: jueves_6,
            viernes_1: viernes_1,
            viernes_2: viernes_2,
            viernes_3: viernes_3,
            viernes_4: viernes_4,
            viernes_5: viernes_5,
            viernes_6: viernes_6,
            grado_lunes_1: grado_lunes_1,
            grado_lunes_2: grado_lunes_2,
            grado_lunes_3: grado_lunes_3,
            grado_lunes_4: grado_lunes_4,
            grado_lunes_5: grado_lunes_5,
            grado_lunes_6: grado_lunes_6,
            grado_martes_1: grado_martes_1,
            grado_martes_2: grado_martes_2,
            grado_martes_3: grado_martes_3,
            grado_martes_4: grado_martes_4,
            grado_martes_5: grado_martes_5,
            grado_martes_6: grado_martes_6,
            grado_miercoles_1: grado_miercoles_1,
            grado_miercoles_2: grado_miercoles_2,
            grado_miercoles_3: grado_miercoles_3,
            grado_miercoles_4: grado_miercoles_4,
            grado_miercoles_5: grado_miercoles_5,
            grado_miercoles_6: grado_miercoles_6,
            grado_jueves_1: grado_jueves_1,
            grado_jueves_2: grado_jueves_2,
            grado_jueves_3: grado_jueves_3,
            grado_jueves_4: grado_jueves_4,
            grado_jueves_5: grado_jueves_5,
            grado_jueves_6: grado_jueves_6,
            grado_viernes_1: grado_viernes_1,
            grado_viernes_2: grado_viernes_2,
            grado_viernes_3: grado_viernes_3,
            grado_viernes_4: grado_viernes_4,
            grado_viernes_5: grado_viernes_5,
            grado_viernes_6: grado_viernes_6
        }
    }).done(function (resp) {
        if (resp != "") {
            if (resp == -1) {
                Swal.fire("Mensaje De Advertencia", "El docente ya existe en la base de datos. Por favor, seleccione otro docente.", "warning");
                return;
            }

            if (resp == 1) {
                Swal.fire("Mensaje De Confirmacion", "Datos correctamente, Nuevo Horario De Docente Registrado", "success")
                    .then((value) => {
                        $("#modal_registro_horarios_docente").modal('hide');
                        tabla_horarios_docente.ajax.reload();
                    });
                return;
            }
        }

        Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
    });


}



function Editar_Horario_Docente() {
    var id_horario_docente = $("#txt_id_horario_docente").val();

    var bloque_1 = $("#bloque_1_editar").val();
    var bloque_2 = $("#bloque_2_editar").val();
    var bloque_3 = $("#bloque_3_editar").val();
    var bloque_4 = $("#bloque_4_editar").val();
    var bloque_5 = $("#bloque_5_editar").val();
    var bloque_6 = $("#bloque_6_editar").val();

    var lunes_1 = $("#cbm_lunes_1_editar").val();
    var lunes_2 = $("#cbm_lunes_2_editar").val();
    var lunes_3 = $("#cbm_lunes_3_editar").val();
    var lunes_4 = $("#cbm_lunes_4_editar").val();
    var lunes_5 = $("#cbm_lunes_5_editar").val();
    var lunes_6 = $("#cbm_lunes_6_editar").val();

    // Para martes del 1 al 6
    var martes_1 = $("#cbm_martes_1_editar").val();
    var martes_2 = $("#cbm_martes_2_editar").val();
    var martes_3 = $("#cbm_martes_3_editar").val();
    var martes_4 = $("#cbm_martes_4_editar").val();
    var martes_5 = $("#cbm_martes_5_editar").val();
    var martes_6 = $("#cbm_martes_6_editar").val();

    // Para miércoles del 1 al 6
    var miercoles_1 = $("#cbm_miercoles_1_editar").val();
    var miercoles_2 = $("#cbm_miercoles_2_editar").val();
    var miercoles_3 = $("#cbm_miercoles_3_editar").val();
    var miercoles_4 = $("#cbm_miercoles_4_editar").val();
    var miercoles_5 = $("#cbm_miercoles_5_editar").val();
    var miercoles_6 = $("#cbm_miercoles_6_editar").val();

    // Para jueves del 1 al 6
    var jueves_1 = $("#cbm_jueves_1_editar").val();
    var jueves_2 = $("#cbm_jueves_2_editar").val();
    var jueves_3 = $("#cbm_jueves_3_editar").val();
    var jueves_4 = $("#cbm_jueves_4_editar").val();
    var jueves_5 = $("#cbm_jueves_5_editar").val();
    var jueves_6 = $("#cbm_jueves_6_editar").val();

    // Para viernes del 1 al 6
    var viernes_1 = $("#cbm_viernes_1_editar").val();
    var viernes_2 = $("#cbm_viernes_2_editar").val();
    var viernes_3 = $("#cbm_viernes_3_editar").val();
    var viernes_4 = $("#cbm_viernes_4_editar").val();
    var viernes_5 = $("#cbm_viernes_5_editar").val();
    var viernes_6 = $("#cbm_viernes_6_editar").val();

    // Para lunes del 1 al 6
    var grado_lunes_1 = $("#cbm_grado_editar_lunes_1").val();
    var grado_lunes_2 = $("#cbm_grado_editar_lunes_2").val();
    var grado_lunes_3 = $("#cbm_grado_editar_lunes_3").val();
    var grado_lunes_4 = $("#cbm_grado_editar_lunes_4").val();
    var grado_lunes_5 = $("#cbm_grado_editar_lunes_5").val();
    var grado_lunes_6 = $("#cbm_grado_editar_lunes_6").val();

    // Para martes del 1 al 6
    var grado_martes_1 = $("#cbm_grado_editar_martes_1").val();
    var grado_martes_2 = $("#cbm_grado_editar_martes_2").val();
    var grado_martes_3 = $("#cbm_grado_editar_martes_3").val();
    var grado_martes_4 = $("#cbm_grado_editar_martes_4").val();
    var grado_martes_5 = $("#cbm_grado_editar_martes_5").val();
    var grado_martes_6 = $("#cbm_grado_editar_martes_6").val();

    // Para miércoles del 1 al 6
    var grado_miercoles_1 = $("#cbm_grado_editar_miercoles_1").val();
    var grado_miercoles_2 = $("#cbm_grado_editar_miercoles_2").val();
    var grado_miercoles_3 = $("#cbm_grado_editar_miercoles_3").val();
    var grado_miercoles_4 = $("#cbm_grado_editar_miercoles_4").val();
    var grado_miercoles_5 = $("#cbm_grado_editar_miercoles_5").val();
    var grado_miercoles_6 = $("#cbm_grado_editar_miercoles_6").val();

    // Para jueves del 1 al 6
    var grado_jueves_1 = $("#cbm_grado_editar_jueves_1").val();
    var grado_jueves_2 = $("#cbm_grado_editar_jueves_2").val();
    var grado_jueves_3 = $("#cbm_grado_editar_jueves_3").val();
    var grado_jueves_4 = $("#cbm_grado_editar_jueves_4").val();
    var grado_jueves_5 = $("#cbm_grado_editar_jueves_5").val();
    var grado_jueves_6 = $("#cbm_grado_editar_jueves_6").val();

    // Para viernes del 1 al 6
    var grado_viernes_1 = $("#cbm_grado_editar_viernes_1").val();
    var grado_viernes_2 = $("#cbm_grado_editar_viernes_2").val();
    var grado_viernes_3 = $("#cbm_grado_editar_viernes_3").val();
    var grado_viernes_4 = $("#cbm_grado_editar_viernes_4").val();
    var grado_viernes_5 = $("#cbm_grado_editar_viernes_5").val();
    var grado_viernes_6 = $("#cbm_grado_editar_viernes_6").val();



    function isEmpty(value) {
        return value === null || value === undefined || value.length === 0;
    }

    if (
        isEmpty(grado_lunes_1) || isEmpty(grado_lunes_2) || isEmpty(grado_lunes_3) || isEmpty(grado_lunes_4) || isEmpty(grado_lunes_5) || isEmpty(grado_lunes_6) ||
        isEmpty(grado_martes_1) || isEmpty(grado_martes_2) || isEmpty(grado_martes_3) || isEmpty(grado_martes_4) || isEmpty(grado_martes_5) || isEmpty(grado_martes_6) ||
        isEmpty(grado_miercoles_1) || isEmpty(grado_miercoles_2) || isEmpty(grado_miercoles_3) || isEmpty(grado_miercoles_4) || isEmpty(grado_miercoles_5) || isEmpty(grado_miercoles_6) ||
        isEmpty(grado_jueves_1) || isEmpty(grado_jueves_2) || isEmpty(grado_jueves_3) || isEmpty(grado_jueves_4) || isEmpty(grado_jueves_5) || isEmpty(grado_jueves_6) ||
        isEmpty(grado_viernes_1) || isEmpty(grado_viernes_2) || isEmpty(grado_viernes_3) || isEmpty(grado_viernes_4) || isEmpty(grado_viernes_5) || isEmpty(grado_viernes_6) ||
        isEmpty(lunes_1) || isEmpty(lunes_2) || isEmpty(lunes_3) || isEmpty(lunes_4) || isEmpty(lunes_5) || isEmpty(lunes_6) ||
        isEmpty(martes_1) || isEmpty(martes_2) || isEmpty(martes_3) || isEmpty(martes_4) || isEmpty(martes_5) || isEmpty(martes_6) ||
        isEmpty(miercoles_1) || isEmpty(miercoles_2) || isEmpty(miercoles_3) || isEmpty(miercoles_4) || isEmpty(miercoles_5) || isEmpty(miercoles_6) ||
        isEmpty(jueves_1) || isEmpty(jueves_2) || isEmpty(jueves_3) || isEmpty(jueves_4) || isEmpty(jueves_5) || isEmpty(jueves_6) ||
        isEmpty(viernes_1) || isEmpty(viernes_2) || isEmpty(viernes_3) || isEmpty(viernes_4) || isEmpty(viernes_5) || isEmpty(viernes_6) ||
        isEmpty(bloque_1) || isEmpty(bloque_2) || isEmpty(bloque_3) || isEmpty(bloque_4) || isEmpty(bloque_5) || isEmpty(bloque_6)
    ) {
        Swal.fire('Mensaje De Advertencia', 'Llene todos los campos vacíos', 'warning');
        return;
    }



    $.ajax({
        url: "../controlador/horarios/controlador_horario_editar_docente.php",
        type: 'POST',
        data: {
            id_horario_docente: id_horario_docente,
            bloque_1: bloque_1,
            bloque_2: bloque_2,
            bloque_3: bloque_3,
            bloque_4: bloque_4,
            bloque_5: bloque_5,
            bloque_6: bloque_6,
            lunes_1: lunes_1,
            lunes_2: lunes_2,
            lunes_3: lunes_3,
            lunes_4: lunes_4,
            lunes_5: lunes_5,
            lunes_6: lunes_6,
            martes_1: martes_1,
            martes_2: martes_2,
            martes_3: martes_3,
            martes_4: martes_4,
            martes_5: martes_5,
            martes_6: martes_6,
            miercoles_1: miercoles_1,
            miercoles_2: miercoles_2,
            miercoles_3: miercoles_3,
            miercoles_4: miercoles_4,
            miercoles_5: miercoles_5,
            miercoles_6: miercoles_6,
            jueves_1: jueves_1,
            jueves_2: jueves_2,
            jueves_3: jueves_3,
            jueves_4: jueves_4,
            jueves_5: jueves_5,
            jueves_6: jueves_6,
            viernes_1: viernes_1,
            viernes_2: viernes_2,
            viernes_3: viernes_3,
            viernes_4: viernes_4,
            viernes_5: viernes_5,
            viernes_6: viernes_6,
            grado_lunes_1: grado_lunes_1,
            grado_lunes_2: grado_lunes_2,
            grado_lunes_3: grado_lunes_3,
            grado_lunes_4: grado_lunes_4,
            grado_lunes_5: grado_lunes_5,
            grado_lunes_6: grado_lunes_6,
            grado_martes_1: grado_martes_1,
            grado_martes_2: grado_martes_2,
            grado_martes_3: grado_martes_3,
            grado_martes_4: grado_martes_4,
            grado_martes_5: grado_martes_5,
            grado_martes_6: grado_martes_6,
            grado_miercoles_1: grado_miercoles_1,
            grado_miercoles_2: grado_miercoles_2,
            grado_miercoles_3: grado_miercoles_3,
            grado_miercoles_4: grado_miercoles_4,
            grado_miercoles_5: grado_miercoles_5,
            grado_miercoles_6: grado_miercoles_6,
            grado_jueves_1: grado_jueves_1,
            grado_jueves_2: grado_jueves_2,
            grado_jueves_3: grado_jueves_3,
            grado_jueves_4: grado_jueves_4,
            grado_jueves_5: grado_jueves_5,
            grado_jueves_6: grado_jueves_6,
            grado_viernes_1: grado_viernes_1,
            grado_viernes_2: grado_viernes_2,
            grado_viernes_3: grado_viernes_3,
            grado_viernes_4: grado_viernes_4,
            grado_viernes_5: grado_viernes_5,
            grado_viernes_6: grado_viernes_6
        }
    }).done(function (resp) {
        if (resp != "") {

            if (resp == 1) {
                Swal.fire("Mensaje De Confirmacion", "Datos correctamente, Horario De Docente Editado", "success")
                    .then((value) => {
                        $("#modal_editar_horarios_docente").modal('hide');
                        tabla_horarios_docente.ajax.reload();
                    });
                return;
            }
        }

        Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
    });


}



function Horario_Docente() {
    var id = $("#txtidusuario").val();
    $.ajax({
        "url": "../controlador/horarios/controlador_listar_horario_docente.php",
        type: 'POST',
        data: {
            id: id
        },
    }).done(function (resp) {
        var data = JSON.parse(resp);

        // Función para aplicar estilos a las celdas según su contenido
        function aplicarEstilos(celda) {
            if (celda.text() === "SIN ASIGNACIÓN") {
                celda.css("background-color", "#FFCCCC"); // Rojo claro
            } else {
                celda.css("background-color", "#CCFFCC"); // Verde claro
            }
        }

        $("#txt_docente").html(data.data[0].docente);
        $("#txt_bloque_1_docente").html(data.data[0].bloque_1);
        $("#txt_bloque_2_docente").html(data.data[0].bloque_2);
        $("#txt_bloque_3_docente").html(data.data[0].bloque_3);
        $("#txt_bloque_4_docente").html(data.data[0].bloque_4);
        $("#txt_bloque_5_docente").html(data.data[0].bloque_5);
        $("#txt_bloque_6_docente").html(data.data[0].bloque_6);

        for (var dia = 0; dia < 5; dia++) {
            for (var bloque = 1; bloque <= 6; bloque++) {
                var campoID = "#txt_" + ["lunes", "martes", "miercoles", "jueves", "viernes"][dia] + "_" + bloque + "_docente";
                var celda = $(campoID);
                var asignacion = data.data[0][["lunes", "martes", "miercoles", "jueves", "viernes"][dia] + "_" + bloque];

                if (asignacion === "SIN ASIGNACIÓN") {
                    celda.text(asignacion);
                } else {
                    celda.html(asignacion + "<br>Grado: " + data.data[0]["grado_" + ["lunes", "martes", "miercoles", "jueves", "viernes"][dia] + "_" + bloque]);
                }

                aplicarEstilos(celda);
            }
        }
    });
}

function mostrarHorario(imagenURL, grado) {
    document.getElementById('imagen_mostrada').src = imagenURL;
    document.getElementById('grado_modal_title').innerHTML = grado;
    $('#modal_archivo_imagen_ver').modal('show');
}