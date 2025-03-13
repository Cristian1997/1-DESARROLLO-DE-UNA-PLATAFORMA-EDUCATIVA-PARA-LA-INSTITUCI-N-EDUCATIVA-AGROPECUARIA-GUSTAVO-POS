var tabla_estudiante;
function listar_estudiante() {
    tabla_estudiante = $("#tabla_estudiante").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/estudiante/controlador_estudiante_listar.php",
            type: 'POST'
        },
        "order": [[1, 'asc']],
        "columns": [
            { "defaultContent": "" },
            { "data": "nm_documento" },
            { "data": "estudiante" },
            { "data": "fecha_nacimiento" },
            { "data": "telefono" },
            {"data": "usu_sexo",
            render: function (data, type, row) {
                if (data == 'M') {
                    return "MASCULINO";
                } else {
                    return "FEMENINO";
                }
            }
        },
        { "data": "usu_email" },
        { "data": "aula" },


        { "defaultContent": "<button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fa fa-edit'></i></button>" }
        ],

        "language": idioma_espanol,
        select: true

        
    });
    document.getElementById("tabla_estudiante_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });

    function filterGlobal() {
        $('#tabla_estudiante').DataTable().search(
            $('#global_filter').val()
            ).draw();
    }
    tabla_estudiante.on('draw.td', function(){
        var pageinfo =  $("#tabla_estudiante").DataTable().page.info();
        tabla_estudiante.column(0, {page: 'current'}).nodes().each(function(cell, i){
          cell.innerHTML = i + 1 + pageinfo.start;
      });

    });

}


$('#tabla_estudiante').on('click', '.editar', function () {
    var  data =  tabla_estudiante.row($(this).parents('tr')).data();
    if ( tabla_estudiante.row(this).child.isShown()) {
        var data =  tabla_estudiante.row(this).data();
    }
    $('.js-example-basic-single').select2();
    $('.js').select2();
    $("#modal_editar").modal({ backdrop: 'static', keyboard: false })
    $("#modal_editar").modal('show');
    $("#id_estudiante").val(data.ID).hide();
    $("#txt_nombres_editar").val(data.nombre_estudiante);
    $("#txt_apellidos_editar").val(data.apellidos_estudiante);
    $("#txt_documento_editar_actual").val(data.nm_documento).hide();
    $("#txt_documento_editar_nuevo").val(data.nm_documento);
    $("#txt_telefono_editar").val(data.telefono);
    $("#txt_fecha_editar").val(data.fecha_nacimiento);
    $("#cbm_grado_editar").val(data.id_grado).trigger("change");
    $("#id_usuario").val(data.id_usu).hide(); 
    $("#txt_usu_editar").val(data.usu_nombre); 
    $("#txt_email_editar").val(data.usu_email);
    $("#status").html(data.usu_estatus);
    $("#cbm_sexo_editar").val(data.usu_sexo).trigger("change");

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
    $('.js-example-basic-single').select2();
    $('.js').select2();
}

function listar_combo_edad() {
    $.ajax({
        "url": "../controlador/estudiante/controlador_combo_edad.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + "</option>";
            }
            $("#cbm_edad").html(cadena);
            $("#cbm_edad_editar").html(cadena);
        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_edad").html(cadena);
            $("#cbm_edad_editar").html(cadena);
        }
    })
}

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



function Registrar_Estudiante(){
    var nombre = $("#txt_nombres").val();
    var apellido = $("#txt_apellidos").val();
    var documento = $("#txt_documento").val();
    var telefono = $("#txt_telefono").val();
    var fecha = $("#txt_fecha").val();
    var grado = $("#cbm_grado").val();
    var usu = $("#txt_usu").val();
    var contra =$ ("#txt_contra").val();
    var contra1 =$ ("#txt_contra1").val();
    var email = $("#txt_email").val(); 
    var sexo = $("#cbm_sexo").val();
    
    var validaremail = $("#validar_email").val();
    if(validaremail=="incorrecto"){
        return Swal.fire('Mensaje De Advertencia', 'El email ingresado no tiene el formato correcto','warning');
    }


    
    if (nombre.length==0 || apellido.length==0 || documento.length==0 || telefono.length==0 || fecha.length==0 ||
        grado.length==0|| usu.length==0|| contra.length==0 || contra1.length == 0 || email.length==0|| sexo.length==0){
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
}
if (contra != contra1) {
    return Swal.fire("Mensaje De Advertencia","la contraseña no coinciden","warning");
}
$.ajax({
    "url": "../controlador/estudiante/controlador_estudiante_resgistrar.php",
    type: 'POST',
    data: {
        nombre:nombre,
        apellido:apellido,
        documento:documento,
        telefono:telefono,
        fecha:fecha,
        grado:grado,
        usu:usu,
        contra:contra,
        email:email,
        sexo:sexo
    }
}).done(function (resp) {
    if (resp > 0) {
        if (resp == 1) {
      
            Swal.fire("Mensaje De Confirmacion", "Datos correctamente, Nuevo Estudiante Registrado", "success")
            .then((value) => {
                LimpiarRegistro();
                $("#modal_registro").modal('hide');
                tabla_estudiante.ajax.reload();
            });
        } else {
            return Swal.fire("Mensaje De Advertencia", "Lo sentimos, el nombre del estudiante ya se encuentra en nuestra base de datos", "warning");
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

function Editar_Estudiante(){
    var iddestudiante = $("#id_estudiante").val();
    var idusuario = $("#id_usuario").val();
    var nombre = $("#txt_nombres_editar").val();
    var apellido = $("#txt_apellidos_editar").val();
    var documentoactual = $("#txt_documento_editar_actual").val();
    var documentonuevo = $("#txt_documento_editar_nuevo").val();
    var telefono = $("#txt_telefono_editar").val();
    var fecha = $("#txt_fecha_editar").val();
    var sexo = $("#cbm_sexo_editar").val();
    var grado = $("#cbm_grado_editar").val();
    var email = $("#txt_email_editar").val();
    var validaremail = $("#validar_email_editar").val();
    if(validaremail=="incorrecto"){
        return Swal.fire('Mensaje De Advertencia', 'El email ingresado no tiene el formato correcto','warning');
    }
    if (iddestudiante == null || idusuario == null) {
        return Swal.fire("Mensaje De Error","Datos Vacios","error");
    }
    var sexo = $("#cbm_sexo_editar").val();
    if (nombre.length==0 || apellido.length==0 || documentoactual.length==0 ||documentonuevo.length==0 || telefono.length==0 || fecha.length==0 || 
     grado.length==0||email.length==0|| sexo.length==0){
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }
    $.ajax({
        "url": "../controlador/estudiante/controlador_estudiante_modificar.php",
        type: 'POST',
        data: {
            iddestudiante:iddestudiante,  
            idusuario:idusuario,
            nombre:nombre,
            apellido:apellido,
            documentoactual:documentoactual,
            documentonuevo:documentonuevo,
            telefono:telefono,
            fecha:fecha,
            grado:grado,
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
                    tabla_estudiante.ajax.reload();
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