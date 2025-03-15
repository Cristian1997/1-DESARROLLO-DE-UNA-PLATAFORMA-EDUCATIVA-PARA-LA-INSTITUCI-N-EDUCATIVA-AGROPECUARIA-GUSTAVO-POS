//-------------TABLA AISTENCIAS-----------------------

var tabla_asistencias;
function listar_asistencias(id_grado, id_asignatura) {
  var id_grupo = $("#cbm_grupo").val();
  var id_usuario_doc = $("#txtidusuario").val();
  if (id_grado == null || id_asignatura == null || id_grupo == null) {
    id_grado = 1;
    id_asignatura = 1;
    id_grupo = 1;
  }
  tabla_asistencias = $("#tabla_asistencias").DataTable({
    ordering: false,
    bLengthChange: true,
    searching: { regex: false },
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    pageLength: 10,
    destroy: true,
    async: false,
    processing: true,
    ajax: {
      url: "../controlador/asistencias/controlador_asistencias_listar.php",
      type: "POST",
      data: {
        id_usuario_doc: id_usuario_doc,
        id_asignatura: id_asignatura,
        id_grado: id_grado,
        id_grupo: id_grupo,
      },
    },

    columns: [
      { defaultContent: "" },
      { data: "Estudiante" },

      {
        data: "asistencia",
        render: function (data, type, row) {
          if (data == "ASISTIÓ") {
            return "<span class='btn btn-success'>" + data + "</span>";
          } else {
            return "<span class='btn btn-danger'>" + data + "</span>";
          }
        },
      },

      { data: "dia" },
      { data: "fecha" },

      {
        data: null,
        defaultContent: "<input type='checkbox' class='asistencia-checkbox' />",
      },
    ],

    language: idioma_espanol,
    select: true,
  });
  document.getElementById("tabla_asistencias_filter").style.display = "none";
  $("input.global_filter").on("keyup click", function () {
    filterGlobal();
  });
  $("input.column_filter").on("keyup click", function () {
    filterColumn($(this).parents("tr").attr("data-column"));
  });
  tabla_asistencias.on("draw.dt", function () {
    var PageInfo = $("#tabla_asistencias").DataTable().page.info();
    tabla_asistencias
      .column(0, {
        page: "current",
      })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + PageInfo.start;
      });
  });
}

// funcion editar

$("#tabla_asistencias").on("click", ".editar", function () {
  var data = tabla_asistencias.row($(this).parents("tr")).data();
  if (tabla_asistencias.row(this).child.isShown()) {
    var data = tabla_asistencias.row(this).data();
  }

  $("#modal_editar").modal({ backdrop: "static", keyboard: false });
  $("#modal_editar").modal("show");
  $("#id_asistencias").val(data.id_asistencia).hide();
  $("#id_docente").val(data.id_docente).hide();
  $("#id_grupo").val(data.id_grupo).hide();
  $("#cmb_asistencia").val(data.asistencia).trigger("change");
  $("#cmb_dia").val(data.dia).trigger("change");
});

// evento ready del documento

$(document).ready(function () {
  $("#tabla_asistencias").on("change", ".asistencia-checkbox", function () {
    var rowData = tabla_asistencias.row($(this).closest("tr")).data();
    var id_asistencia = rowData.id_asistencia;
    var isChecked = $(this).is(":checked");

    var asistenciaColumn = $(this).closest("tr").find("td:eq(2)");

    if (isChecked) {
      asistenciaColumn.html("<span class='btn btn-success'>ASISTIÓ</span>");
    } else {
      asistenciaColumn.html("<span class='btn btn-danger'>NO ASISTIÓ</span>");
    }
  });
});

// listar combos

function listar_combo_asignatura() {
  var id = $("#txtidusuario").val();
  $.ajax({
    url: "../controlador/calificaciones/controlador_combo_asignatura_listar.php",
    type: "POST",
    data: {
      id: id,
    },
  }).done(function (resp) {
    let data = JSON.parse(resp);
    var cadena = "";
    if (data.length > 0) {
      for (var i = 0; i < data.length; i++) {
        cadena +=
          "<option value='" + data[i][0] + "'>" + data[i][1] + " </option>";
      }
      $("#cbm_asignatura").html(cadena);
    } else {
      cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
      $("#cbm_asignatura").html(cadena);
    }
  });
}

function listar_combo_asignatura(id_asignatura) {
  var id = $("#txtidusuario").val();
  if (id_asignatura == null) {
    id_asignatura = 1;
  }
  $.ajax({
    url: "../controlador/calificaciones/controlador_combo_asignatura_listar.php",
    type: "POST",
    data: {
      id: id,
      id_asignatura: id_asignatura,
    },
  }).done(function (resp) {
    let data = JSON.parse(resp);
    var cadena = "";
    if (data.length > 0) {
      for (var i = 0; i < data.length; i++) {
        cadena +=
          "<option value='" + data[i][0] + "'>" + data[i][1] + " </option>";
      }
      $("#cbm_asignatura").html(cadena);
    } else {
      cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
      $("#cbm_asignatura").html(cadena);
    }
  });
}

function listar_combo_grupo() {
  var id = $("#txtidusuario").val();
  $.ajax({
    url: "../controlador/talleres/controlador_combo_grupo_listar.php",
    type: "POST",
    data: {
      id: id,
    },
  }).done(function (resp) {
    let data = JSON.parse(resp);
    var cadena = "";
    if (data.length > 0) {
      for (var i = 0; i < data.length; i++) {
        cadena +=
          "<option value='" +
          data[i][0] +
          "'>" +
          "Asignatura:  " +
          data[i][1] +
          "  --  " +
          "Grado: " +
          data[i][2] +
          " </option>";
      }
      $("#cbm_grupo").html(cadena);
      id = $("#cbm_grupo").val();
      listar_combo_grado(id);
      listar_combo_asignatura(id);

      if (id.length != "") {
        $("#cbm_grupo_listar").val(id).trigger("change");
      }
    } else {
      cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
      $("#cbm_grupo").html(cadena);
    }
  });
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
      id_grupo: id_grupo,
    },
  }).done(function (resp) {
    let data = JSON.parse(resp);
    var cadena = "";
    if (data.length > 0) {
      for (var i = 0; i < data.length; i++) {
        cadena +=
          "<option value='" + data[i][0] + "'>" + data[i][1] + " </option>";
      }
      $("#cbm_grado").html(cadena);
    } else {
      cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
      $("#cbm_grado").html(cadena);
    }
  });
}

// registros y editar

function guardar_asistencias() {
  var id_asistencias = "";
  var id_docente = "";
  var id_grupo = "";

  tabla_asistencias.rows().every(function () {
    var rowData = this.data();
    if (rowData) {
      id_asistencias += rowData.id_asistencia + ",";
      id_docente = rowData.id_docente;
      id_grupo = rowData.id_grupo;
    }
  });

  id_asistencias = id_asistencias.replace(/,\s*$/, "");

  tabla_asistencias.rows().every(function () {
    var rowData = this.data();
    var id_asistencia = rowData.id_asistencia;
    var asistencia = this.nodes()
      .to$()
      .find(".asistencia-checkbox")
      .is(":checked")
      ? "ASISTIÓ"
      : "NO ASISTIÓ";
    var dia = rowData.dia;

    $.ajax({
      url: "../controlador/asistencias/controlador_guardar_asistencias.php",
      type: "POST",
      dataType: "json",
      data: {
        id_asistencia: id_asistencia,
        id_docente: id_docente,
        id_grupo: id_grupo,
        asistencia: asistencia,
        dia: dia,
      },
      success: function (resp) {
        if (resp == 1) {
          Swal.fire(
            "Mensaje De Confirmacion",
            "Asistencia guardada correctamente",
            "success"
          ).then((value) => {});
        } else {
          Swal.fire(
            "Mensaje De Error",
            "Lo sentimos, no se pudo guardar la asistencia para ID: " +
              id_asistencia,
            "error"
          );
        }
      },
      error: function (xhr, status, error) {
        console.error("Error en la petición AJAX: " + error);
        Swal.fire(
          "Mensaje De Error",
          "Error al procesar la solicitud",
          "error"
        );
      },
    });
  });
}

function Editar_asistencias() {
  var dia = $("#cmb_dia").val();
  var asistencia = $("#cmb_asistencia").val();
  var id_asistencias = $("#id_asistencias").val();
  var id_docente = $("#id_docente").val();
  var id_grupo = $("#id_grupo").val();
  if (dia.length == 0 || asistencia.length == 0) {
    return Swal.fire(
      "Mensaje De Advertencia",
      "llebes los Datos Vacios",
      "warning"
    );
  }
  if (id_asistencias == null) {
    return Swal.fire("Mensaje De Error", "Datos Vacios", "error");
  }
  if (id_docente == null) {
    return Swal.fire("Mensaje De Error", "Datos Vacios", "error");
  }

  $.ajax({
    url: "../controlador/asistencias/controlador_asistencias_modificar.php",
    type: "POST",
    data: {
      id_asistencias: id_asistencias,
      id_docente: id_docente,
      dia: dia,
      asistencia: asistencia,
      id_grupo: id_grupo,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        Swal.fire(
          "Mensaje De Confirmacion",
          "asistencias Actualizada correctamente",
          "success"
        ).then((value) => {
          $("#modal_editar").modal("hide");
          tabla_asistencias.ajax.reload();
        });
      }
    } else {
      Swal.fire(
        "Mensaje De Error",
        "Lo sentimos, no se realizar la actualización",
        "error"
      );
    }
  });
}

function datos() {
  var id_grado = $("#cbm_grado").val();
  var id_asignatura = $("#cbm_asignatura").val();

  listar_asistencias(id_grado, id_asignatura);
}

// listar detalles de asistencias

function actualizar_asistencias() {
  var diasSemana = [
    "DOMINGO",
    "LUNES",
    "MARTES",
    "MIÉRCOLES",
    "JUEVES",
    "VIERNES",
    "SÁBADO",
  ];
  var fecha = new Date();
  var numeroDiaSemana = fecha.getDay();
  var dia = diasSemana[numeroDiaSemana];

  var asistencia = "NO ASISTIÓ";

  $.ajax({
    url: "../controlador/asistencias/controlador_modificar_asistencias.php",
    type: "POST",
    data: {
      dia: dia,
      asistencia: asistencia,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        tabla_asistencias.ajax.reload();
      }
    } else {
      Swal.fire(
        "Mensaje De Error",
        "Lo sentimos, no se realizó la actualización",
        "error"
      );
    }
  });
}

function limpiar_asistencias() {
  actualizar_asistencias();
}
