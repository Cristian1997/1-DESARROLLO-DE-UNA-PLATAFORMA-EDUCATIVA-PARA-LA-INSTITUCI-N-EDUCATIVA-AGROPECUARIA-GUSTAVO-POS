/* FUNSION VEREFICAR USUARIO */
function VerificarUsuario() {
    var usu = $("#txt_usu").val();
    var con = $("#txt_con").val();

    if (usu.length == 0 || con.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");

    }
    $.ajax({
        url: '../controlador/usuario/controlador_verificar_usuario.php',
        type: 'POST',
        data: {
            user: usu,
            pass: con
        }
    }).done(function (resp) {
        if (resp == 0) {
            $.ajax({
                url: '../controlador/usuario/controlador_intento_modificar.php',
                type: 'POST',
                data: {
                   usuario:usu
               }
           }).done(function(resp){
                   if(resp==2){// 0 1 2
                    Swal.fire("Mensaje De Advertencia", "Usuario y/o contrase\u00f1a incorrecta,Intentos fallidos : " +(parseInt(resp)+1)+ "-Para poder aceder a su cuenta restablesca la contrase&#241;a", "warning");
                }else{
                    Swal.fire("Mensaje De Advertencia", "Usuario y/o contrase\u00f1a incorrecta,Intentos fallidos : " +(parseInt(resp)+1)+ "", "warning");
                }
            })
       } else {
        var data = JSON.parse(resp);
        if (data[0][5] === 'INACTIVO') {
            return Swal.fire("Mensaje De Advertencia", "Lo sentimos el usuario " + usu + " se encuentra suspendido, comuniquese con el administrador", "warning");
        }
        if (data[0][9] == 2) {
            return Swal.fire("Mensaje De Advertencia", "Su cuenta actualmente esta bloqueada, para desbloquear restablesca su contra&#241;a", "warning");
        }
        $.ajax({
            url: '../controlador/usuario/controlador_crear_session.php',
            type: 'POST',
            data: {
                idusuario: data[0][0],
                user: data[0][1],
                rol: data[0][6]
            }
        }).done(function (resp) {
            let timerInterval
            Swal.fire({
                title: 'BIENVENIDO AL SISTEMA',
                html: 'Usted sera redireccionado en <b></b> milisegundos.',
                timer: 2000,
                timerProgressBar: true,
                onBeforeOpen: () => {
                    Swal.showLoading()
                    timerInterval = setInterval(() => {
                        const content = Swal.getContent()
                        if (content) {
                            const b = content.querySelector('b')
                            if (b) {
                                b.textContent = Swal.getTimerLeft()
                            }
                        }
                    }, 100)
                },
                onClose: () => {
                    clearInterval(timerInterval)
                }
            }).then((result) => {
                    /* Read more about handling dismissals below */
                if (result.dismiss === Swal.DismissReason.timer) {
                    location.reload();
                }
            })
        })

    }
})
}
/* FUNSION VEREFICAR USUARIO */

/* FUNSION LISTAR USUARIOS REGISTRADOS*/
var table;
function listar_usuario() {

    table = $("#tabla_usuario").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/usuario/controlador_usuario_listar.php",
            type: 'POST'
        },
        "columns": [
            { "data": "Posicion" },
            { "data": "usu_nombre" },
            { "data": "usu_email" },
            { "data": "rol_nombre" },
            {"data": "usu_sexo",
            render: function (data, type, row) {
                if (data == 'M') {
                    return "MASCULINO";
                } else {
                    return "FEMENINO";
                }
            }
        },

        {
            "data": "usu_estatus",
            render: function (data, type, row) {
                if (data == 'ACTIVO') {
                    return "<span class='label label-success'>" + data + "</span>";
                } else {
                    return "<span class='label label-danger'>" + data + "</span>";
                }
            }
        },  
        {"data":"foto",

        render: function (data, type, row ) {
         return '<img class="img-responsibe img-circle elevation-2" style="width:60px" src="../'+data+'">';

     }
 },
 { "defaultContent": "<button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fa fa-edit'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='desactivar btn btn-danger'><i class='fa fa-trash'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='activar btn btn-success'><i class='fa fa-check'></i></button>" }
 ],

        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_usuario_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });

}
/* FUNSION LISTAR USUARIOS REGISTRADOS*/

/* FUNSION ACTIVAR USUARIOS REGISTRADOS*/
$('#tabla_usuario').on('click', '.activar', function () {
    var data = table.row($(this).parents('tr')).data();
    if (table.row(this).child.isShown()) {
        var data = table.row(this).data();
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
            Modificar_Estatus(data.ID, 'ACTIVO');
        }
    })
})
/* FUNSION ACTIVAR USUARIOS REGISTRADOS*/

/* FUNSION DESASTIVAR USUARIOS REGISTRADOS*/
$('#tabla_usuario').on('click', '.desactivar', function () {
    var data = table.row($(this).parents('tr')).data();
    if (table.row(this).child.isShown()) {
        var data = table.row(this).data();
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
            Modificar_Estatus(data.ID, 'INACTIVO');
        }
    })
})
/* FUNSION DESASTIVAR USUARIOS REGISTRADOS*/

/* FUNSION EDITAR USUARIOS REGISTRADOS*/
$('#tabla_usuario').on('click', '.editar', function () {
    var data = table.row($(this).parents('tr')).data();
    if (table.row(this).child.isShown()) {
        var data = table.row(this).data();
    }
    $("#modal_editar").modal({ backdrop: 'static', keyboard: false })
    $("#modal_editar  ").modal('show');
    $("#txtidusuario").val(data.ID);
    $("#txtusu_editar").val(data.usu_nombre);
    $("#txt_email_editar").val(data.usu_email);
    $("#cbm_sexo_editar").val(data.usu_sexo).trigger("change");
    $("#cbm_rol_editar").val(data.id_rol).trigger("change");
})
/* FUNSION EDITAR USUARIOS REGISTRADOS*/

/* FUNSION MODIFICAR USUARIOS REGISTRADOS*/
function Modificar_Estatus(idusuario, estatus) {
    var mensaje = "";
    if (estatus == 'INACTIVO') {
        mensaje = "desactivo";
    } else {
        mensaje = "activo";
    }
    $.ajax({
        "url": "../controlador/usuario/controlador_modificar_estatus_usuario.php",
        type: 'POST',
        data: {
            idusuario: idusuario,
            estatus: estatus
        }
    }).done(function (resp) {
        if (resp > 0) {
            Swal.fire("Mensaje De Confirmacion", "El usuario se " + mensaje + " con exito", "success")
            .then((value) => {
                table.ajax.reload();
            });
        }
    })


}
/* FUNSION MODIFICAR USUARIOS REGISTRADOS*/

/* FUNSION BUSCAR USUARIOS REGISTRADOS*/
function filterGlobal() {
    $('#tabla_usuario').DataTable().search(
        $('#global_filter').val(),
        ).draw();
}
/* FUNSION BUSCAR USUARIOS REGISTRADOS*/

/* FUNSION MODAL DE REGISTRO*/
function AbrirModalRegistro() {
    $("#modal_registro").modal({ backdrop: 'static', keyboard: false })
    $("#modal_registro").modal('show');
}
/* FUNSION MODAL DE REGISTRO*/

/* FUNSION LISTAR ROL DE USUARIOS*/
function listar_combo_rol() {
    $.ajax({
        "url": "../controlador/usuario/controlador_combo_rol_listar.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + data[i][1] + "</option>";
            }
            $("#cbm_rol").html(cadena);
            $("#cbm_rol_editar").html(cadena);
        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_rol").html(cadena);
            $("#cbm_rol_editar").html(cadena);
        }
    })
}
/* FUNSION LISTAR ROL DE USUARIOS*/

/* FUNSION REGISTRAR USUARIOS*/
function Registrar_Usuario() {
    var usu = $("#txt_usu").val();
    var contra = $("#txt_con1").val();
    var contra2 = $("#txt_con2").val();
    var sexo = $("#cbm_sexo").val();
    var rol = $("#cbm_rol").val();
    var email = $("#txt_email").val(); 
    var foto = $("#img_foto").val();
    var validaremail = $("#validar_email").val();

    if (foto.length == "") {
        return Swal.fire("Mensaje De Advertencia","Seleccione una foto","warning");
    }
    let extenxion = foto.split('.').pop();
    let nombrefoto ="";
    let fecha = new Date();
    if (foto.length>0) {
     nombrefoto = usu + "" +fecha.getDate() +""+ (fecha.getMonth() + 1 ) +""+ fecha.getFullYear() + "" + fecha.getMinutes() + "" + fecha.getMilliseconds() + "." + extenxion;  

 }
 if (usu.length == 0 || contra.length == 0 || contra.length == 0 || contra2.length == 0 || sexo.length == 0 || rol.length == 0) {
    return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
}

if (contra != contra2) {
    return Swal.fire("Mensaje De Advertencia", "Las contraseñas deben coincidir", "warning");
}

if (validaremail == "incorrecto") {
    return Swal.fire("Mensaje De Advertencia", "El formato de email es incorrecto, ingrese un formato valido", "warning");
}
let formData = new FormData();
let fotoObject = $("#img_foto")[0].files[0]; 
formData.append('u',usu);
formData.append('c',contra);
formData.append('s',sexo);
formData.append('r',rol);
formData.append('e',email);
formData.append('nombrefoto',nombrefoto);
formData.append('foto',fotoObject);
$.ajax({
  url:"../controlador/usuario/controlador_usuario_registro.php",
  type:"POST",
  data:formData,
  contentType:false,
  processData:false,
  success: function(resp){
     if (resp > 0) {

      Swal.fire("Mensaje De Confirmacion","Usuario Registrado Correctamente ","success").then(value=>{
         $("#modal_registro").modal('hide');

         table.ajax.reload();
         $("#img_lateral").ajax.reload();
         $("#img_nav").ajax.reload();
         $("#img_subnav").ajax.reload();
         limpiar_datos();

     })

  }else{
    Swal.fire("Mensaje De Error", "No se pudo registrar el usuario","error");
}
}
});
return false;


}
/* FUNSION REGISTRAR USUARIOS*/

/* FUNSION MODIFICAR USUARIOS*/
function Modificar_Usuario() {
    var idusuario = $("#txtidusuario").val();
    var sexo = $("#cbm_sexo_editar").val();
    var rol = $("#cbm_rol_editar").val();
    var email = $("#txt_email_editar").val();
    var validaremail = $("#validar_email_editar").val();
    if (idusuario.length == 0 || sexo.length == 0 || rol.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
    }

    if (validaremail == "incorrecto") {
        return Swal.fire("Mensaje De Advertencia", "El formato de email es incorrecto, ingrese un formato valido", "warning");
    }

    $.ajax({
        "url": "../controlador/usuario/controlador_usuario_modificar.php",
        type: 'POST',
        data: {
            idusuario:idusuario,
            sexo: sexo,
            rol: rol,
            email:email
        }
    }).done(function (resp) {
        if (resp > 0) {
            TraerDatosUsuario();
       
            Swal.fire("Mensaje De Confirmacion", "Datos Actualizados correctamente", "success")
            .then((value) => {
                $("#modal_editar").modal('hide');
                table.ajax.reload();
            });

        } else {
            Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar la actualizacion", "error");
        }
    })


}

function LimpiarRegistro() {
    $("#txt_usu").val("");
    $("#txt_con1").val("");
    $("#txt_con2").val("");
}


function TraerDatosUsuario() {
    var usuario = $("#usuarioprincipal").val();
    $.ajax({
        "url":"../controlador/usuario/controlador_traerdatos_usuario.php",
        type: 'POST',
        data:{
            usuario:usuario
        }
    }).done(function(resp){
        var data = JSON.parse(resp);
        if(data.length>0){ 
            $("#txtidusuario").val(data[0][0]).hide();
            $("#txtcontra_bd").val(data[0][2]);
            $("#txt_id_usuario_editar_foto").val(data[0][0]);
            $("#txt_usu_editar").val(data[0][1]);
            $("#txt_usuario_editar").val(data[0][1]);
            var nombreMostrar = data[0].nombre_completo ? data[0].nombre_completo : "Personal Administrativo";
            $("#lbl_nombre").html(nombreMostrar);
$("#nombre_p").html(data[0][11]);
            $("#txt_email_editar").val(data[0][4]);
            $("#cbm_sexo_editar").val(data[0][3]).trigger("changer");
            $("#cbm_rol_editar").val(data[0][5]).trigger("changer");
            $("#cbm_status_editar").val(data[0][7]).trigger("changer");
            $("#status").html(data[0][5]);
            $("#rol").html(data[0][7]);
            $("#email").html(data[0][4]);
            if (data[0][3] == "M") {
                $("#sexo").html("MASCULINO");
                $("#icono_sexo").removeClass("fa-female").addClass("fa-male");
            } else {
                $("#sexo").html("FEMENINO");
                $("#icono_sexo").removeClass("fa-male").addClass("fa-female");
            }
            
            $('#img_nav').attr("src","../"+data[0][10]+"");
            $('#img_lateral').attr("src","../"+data[0][10]+"");
            $('#img_subnav').attr("src","../"+data[0][10]+"");
            $('#img_perfil').attr("src","../"+data[0][10]+"");
        }
    })

}

function AbrirModalEditarContra() {
    $("#modal_editar_contra").modal({ backdrop: 'static', keyboard: false })
    $("#modal_editar_contra").modal('show');
    $("#modal_editar_contra").on('shown.bs.modal',function(){
        $("#txtcontraactual_editar").focus();  
    })
}

function TraerDatosContador() {
    $.ajax({
        "url": "../controlador/usuario/controlador_traerdatos_contador.php",
        type: 'POST'
    }).done(function (resp) {
        var data = JSON.parse(resp);
        document.getElementById('txtregistro').innerHTML = data[0].contar_usuario;
        document.getElementById('txtdocente').innerHTML = data[0].contar_docente;
        document.getElementById('txtestudiante').innerHTML = data[0].contar_estudiantes;
        document.getElementById('txtcurso').innerHTML = data[0].contar_cursos;    
    })
}


function LimpiarEditarContra(){
    $("#txtcontraactual_editar").val("");
    $("#txtcontranu_editar").val("");
    $("#txtcontrare_editar").val("");
}

function AbrirModalRestablecer(){
    $("#modal_restablecer_contra").modal({ backdrop: 'static', keyboard: false })
    $("#modal_restablecer_contra").modal('show');
    $("#modal_restablecer_contra").on('shown.bs.modal',function(){
        $("#txt_email").focus();  
    })

}

function Restablecer_Contra(){
    var email = $("#txt_email").val();
    if(email.length==0){
        return Swal.fire("Mensaje De Avertencia","Llene los campos en blanco","warning")
    }
    var carasteres="abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    var contrasena ="";
    for(var i=0;i<6;i++){
        contrasena+=carasteres.charAt(Math.floor(Math.random()*carasteres.length));
    }
    $.ajax({        
        "url":"../controlador/usuario/controlador_restablecer_contra.php",
        type: 'POST',
        data:{
            email:email,
            contrasena:contrasena
        }
    }).done(function(resp){
     if(resp>0){
        if(resp==1){
            Swal.fire("Mensaje De Confirmac&#243;n","Su contrase&#241;a fue restablecida con exito al correo:"+email+"","sucess");
        }else{
            Swal.fire("Mensaje De dvertencia","El correo ingresado no se encuentra en nuestra base de datos","warning");
        }

    }else{
        Swal.fire("Mensaje De Error","no se puede restablecer su contrase&#241;a","error");
    }

})
}
function Abrir_modal_editar_contra(){

 $("#modal_editar_contra").modal({backdrop:'static',keyboard:false})
 $("#modal_editar_contra").modal('show');
 $("#modal_editar_contra").on('shown.bs.modal',function(){
    $("#txt_con_actual").focus();

})

}


function Editar_contra(){
    var idusuario = $("#txtidprincipal").val();
    var contradb = $("#txtcontra_bd").val();
    var contraactual = $("#txt_con_actual").val();
    var contranueva = $("#txt_con_nuevo").val();
    var contrarepetir = $("#txt_con_repetir").val();
    if(contraactual.length == 0 || contranueva.length==0 || contrarepetir==0){

        return Swal.fire("Mensaje de Advertencia","llene los campos vacios","warning");
    }
    if(contranueva.length != contrarepetir.length){

        return Swal.fire("Mensaje de Advertencia","la contraseña no coinciden","warning");

    }

    $.ajax({
        "url":"../controlador/usuario/controlador_contra_modificar.php",
        type:'POST',
        data:{
            idusuario:idusuario,
            contradb:contradb,
            contraactual:contraactual,
            contranueva:contranueva



        }
    }).done(function(resp){
        if (resp>0) {
          if(resp==1){
         
            Swal.fire("Mensaje De Confirmacion","Contrase\u00f1a actualizada correctamente" , "success")            
            .then ( ( value ) =>  {
                $("#modal_editar_contra").modal('hide');
               TraerDatosUsuario();
               limpiarEditarcontra();
           });
        }else{
          Swal.fire("Mensaje de Error" , "la contrase\u00f1a actual no coinciden con su contras\u00f1a antigua" , "error");
      }
  }else{
    Swal.fire("Mensaje de Error" , "no se pudo modificar la contrase\u00f1a" , "error");
}
})

}


$("#table").on('click','.editar_foto', function(){
  $(".form-control").removeClass('is-invalid').removeClass('is-valid');
  var data = table.row($(this).parents('tr')).data();
  if (table.row(this).child.isShown()) {
    var data = table.row(this).data();
}
$("#modal_editar_foto").modal('show');  
document.getElementById('txt_id_usuario_editar_foto').value =data[0];
document.getElementById('txt_usuario_editar').value =data[1];
document.getElementById('lb_user').innerHTML =data[1];



});

function editar_usuario_foto_perfil(){

  let usuario = document.getElementById('txt_usuario_editar').value;
  let id_usuario = document.getElementById('txt_id_usuario_editar_foto').value;
  let foto_editar = document.getElementById('img_foto_editar').value;
  if (foto_editar.length == "") {
    return Swal.fire("Mensaje De Advertencia","Seleccione una foto","warning");
}
let extenxion = foto_editar.split('.').pop();
let nombrefoto ="";
let fecha = new Date();
if (foto_editar.length>0) {
 nombrefoto = usuario + "" +fecha.getDate() +""+ (fecha.getMonth() + 1 ) +""+ fecha.getFullYear() + "" + fecha.getMinutes() + "" + fecha.getMilliseconds() + "." + extenxion;  

}

let formData = new FormData();
let fotoObject = $("#img_foto_editar")[0].files[0]; 
formData.append('ID',id_usuario);
formData.append('nombrefoto',nombrefoto);
formData.append('foto',fotoObject);
$.ajax({
  url:"../controlador/usuario/controlador_editar_usuario_foto.php",
  type:"POST",
  data:formData,
  contentType:false,
  processData:false,
  success: function(resp){
     if (resp > 0) {

      Swal.fire("Mensaje De Confirmacion","Foto Actualizada Correctamente ","success").then(value=>{
         $("#modal_editar_foto").modal('hide');

         location.reload();
         $("#img_lateral").ajax.reload();
         $("#img_nav").ajax.reload();
         $("#img_subnav").ajax.reload();
         limpiar_datos();

     })

  }else{
    Swal.fire("Mensaje De Error", "No se pudo Actualizar la foto","error");
}
}
});
return false;
}

function editar_usuario_foto(){

  let usuario = document.getElementById('txt_usuario_editar').value;
  let id_usuario = document.getElementById('txt_id_usuario_editar_foto').value;
  let foto_editar = document.getElementById('img_foto_editar').value;
  if (foto_editar.length == "") {
    return Swal.fire("Mensaje De Advertencia","Seleccione una foto","warning");
}
let extenxion = foto_editar.split('.').pop();
let nombrefoto ="";
let fecha = new Date();
if (foto_editar.length>0) {
 nombrefoto = usuario + "" +fecha.getDate() +""+ (fecha.getMonth() + 1 ) +""+ fecha.getFullYear() + "" + fecha.getMinutes() + "" + fecha.getMilliseconds() + "." + extenxion;  

}

let formData = new FormData();
let fotoObject = $("#img_foto_editar")[0].files[0]; 
formData.append('ID',id_usuario);
formData.append('nombrefoto',nombrefoto);
formData.append('foto',fotoObject);
$.ajax({
  url:"../controlador/usuario/controlador_editar_usuario_foto.php",
  type:"POST",
  data:formData,
  contentType:false,
  processData:false,
  success: function(resp){
     if (resp > 0) {

      Swal.fire("Mensaje De Confirmacion","Foto Actualizada Correctamente ","success").then(value=>{
         $("#modal_editar_foto").modal('hide');

         table.ajax.reload();
         $("#img_lateral").ajax.reload();
         $("#img_nav").ajax.reload();
         $("#img_subnav").ajax.reload();
         limpiar_datos();

     })

  }else{
    Swal.fire("Mensaje De Error", "No se pudo Actualizar la foto","error");
}
}
});
return false;
}