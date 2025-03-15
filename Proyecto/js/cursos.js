var tabla_cursos;
function listar_cursos() {
  tabla_cursos = $("#tabla_cursos").DataTable({
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
      url: "../controlador/cursos/controlador_cursos_listar.php",
      type: "POST",
    },
    order: [[1, "asc"]],
    columns: [
      { defaultContent: "" },
      { data: "nombre" },

      {
        data: "status",
        render: function (data, type, row) {
          if (data == "ACTIVO") {
            return "<span class='label label-success'>" + data + "</span>";
          } else {
            return "<span class='label label-danger'>" + data + "</span>";
          }
        },
      },

      {
        defaultContent:
          "<button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fa fa-edit'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='desactivar btn btn-danger'><i class='fa fa-trash'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='activar btn btn-success'><i class='fa fa-check'></i></button>",
      },
    ],

    language: idioma_espanol,
    select: true,
  });
  document.getElementById("tabla_cursos_filter").style.display = "none";
  $("input.global_filter").on("keyup click", function () {
    filterGlobal();
  });
  $("input.column_filter").on("keyup click", function () {
    filterColumn($(this).parents("tr").attr("data-column"));
  });
  function filterGlobal() {
    $("#tabla_cursos").DataTable().search($("#global_filter").val()).draw();
  }
  tabla_cursos.on("draw.dt", function () {
    var PageInfo = $("#tabla_cursos").DataTable().page.info();
    tabla_cursos
      .column(0, {
        page: "current",
      })
      .nodes()
      .each(function (cell, i) {
        cell.innerHTML = i + 1 + PageInfo.start;
      });
  });
}
$("#tabla_cursos").on("click", ".activar", function () {
  var data = tabla_cursos.row($(this).parents("tr")).data();
  if (tabla_cursos.row(this).child.isShown()) {
    var data = tabla_cursos.row(this).data();
  }
  Swal.fire({
    title: "¿Esta seguro de activar la Asignatura?",
    text: "Una vez hecho esto la Asignatura estara disponible",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
  }).then((result) => {
    if (result.value) {
      Modificar_Estatus(data.ID, "ACTIVO");
    }
  });
});

$("#tabla_cursos").on("click", ".desactivar", function () {
  var data = tabla_cursos.row($(this).parents("tr")).data();
  if (tabla_cursos.row(this).child.isShown()) {
    var data = tabla_cursos.row(this).data();
  }
  Swal.fire({
    title: "¿Esta seguro de desactivar la Asignatura?",
    text: "Una vez hecho esto la Asignatura no estara dispponible",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
  }).then((result) => {
    if (result.value) {
      Modificar_Estatus(data.ID, "INACTIVO");
    }
  });
});
function Modificar_Estatus(ID, estatus) {
  var mensaje = "";
  if (estatus == "INACTIVO") {
    mensaje = "desactivo";
  } else {
    mensaje = "activo";
  }
  $.ajax({
    url: "../controlador/cursos/controlador_modificar_estatus_asignatura.php",
    type: "POST",
    data: {
      ID: ID,
      estatus: estatus,
    },
  }).done(function (resp) {
    if (resp > 0) {
      Swal.fire(
        "Mensaje De Confirmacion",
        "La asignatura se " + mensaje + " con exito",
        "success"
      ).then((value) => {
        tabla_cursos.ajax.reload();
      });
    }
  });
}
$("#tabla_cursos").on("click", ".editar", function () {
  var data = tabla_cursos.row($(this).parents("tr")).data();
  if (tabla_cursos.row(this).child.isShown()) {
    var data = tabla_cursos.row(this).data();
  }

  $("#modal_editar").modal({ backdrop: "static", keyboard: false });
  $("#modal_editar").modal("show");
  $("#id_asignatura").val(data.ID);
  $("#txt_nombres_editar").val(data.nombre);
});

function AbrirModalRegistro() {
  $("#modal_registro").modal({ backdrop: "static", keyboard: false });
  $("#modal_registro").modal("show");
}

function Registrar_asignatura() {
  var nombre = $("#txt_nombres").val();

  if (nombre.length == 0) {
    return Swal.fire(
      "Mensaje De Advertencia",
      "Llene los campos vacios",
      "warning"
    );
  }

  $.ajax({
    url: "../controlador/cursos/controlador_asignatura_registro.php",
    type: "POST",
    data: {
      nombre: nombre,
    },
  }).done(function (resp) {
    if (resp > 0) {
      if (resp == 1) {
        Swal.fire(
          "Mensaje De Confirmacion",
          "Datos correctamente, Nueva Asignatura Registrada",
          "success"
        ).then((value) => {
          LimpiarRegistro();
          $("#modal_registro").modal("hide");
          tabla_cursos.ajax.reload();
        });
      } else {
        return Swal.fire(
          "Mensaje De Advertencia",
          "Lo sentimos, la Asignatura ya existe en la base de datos",
          "warning"
        );
      }
    } else {
      Swal.fire(
        "Mensaje De Error",
        "Lo sentimos, no se pudo completar el registro",
        "error"
      );
    }
  });
}
function LimpiarRegistro() {
  $("#txt_nombres").val("");
  $("#txt_apellidos").val("");
  $("#txt_documento").val("");
  $("#txt_telefono").val("");
  $("#txt_fecha").val("");
}
function Editar_Asignaturas() {
  var idasignatura = $("#id_asignatura").val();

  var nombre = $("#txt_nombres_editar").val();

  if (idasignatura == null) {
    return Swal.fire("Mensaje De Error", "Datos Vacios", "error");
  }

  if (nombre.length == 0) {
    return Swal.fire(
      "Mensaje De Advertencia",
      "Llene los campos vacios",
      "warning"
    );
  }
  $.ajax({
    url: "../controlador/cursos/controlador_asignatura_modificar.php",
    type: "POST",
    data: {
      idasignatura: idasignatura,
      nombre: nombre,
    },
  }).done(function (resp) {
    if (resp == 1) {
      if (resp == 1) {
        Swal.fire(
          "Mensaje De Confirmacion",
          "Datos Actualizados correctamente",
          "success"
        ).then((value) => {
          LimpiarRegistro();
          $("#modal_editar").modal("hide");
          tabla_cursos.ajax.reload();
        });
      } else {
        return Swal.fire(
          "Mensaje De Advertencia",
          "El docente ya existe en nuestra base de datos",
          "warning"
        );
      }
    } else {
      Swal.fire(
        "Mensaje De Error",
        "Lo sentimos, no se pudo completar el registro",
        "error"
      );
    }
  });
}
function LimpiarRegistro() {
  $("#txt_nombres").val("");
  $("#txt_apellidos").val("");
  $("#txt_documento").val("");
  $("#txt_telefono").val("");
  $("#txt_fecha").val("");
}
