 var tabla_docente;
 function listar_docente() {

    tabla_docente = $("#tabla_docente").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/docente/controlador_docente_listar.php",
            type: 'POST'
        },
        "order": [
            [1, 'asc']
            ],
        "columns": [
            { "defaultContent": "" },
            { "data": "nm_documento" },
            { "data": "docente" },
            { "data": "fecha_nacimiento" },
            { "data": "telefono" },
            { "data": "usu_email" },
            {"data": "usu_sexo",
            render: function (data, type, row) {
                if (data == 'M') {
                    return "MASCULINO";
                } else {
                    return "FEMENINO";
                }
            }
        },

        { "defaultContent": "<button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fa fa-edit'></i></button>" }
        ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_docente_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });
    function filterGlobal() {
        $('#tabla_docente').DataTable().search(
            $('#global_filter').val()
            ).draw();
    }
    tabla_docente.on('draw.dt', function() {
        var PageInfo = $('#tabla_docente').DataTable().page.info();
        tabla_docente.column(0, {
            page: 'current'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

}

$('#tabla_docente').on('click', '.editar', function () {
    var  data =  tabla_docente.row($(this).parents('tr')).data();
    if ( tabla_docente.row(this).child.isShown()) {
        var data =  tabla_docente.row(this).data();
    }

    $("#modal_editar").modal({ backdrop: 'static', keyboard: false })
    $("#modal_editar").modal('show');
    $("#id_docente").val(data.ID);
    $("#txt_nombres_editar").val(data.nombre_docente);
    $("#txt_apellidos_editar").val(data.apellidos_docente);
    $("#txt_documento_editar_actual").val(data.nm_documento);
    $("#txt_documento_editar_nuevo").val(data.nm_documento);
    $("#txt_telefono_editar").val(data.telefono);
    $("#txt_fecha_editar").val(data.fecha_nacimiento);
    $("#cbm_sexo_editar").val(data.usu_sexo).trigger("change");
    $("#txt_email_editar").val(data.usu_email);
    $("#txt_usu_editar").val(data.usu_nombre);
    $("#status").html(data.usu_estatus);
    $("#id_usuario").val(data.id_usu); 
    const color = document.querySelector(".bt");
    if (data.usu_estatus == "ACTIVO") {
        color.style.backgroundColor = "green";
    } else{
       color.style.backgroundColor = "red";
   }
})

function AbrirModalRegistro() {
    $("#modal_registro").modal({ backdrop: 'static', keyboard: false })
    $("#modal_registro").modal('show');
}

function listar_combo_materia() {
    $.ajax({
        "url": "../controlador/docente/controlador_combo_materia.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + "</option>";
            }
            $("#cbm_materia").html(cadena);
            $("#cbm_materia_editar").html(cadena);
        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_materia").html(cadena);
            $("#cbm_materia_editar").html(cadena);
        }
    })
}




function Registrar_Docente(){
    var nombre = $("#txt_nombres").val();
    var apellido = $("#txt_apellidos").val();
    var documento = $("#txt_documento").val();
    var telefono = $("#txt_telefono").val();
    var sexo = $("#cbm_sexo").val();
    var fecha = $("#txt_fecha").val();
    var usu = $("#txt_usu").val();
    var contra =$ ("#txt_contra").val();
    var contra1 =$ ("#txt_contra1").val();
    var email = $("#txt_email").val();
    var validaremail = $("#validar_email").val();
    if(validaremail=="incorrecto"){
        return Swal.fire('Mensaje De Advertencia', 'El email ingresado no tiene el formato correcto','warning');
    }  
    if (nombre.length == 0 || apellido.length == 0 || documento.length == 0 || telefono.length == 0 || fecha.length == 0 
        || usu.length == 0 || contra.length == 0 || contra1.length == 0 || email.length == 0 || sexo.length == 0) {
        return Swal.fire('Mensaje De Advertencia', 'Llene los campos vacios','warning');
}
if (contra != contra1 ) {
   return Swal.fire('Mensaje De Advertencia', 'la contraseña no coinciden','warning');
}

$.ajax({
  url:"../controlador/docente/controlador_docente_registro.php",
  type: 'POST',
  data: {
    nombre:nombre,
    apellido:apellido,
    documento:documento,
    telefono:telefono,
    fecha:fecha,
    usu:usu,
    contra:contra,
    email:email,
    sexo:sexo
}
}).done(function(resp) {
   if (resp > 0) {
    if (resp == 1) {
     
        Swal.fire("Mensaje De Confirmacion", "Datos correctamente, Nuevo Docente Registrado", "success")
        .then((value) => {
            LimpiarRegistro();
            $("#modal_registro").modal('hide');
            tabla_docente.ajax.reload();
        });
    } else {
        return Swal.fire("Mensaje De Advertencia", "Lo sentimos, el [usuario/email/cedula] ya existes en la base de datos", "warning");
    }
} else {
    Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
}
})


}
function LimpiarRegistro() {
    $("#txt_nombres").val("");
    $("#txt_apellidos").val("");
    $("#txt_documento").val("");
    $("#txt_telefono").val("");
    $("#txt_fecha").val("");

}
function Editar_Docente(){
    var iddocente = $("#id_docente").val();
    var idusuario = $("#id_usuario").val();
    var nombre = $("#txt_nombres_editar").val();
    var apellido = $("#txt_apellidos_editar").val();
    var documentoactual = $("#txt_documento_editar_actual").val();
    var documentonuevo = $("#txt_documento_editar_nuevo").val();
    var telefono = $("#txt_telefono_editar").val();
    var fecha = $("#txt_fecha_editar").val();
    var email = $("#txt_email_editar").val();
    var validaremail = $("#validar_email_editar").val();
    var sexo = $("#cbm_sexo_editar").val();
    if(validaremail=="incorrecto"){
        return Swal.fire('Mensaje De Advertencia', 'El email ingresado no tiene el formato correcto','warning');
    }
    if (iddocente == null || idusuario == null) {
        return Swal.fire("Mensaje De Error","Datos Vacios","error");
    }

    if (nombre.length==0 || apellido.length==0 || documentoactual.length==0 ||documentonuevo.length==0 || telefono.length==0 || fecha.length==0 ||email.length==0|| sexo.length==0){
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }
    $.ajax({
        "url": "../controlador/docente/controlador_docente_modificar.php",
        type: 'POST',
        data: {
            iddocente:iddocente,
            idusuario:idusuario,
            nombre:nombre,
            apellido:apellido,
            documentoactual:documentoactual,
            documentonuevo:documentonuevo,
            telefono:telefono,
            fecha:fecha,
            email:email,
            sexo:sexo
        }
    }).done(function (resp) {
        if (resp == 1) {
            if (resp == 1) {
        
                Swal.fire("Mensaje De Confirmacion", "Datos Actualizados correctamente", "success")
                .then((value) => {
                    LimpiarRegistro();
                    $("#modal_editar").modal('hide');
                    tabla_docente.ajax.reload();
                });
            } else {
                return Swal.fire("Mensaje De Advertencia", "El docente ya existe en nuestra base de datos", "warning");
            }
        } else {
            Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
        }
    })

    function LimpiarRegistro() {
        $("#txt_nombres").val("");
        $("#txt_apellidos").val("");
        $("#txt_documento").val("");
        $("#txt_telefono").val("");
        $("#txt_fecha").val("");

    }
}






/*


function traerdatosdocentes() {
    var usuario = $("#usuarioprincipal").val();
    $.ajax({
        "url":"../controlador/docente/controlador_traerdatos_docente.php",
        type: 'POST',
        data:{
            usuario:usuario
        }
    }).done(function(resp){
        var data = JSON.parse(resp);
        if(data.length>0){ 
            document.getElementById("mate").style.display = "none";
            document.getElementById("español").style.display = "none";
            var cadena = "";
            var INGLES = $("#Ingles").hide();
            var español = $("#español").hide();
            var  INFORMATICA = $("#Informatica").hide();
            var ARTISTICAS = $("#artistica").hide();
            var RELIGION = $("#religion").hide();
            var NATURALES = $("#natu").hide();
            var EDUCACIÓN  = $("#edu_fisica").hide();
            var  FILOSOFIA = $("#filosofia").hide();
            var QUIMICA = $("#quimica").hide();
            var ALGEBRA = $("#algebra").hide();
            var SOCIALES = $("#Sociales").hide();
            var TRIGONOMETRÍA = $("#trigo").hide();
            EDUCACIÓN = "EDUCACIÓN FISICA";
            for (var i = 0; i < data.length; i++) {
               if (data[i][0] == "MATEMATICAS") {
                   document.getElementById("mate").style.display = "block";
               }  
               if (data[i][0] == "ESPAÑOL") {
                document.getElementById("español").style.display = "block";

            }
            
            if (data[0][0] == "INGLES") {
              INGLES.show();
          }
          if (data[i][0] == "INFORMATICA") {
              INFORMATICA.show();
          }

          if (data[i][0] == "NATURALES") {
              NATURALES.show();
          }
          if (data[i][0] == "EDUCACIÓN") {
              EDUCACIÓN.show();
          }
          if (data[i][0] == "FILOSOFIA") {
              FILOSOFIA.show();
          }
          if (data[i][0] == "QUIMICA") {
              QUIMICA.show();
          }
          if (data[i][0] == "ALGEBRA") {
              ALGEBRA.show();
          }
          if (data[i][0] == "SOCIALES") {
              SOCIALES.show();
          }
          if (data[i][0] == "TRIGONOMETRÍA") {
              TRIGONOMETRÍA.show();
          }
          if (data[i][0] == "ARTISTICAS") {
              ARTISTICAS.show();
          }
      }
      
      


  }
})

}
*/
