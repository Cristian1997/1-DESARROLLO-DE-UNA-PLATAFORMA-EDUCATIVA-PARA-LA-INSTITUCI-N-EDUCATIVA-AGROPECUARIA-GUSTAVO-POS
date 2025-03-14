var tabla_talleres;
function listar_talleres(id_grado,id_asignatura) {
  var id_usuario_doc = $("#txtidusuario").val();
  if (id_grado == null || id_asignatura == null) {
   id_grado = 1;
   id_asignatura = 1;
}
tabla_talleres = $("#tabla_talleres").DataTable({
   "ordering": false,
   "bLengthChange": true,
   "searching": { "regex": false },
   "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
   "pageLength": 10,
   "destroy": true,
   "async": false,
   "processing": true,
   "ajax": {
       "url": "../controlador/talleres/controlador_talleres_listar.php",
       type: 'POST',
       data:{
           id_usuario_doc:id_usuario_doc,
           id_asignatura:id_asignatura,
           id_grado:id_grado
       }
   },

   "columns": [
       { "defaultContent": "" },
       { "data": "titulo" },
       {     "visible": false, // Aquí se oculta la columna del video
        "defaultContent": "<button style='font-size:13px; margin-right: 1px;' type='button' class='modal_descripcion btn btn-default' title='Descripcion' ><i class='fa fa-eye'></i></button>&nbsp;"
    },
    { "data": "nombre" },
    { "data": "aula" },
    {
        "defaultContent": "<button style='font-size:13px; margin-right: 1px;' type='button' class='modal_archivos btn btn-default' title='Archivo' ><i class='fa fa-eye'></i></button>&nbsp;"
    },
    {
        "data": "Estado",
        render: function (data, type, row) {
            if (data == 'ACTIVO') {
                return "<span class='label label-success'>" + data + "</span>";
            } else {
                return "<span class='label label-danger'>" + data + "</span>";
            }
        }
    },
    { "data": "fecha" },

    { "defaultContent": "<button style='font-size:13px;' type='button' class='editar_fecha btn btn-success'><i class='fa fa-calendar-plus-o'></i></button>&nbsp;<button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fa fa-edit'></i></button>" }
    ],

   "language": idioma_espanol,
   select: true
});
document.getElementById("tabla_talleres_filter").style.display = "none";
$('input.global_filter').on('keyup click', function () {
   filterGlobal();
});
$('input.column_filter').on('keyup click', function () {
   filterColumn($(this).parents('tr').attr('data-column'));
});
tabla_talleres.on('draw.dt', function() {
   var PageInfo = $('#tabla_talleres').DataTable().page.info();
   tabla_talleres.column(0, {
       page: 'current'
   }).nodes().each(function(cell, i) {
       cell.innerHTML = i + 1 + PageInfo.start;
   });
});

}
function registrar_taller(){

   $("#modal_registro").modal({ backdrop: 'static', keyboard: false })
   $("#modal_registro|").modal('show');
   $('.js-example-basic-single2').select2();

}


$('#tabla_talleres').on('click', '.modal_archivos', function() {
    var data = tabla_talleres.row($(this).parents('tr')).data();
    if (tabla_talleres.row(this).child.isShown()) {
        var data = tabla_talleres.row(this).data();
    }
    $("#modal_archivos").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_archivos").modal('show');
    $('#descripcion_ver').val(data.detalles);
$("#lbl_titulo").html(data.titulo);
$("#lbl_descripcion").css("white-space", "pre-wrap");
$("#lbl_descripcion").html(data.descripcion);

$("#txtdocente").html(data.docente);
$("#txt_materia").html(data.nombre);
$("#txtgrado").html(data.aula);
$("#txtfecha").html(data.fecha);
    $('#archivo').attr("src", "../" + data.archivo);
    $("#foto").attr('src', '../' + data.foto);

});
$('#tabla_talleres').on('click', '.editar', function() {
    var data = tabla_talleres.row($(this).parents('tr')).data();
    if (tabla_talleres.row(this).child.isShown()) {
        var data = tabla_talleres.row(this).data();
    }
    $("#modal_editar").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_editar").modal('show');
    $("#id_taller").val(data.ID).hide();
    $("#cbm_grupo_editar").val(data.id_grupo).trigger('change');
    $("#fecha_editar").val(data.fecha);
    $("#txt_titulo_editar").val(data.titulo);
    $("#descripcion_editar").css("white-space", "pre-wrap");
    $("#descripcion_editar").val(decodeHTML(data.descripcion));
    $("#descripcion_editar_actual").val(data.archivo);

});

function decodeHTML(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}

$('#tabla_talleres').on('click', '.modal_descripcion', function() {
    var data = tabla_talleres.row($(this).parents('tr')).data();
    if (tabla_talleres.row(this).child.isShown()) {
        var data = tabla_talleres.row(this).data();
    }
    $("#modal_descripcion").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_descripcion").modal('show');
    $('#txt_descripcion').val(data.descripcion);

});
$('#tabla_talleres').on('click', '.editar_fecha', function() {
    var data = tabla_talleres.row($(this).parents('tr')).data();
    if (tabla_talleres.row(this).child.isShown()) {
        var data = tabla_talleres.row(this).data();
    }
    $("#modal_fecha").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_fecha").modal('show');
    $('#id_talleres').val(data.ID).hide();
    $("#fecha_editar").val(data.fecha);
});





function listar_combo_verificar_docente(){
 var id = $("#txtidusuario").val();
 $.ajax({
    url:"../controlador/calificaciones/controlador_combo_docente_verificar_listar.php",
    type:"POST",
    data:{
        id:id
    }
}).done(function(resp){
    let data = JSON.parse(resp);

    
    if (data.length > 0) {
       for (var i = 0 ; i < data.length; i++) {
         $("#id_docente_verifity").val(data[i][0]).hide();

     }




 }


})
}
function listar_combo_grupo(){
    var id = $("#txtidusuario").val();
    $.ajax({
       url:"../controlador/talleres/controlador_combo_grupo_listar.php",
       type:"POST",
       data:{
           id:id
       }
   }).done(function(resp){
       let data = JSON.parse(resp);
       var cadena = "";
       if (data.length > 0) {

           for (var i = 0 ; i < data.length; i++) {
               cadena += "<option value='"+data[i][0]+"'>"+ "Asignatura:  " +data[i][1]+ "  --  "+"Grado: " +  data[i][2] +" </option>" ;  

           }
           $("#cbm_grupo").html(cadena);
           id  =  $("#cbm_grupo").val();
           listar_combo_grado(id);
           listar_combo_asignatura(id);

           if (id.length != '') {
            $("#cbm_grupo_listar").val(id).trigger("change");


        }
        


    } else{
       cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
       $("#cbm_grupo").html(cadena);

   }


})
}
function listar_combo_grupos(){
    var id = $("#txtidusuario").val();
    $.ajax({
       url:"../controlador/talleres/controlador_combo_grupo_listar.php",
       type:"POST",
       data:{
           id:id
       }
   }).done(function(resp){
       let data = JSON.parse(resp);
       var cadena = "";
       if (data.length > 0) {

           for (var i = 0 ; i < data.length; i++) {
               cadena += "<option value='"+data[i][0]+"'>"+ "Asignatura:  " +data[i][1]+ "  --  "+"Grado: " +  data[i][2] +" </option>" ;  

           }
           $("#cbm_grupos").html(cadena);



       } else{
           cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
           $("#cbm_grupos").html(cadena);

       }


   })
}
function listar_combo_grado(id_grupo){
   var id = $("#txtidusuario").val();
   if (id_grupo == null) {
    id_grupo = 1;
}

$.ajax({
    url:"../controlador/calificaciones/controlador_combo_grado_listar.php",
    type:"POST",
    data:{
        id:id,
        id_grupo:id_grupo
    }
}).done(function(resp){
    let data = JSON.parse(resp);
    var cadena = "";
    if (data.length > 0) {

        for (var i = 0 ; i < data.length; i++) {
            cadena += "<option value='"+data[i][0]+"'>"+data[i][1]+" </option>" ;  

        }
        $("#cbm_grado").html(cadena);
        



    } else{
        cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
        $("#cbm_grado").html(cadena);

    }


})
}

function listar_combo_grupo_editar(){
    var id = $("#txtidusuario").val();
    $.ajax({
       url:"../controlador/talleres/controlador_combo_grupo_listar.php",
       type:"POST",
       data:{
           id:id
       }
   }).done(function(resp){
       let data = JSON.parse(resp);
       var cadena = "";
       if (data.length > 0) {

           for (var i = 0 ; i < data.length; i++) {
               cadena += "<option value='"+data[i][0]+"'>"+ "Asignatura:  " +data[i][1]+ "  --  "+"Grado:" +data[i][2] +" </option>" ;  

           }
           $("#cbm_grupo_editar").html(cadena);

           let id = $("#cbm_grupo_editar").val();
           if (id == "") {
             $("#cbm_grupo_editar").val(id).trigger('change');
         }




     } else{
       cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
       $("#cbm_grupo_editar").html(cadena);

   }


})
}
function registrar_taller(){


    var id_docente = $("#id_docente_verifity").val();
    var id_grupo = $("#cbm_grupos").val();
    var titulo  = $("#txt_titulo").val();
    var fechas = $("#fecha").val();
    var descripcion = $("#descripcion").val();
    var archivo = $("#txt_archivo").val();



    let extenxion = archivo.split('.').pop();
    let nombrefoto ="";
    let fecha = new Date();
    if (id_docente == null) {
        Swal.fire("Mensaje de Error", "Dato Vacio" , "error");
    }

    if (archivo.length>0) {
        var caracteresNoDeseados = [":", ",", ";", "!"];

        nombrefoto = titulo + "" + fecha.getDate() + "" + (fecha.getMonth() + 1) + "" + fecha.getFullYear() + "" + fecha.getMinutes() + "" + fecha.getMilliseconds() + "." + extenxion;
        
        // Reemplazar los caracteres no deseados con "_"
        caracteresNoDeseados.forEach(function(caracter) {
            nombrefoto = nombrefoto.replace(new RegExp("\\" + caracter, "g"), "_");
        });    

 }
 if (id_grupo.length == 0 || titulo.length == 0 || fecha.length == 0 || descripcion.length == 0 || archivo.length == 0 ) {
    return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
}

let formData = new FormData();
let fotoObject = $("#txt_archivo")[0].files[0]; 
formData.append('id_docente',id_docente);
formData.append('id_grupo',id_grupo);
formData.append('titulo',titulo);
formData.append('fechas',fechas);
formData.append('descripcion',descripcion);
formData.append('nombrefoto',nombrefoto);
formData.append('archivo',fotoObject)

$.ajax({

  url:"../controlador/talleres/controlador_taller_registro.php",
  type:"POST",
  data:formData,
  contentType:false,
  processData:false,
  success: function(resp){
    if (resp > 0) {

       Swal.fire("Mensaje de Confirmación", "Taller Registrado Correctamente","success").then((value) => {
         $("#modal_registro").modal('hide');
         tabla_talleres.ajax.reload();

     });



   } else{
    Swal.fire("Mensaje De Error", "No se pudo registrar los datos", "error");
}

}


});
return false;
}


function editar_taller(){
    
    var id_taller = $("#id_taller").val();
    var id_docente = $("#id_docente_verifity").val();
    var id_grupo = $("#cbm_grupo_editar").val();
    var titulo  = $("#txt_titulo_editar").val();
    var descripcion = $("#descripcion_editar").val();
    var archivo = $("#txt_archivo_editar").val();
    var archivo_actual = $("#descripcion_editar_actual").val();
    let extenxion = archivo.split('.').pop();
    let nombrefoto ="";
    let fecha = new Date();
    if (id_docente == null) {
        Swal.fire("Mensaje de Error", "Dato Vacio" , "error");
    }
     if (id_grupo.length == 0 || titulo.length == 0 || fecha.length == 0 || descripcion.length == 0 ) {
    return Swal.fire("Mensaje De Advertencia", "Llene los campos vacios", "warning");
}
 if (archivo != "") {
       if (archivo.length>0 ) {
        var caracteresNoDeseados = [":", ",", ";", "!"];

        nombrefoto = titulo + "" + fecha.getDate() + "" + (fecha.getMonth() + 1) + "" + fecha.getFullYear() + "" + fecha.getMinutes() + "" + fecha.getMilliseconds() + "." + extenxion;
        
        // Reemplazar los caracteres no deseados con "_"
        caracteresNoDeseados.forEach(function(caracter) {
            nombrefoto = nombrefoto.replace(new RegExp("\\" + caracter, "g"), "_");
        });     
     let formData = new FormData();
let fotoObject = $("#txt_archivo_editar")[0].files[0]; 


formData.append('id_taller',id_taller);
formData.append('id_docente',id_docente);
formData.append('id_grupo',id_grupo);
formData.append('titulo',titulo);
formData.append('descripcion',descripcion);
formData.append('nombrefoto',nombrefoto);
formData.append('foto',fotoObject)

$.ajax({

  url:"../controlador/talleres/controlador_editar_taller.php",
  type:"POST",
  data:formData,
  contentType:false,
  processData:false,
  success: function(resp){
    if (resp > 0) {

       Swal.fire("Mensaje de Confirmación", "Taller Registrado Correctamente","success");


       tabla_talleres.ajax.reload();
       $("#modal_editar").modal('hide');

   } else{
    Swal.fire("Mensaje De Error", "No se pudo registrar los datos", "error");
}

}


});
return false;
 }

 }
 else{
$.ajax({
url:"../controlador/talleres/controlador_taller_editar.php",
type:"POST",
data:{
    id_taller:id_taller,
    id_docente:id_docente,
    id_grupo:id_grupo,
    titulo:titulo,
    descripcion:descripcion,
    url:archivo_actual
}
}).done(function(resp){
    if (resp > 0) {

       Swal.fire("Mensaje de Confirmación", "Taller Registrado Correctamente","success");

    
        tabla_talleres.ajax.reload();
        $("#modal_editar").modal('hide');
   } else{
    Swal.fire("Mensaje De Error", "No se pudo registrar los datos", "error");
}
})

 }



}

function editar_fecha() {
    var id_taller = $("#id_talleres").val();
    var fecha = $("#fecha_editar").val();
 
    // Convertir la fecha ingresada a un objeto de fecha en JavaScript
    var fechaSeleccionada = new Date(fecha);

    // Obtener la fecha actual
    var fechaActual = new Date();
    var dia = fechaActual.getDate();
    var mes = fechaActual.getMonth() + 1; // Sumar 1 al mes porque en JavaScript los meses van de 0 a 11
    var año = fechaActual.getFullYear();

    // Formatear la fecha actual
    var fechaActualFormateada = año + '-' + (mes < 10 ? '0' + mes : mes) + '-' + (dia < 10 ? '0' + dia : dia);

    // Comparar las fechas
    if (fechaSeleccionada < fechaActual) {
        return Swal.fire(
            "Mensaje De Advertencia",
            "La Fecha ingresada ---" + fecha + "--- es menor que la fecha actual ---" + fechaActualFormateada + "--- ",
            "warning"
        );
    }
    
    $.ajax({
        url: "../controlador/talleres/controlador_editar_fechas.php",
        type: "POST",
        data: {
            id_taller: id_taller,
            fecha: fecha
        }
    }).done(function(resp) {
        if (resp > 0) {
            Swal.fire("Mensaje de Confirmación", "Fecha Modificada Correctamente", "success").then((value) => {
                $("#modal_fecha").modal('hide');
                tabla_talleres.ajax.reload();
            });
        } else {
            Swal.fire("Mensaje De Error", "No se pudo Modificar la Fecha", "error");
        }
    });
}


function datos(){

   var id_grado = $("#cbm_grado").val();
   var id_asignatura = $("#cbm_asignatura").val();

   listar_talleres(id_grado,id_asignatura);


}




function Traerfecha() {

    var data = "2023-11-23" ;
    var date ;

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

function actualizar_estado(){
    $.ajax({
        url:"../controlador/talleres/controlador_editar_estado.php",
        type:"POST"


    })
}




// SESSION DEL ESTUDIANTE

var tabla_talleres_estudiantes;
function listar_talleres_estudiantes(id_grupo, id_docente) {
   var id_usuario_es = $("#txtidusuario").val();
   var id_docente_ = $("#id_docente_verifity_es").val();
  
   if (id_grupo == null || id_docente == null ) {
       id_grupo = 1;
       id_docente = 1;

   }
   tabla_talleres_estudiantes = $("#tabla_talleres_estudiantes").DataTable({
       "ordering": false,
       "bLengthChange": true,
       "searching": { "regex": false },
       "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
       "pageLength": 10,
       "destroy": true,
       "async": false,
       "processing": true,
       "ajax": {
        "url": "../controlador/talleres/controlador_talleres_estudiante_listar.php",
        type: 'POST',
        data:{
            id_usuario_es:id_usuario_es,
            id_usuario_doc:id_docente_,
            id_grupo:id_grupo
        }
    },

    "columns": [
       { "defaultContent": "" },
       { "data": "titulo" },
   
    { "data": "nombre" },
    { "data": "aula" },
    {
        "defaultContent": "<button style='font-size:13px; margin-right: 1px;' type='button' class='abrir_descripcion btn btn-default' title='Descripcion' ><i class='fa fa-eye'></i></button>&nbsp;"
    },
    {"visible": false, // Aquí se oculta la columna del video
        "defaultContent": "<button style='font-size:13px; margin-right: 1px;' type='button' class='abrir_archivos btn btn-default' title='Archivo' ><i class='fa fa-eye'></i></button>&nbsp;"
    },
    {
        "data": "Estado",
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
        "defaultContent": "<button style='font-size:13px;' type='button' title='Subir Trabajo' class='subir_taller btn btn-success'><i class='fa fa-sign-in'></i></button>"
    }    ],

    "language": idioma_espanol,
    select: true
});
   document.getElementById("tabla_talleres_estudiantes_filter").style.display = "none";
   $('input.global_filter').on('keyup click', function () {
       filterGlobal();
   });
   $('input.column_filter').on('keyup click', function () {
       filterColumn($(this).parents('tr').attr('data-column'));
   });
   tabla_talleres_estudiantes.on('draw.dt', function() {
       var PageInfo = $('#tabla_talleres_estudiantes').DataTable().page.info();
       tabla_talleres_estudiantes.column(0, {
           page: 'current'
       }).nodes().each(function(cell, i) {
           cell.innerHTML = i + 1 + PageInfo.start;
       });
   });

}
function AbrirModalComentarios(){
   $("#modal_ver_comentarios").modal({
    backdrop: 'static',
    keyboard: false
})
   $('.js-example-basic-single').select2();
   $("#modal_ver_comentarios").modal('show'); 

}

$('#tabla_talleres_estudiantes').on('click', '.subir_taller', function() {
    var data = tabla_talleres_estudiantes.row($(this).parents('tr')).data();
    if (tabla_talleres_estudiantes.row(this).child.isShown()) {
        var data = tabla_talleres_estudiantes.row(this).data();
    }
    $("#modal_entrega").modal({
        backdrop: 'static',
        keyboard: false
    });
    $("#modal_entrega").modal('show');
    $("#id_taller_subir").val(data.ID).hide();
    $("#id_estudiante").val(data.id_estudiante).hide();
    $("#txt_editar_titulo").val(data.titulo).hide();

    if (data.Estado === 'INACTIVO') {
        $('#active_taller_content').hide();
        $('#inactive_taller_message').show();
        $('#entregar_button').hide();
    } else {
        $('#active_taller_content').show();
        $('#inactive_taller_message').hide();
        $('#entregar_button').show();
    }
});


$('#tabla_talleres_estudiantes').on('click', '.comentar', function() {
    var data = tabla_talleres_estudiantes.row($(this).parents('tr')).data();
    if (tabla_talleres_estudiantes.row(this).child.isShown()) {
        var data = tabla_talleres_estudiantes.row(this).data();
    }
    $("#modal_comentario").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_comentario").modal('show');
    $("#idtalleres").val(data.ID).hide();
    $("#txt_titulo_editar").val(data.titulo);
   
});





$('#tabla_talleres_estudiantes').on('click', '.abrir_descripcion', function() {
    var data = tabla_talleres_estudiantes.row($(this).parents('tr')).data();
    if (tabla_talleres_estudiantes.row(this).child.isShown()) {
        var data = tabla_talleres_estudiantes.row(this).data();
    }
    $("#modal_descripcion").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_descripcion").modal('show');
    $("#txt_descripcion").val(data.descripcion);
    $("#text_archivo").attr("src", "../" + data.archivo);
    $("#lbl_titulo").html(data.titulo);
$("#lbl_descripcion").css("white-space", "pre-wrap");
$("#lbl_descripcion").html(data.descripcion);

$("#txtdocente").html(data.docente);
$("#txt_materia").html(data.nombre);
$("#txtgrado").html(data.aula);
$("#txtfecha").html(data.fecha);
    $('#archivo').attr("src", "../" + data.archivo);
    $("#foto").attr('src', '../' + data.foto);

});
$('#tabla_talleres_estudiantes').on('click', '.abrir_archivos', function() {
    var data = tabla_talleres_estudiantes.row($(this).parents('tr')).data();
    if (tabla_talleres_estudiantes.row(this).child.isShown()) {
        var data = tabla_talleres_estudiantes.row(this).data();
    }
    $("#modal_archivos_abrir").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_archivos_abrir").modal('show');

    

});

function entrega_taller(){
 var id_taller = $("#id_taller_subir").val();
 var id_estudiante = $("#id_estudiante").val();
 var titulo = $("#txt_editar_titulo").val();
 var archivo = $("#txt_archivo_subir").val();
 var nota = $("#txt_nota").val();

 let extenxion = archivo.split('.').pop();
 let nombrearchivo ="";
 let fecha = new Date();
 if (id_estudiante == null || id_taller == null) {
    Swal.fire("Mensaje de Error", "Dato Vacio" , "error");
}
if (archivo.length == 0) {
    return Swal.fire("Mensaje De Advertencia", "adjunte el archivo", "warning");
}

if (archivo.length>0 ) {

    var caracteresNoDeseados = [":", ",", ";", "!"];

    nombrearchivo = titulo + "" + fecha.getDate() + "" + (fecha.getMonth() + 1) + "" + fecha.getFullYear() + "" + fecha.getMinutes() + "" + fecha.getMilliseconds() + "." + extenxion;
    
    // Reemplazar los caracteres no deseados con "_"
    caracteresNoDeseados.forEach(function(caracter) {
        nombrearchivo =  nombrearchivo.replace(new RegExp("\\" + caracter, "g"), "_");
    });     
 let formData = new FormData();

 let archivoObject = $("#txt_archivo_subir")[0].files[0]; 

 formData.append('id_taller',id_taller);
 formData.append('id_estudiante',id_estudiante);
 formData.append('nombrearchivo',nombrearchivo);
 formData.append('archivo',archivoObject),
 formData.append('nota',nota)

 $.ajax({

  url:"../controlador/talleres/controlador_entregar_taller.php",
  type:"POST",
  data:formData,
  contentType:false,
  processData:false,
  success: function(resp){
    if (resp > 0) {

       Swal.fire("Mensaje de Confirmación", "Taller Entregado Correctamente","success").then((value) => {
         $("#modal_entrega").modal('hide');
         tabla_talleres_estudiantes.ajax.reload();

     });



   } else{
    Swal.fire("Mensaje De Error", "No se pudo Entregar el taller", "error");
}

}


});
 return false;
}

}



function listar_combo_verificar_estudiante(){
 var id = $("#txtidusuario").val();
 $.ajax({
    url:"../controlador/calificaciones/controlador_combo_estudiante_verificar_listar.php",
    type:"POST",
    data:{
        id:id
    }
}).done(function(resp){
    let data = JSON.parse(resp);

    
    if (data.length > 0) {
       for (var i = 0 ; i < data.length; i++) {
         $("#id_estudiante_verifity").val(data[i][0]).hide();


     }

 }
})
}
function listar_combo_verificar_docentes(){
 var id = $("#txtidusuario").val();
 $.ajax({
    url:"../controlador/calificaciones/controlador_combo_docentes_verificar_listar.php",
    type:"POST",
    data:{
        id:id
    }
}).done(function(resp){
    let data = JSON.parse(resp);

    
    if (data.length > 0) {
       for (var i = 0 ; i < data.length; i++) {
         $("#id_docente_verifity").val(data[i][0]);



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
    }).done(function(resp) {
        let data = JSON.parse(resp);
        console.log(data); // Verificar los datos recibidos
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "' data-docente='" + data[i][4] + "'>" +
                          "Asignatura: " + data[i][1] + " -- " + "Profesor: " + data[i][2] + "</option>";
            }
            $("#cbm_grupo").html(cadena);

            // Inicializar el campo de texto con el valor del dato en la posición 4 (índice 4) de la primera opción
            var docente = $("#cbm_grupo option:selected").data("docente");
            $("#id_docente_verifity_es").val(docente);
            console.log("Initial input value:", docente); // Verificar el valor inicial

            // Llamar las funciones necesarias con el id
            id = $("#cbm_grupo").val();
            listar_combo_grado(id);
            listar_combo_asignatura(id);

            if (id.length != '') {
                $("#cbm_grupo_listar").val(id).trigger("change");
            }
        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_grupo").html(cadena);
            $("#id_docente_verifity_es").val(''); // Limpiar el campo de texto
        }
    });

    // Añadir un evento change para actualizar el campo de texto al cambiar la selección
    $("#cbm_grupo").change(function() {
        var docente = $("#cbm_grupo option:selected").data("docente");
        console.log("Selected docente:", docente); // Verificar el valor seleccionado
        $("#id_docente_verifity_es").val(docente);
        console.log("Updated input value:", $("#id_docente_verifity_es").val()); // Verificar el valor actualizado
    });
}




function listar2(){
    var id_grupo = $("#cbm_grupo").val();
    var id_docente = $("#id_docente_verifity").val();
    listar_talleres_estudiantes(id_grupo , id_docente);
}



function registrar_comentario(){
    var id_taller = $("#idtalleres").val();
    var id_usuario_es = $("#txtidusuario").val();
    var comentario = $("#txt_comentario").val();


    if (id_taller == null || id_usuario_es == null) {
        Swal.fire("Mensaje De Error"," No se Encontraron Datos del taller  o del usuario","error");
    }

    if (comentario.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los datos vacios" , "warning");
    }

    $.ajax({
        url: "../controlador/talleres/controlador_registrar_comentarios.php",
        type:"POST",
        data:{
            id_taller:id_taller,
            id_usuario_es:id_usuario_es,
            comentario:comentario
        }
    }).done(function(resp){

      if (resp > 0) {
        Swal.fire("Mensaje De Confirmación", "Comentario Resgistrado Correctamente","success").then((value) => {
         $("#modal_comentario").modal('hide');
         limpiar_campos();
         tabla_talleres_estudiantes.ajax.reload();

     });

    }else{
        Swal.fire("Mensaje De Error","no se pudo registrar los Datos","error");


    }
});
}


function registrar_comentario2(){
    var id_taller = $("#idtalleres2").val();
    var id_usuario_es = $("#txtidusuario").val();
    var comentario = $("#txt_comentario2").val();


    if (id_taller == null || id_usuario_es == null) {
        Swal.fire("Mensaje De Error"," No se Encontraron Datos del taller  o del usuario","error");
    }

    if (comentario.length == 0) {
        return Swal.fire("Mensaje De Advertencia", "Llene los datos vacios" , "warning");
    }

    $.ajax({
        url: "../controlador/talleres/controlador_registrar_comentarios.php",
        type:"POST",
        data:{
            id_taller:id_taller,
            id_usuario_es:id_usuario_es,
            comentario:comentario
        }
    }).done(function(resp){

      if (resp > 0) {
        Swal.fire("Mensaje De Confirmación", "Comentario Resgistrado Correctamente","success").then((value) => {
         $("#modal_comentario2").modal('hide');
         limpiar_campos();
         tabla_comentarios_estudiantes.ajax.reload();

     });

    }else{
        Swal.fire("Mensaje De Error","no se pudo registrar los Datos","error");


    }
});
}
function limpiar_campos(){
  $("#txt_comentario").val("");
}



// TABLA COMENTARIOS ESTUDIANTES


var tabla_comentarios_estudiantes;
function listar_comentarios_estudiantes(id_grupo,id_docente) {
  var id_usuario_es = $("#txtidusuario").val();
  if (id_grupo == null || id_docente == null ) {
   id_grupo = 1;
   id_docente = 1;

}
tabla_comentarios_estudiantes = $("#tabla_comentarios_estudiantes").DataTable({
   "ordering": false,
   "bLengthChange": true,
   "searching": { "regex": false },
   "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
   "pageLength": 10,
   "destroy": true,
   "async": false,
   "processing": true,
   "ajax": {
    "url": "../controlador/talleres/controlador_comentarios_estudiante_listar.php",
    type: 'POST',
    data:{
        id_usuario_es:id_usuario_es,
        id_usuario_doc:id_docente,
        id_grupo:id_grupo
    }
},

"columns": [
   { "defaultContent": "" },
   { "data": "titulo" },
   { "data": "docentes" },
 
{
    "data": "Estado",
    render: function (data, type, row) {
        if (data == 'RESPONDIDO') {
            return "<span class='label label-success'>" + data + "</span>";
        } else {
            return "<span class='label label-danger'>" + data + "</span>";
        }
    }
},
{ "data": "fecha" },

{ "defaultContent": "<button style='font-size:13px;' type='button' title='Haz Un Comentario Aqui!' class='comentar2 btn btn-primary'><i class='fa fa-commenting-o'></i></button>" 
}
],

"language": idioma_espanol,
select: true
});
document.getElementById("tabla_comentarios_estudiantes_filter").style.display = "none";
$('input.global_filter').on('keyup click', function () {
   filterGlobal();
});
$('input.column_filter').on('keyup click', function () {
   filterColumn($(this).parents('tr').attr('data-column'));
});
tabla_comentarios_estudiantes.on('draw.dt', function() {
   var PageInfo = $('#tabla_comentarios_estudiantes').DataTable().page.info();
   tabla_comentarios_estudiantes.column(0, {
       page: 'current'
   }).nodes().each(function(cell, i) {
       cell.innerHTML = i + 1 + PageInfo.start;
   });
});

}

$('#tabla_comentarios_estudiantes').on('click', '.abrir', function() {
    var data = tabla_comentarios_estudiantes.row($(this).parents('tr')).data();
    if (tabla_comentarios_estudiantes.row(this).child.isShown()) {
        var data = tabla_comentarios_estudiantes.row(this).data();
    }

    $("#modal_abrir").modal({
        backdrop: 'static',
        keyboard: false
    })

    $("#modal_abrir").modal('show');

    $("#txt_ver").val(data.comentarios);


});
$('#tabla_comentarios_estudiantes').on('click', '.resp', function() {
    var data = tabla_comentarios_estudiantes.row($(this).parents('tr')).data();
    if (tabla_comentarios_estudiantes.row(this).child.isShown()) {
        var data = tabla_comentarios_estudiantes.row(this).data();
    }

    $("#modal_abrir").modal({
        backdrop: 'static',
        keyboard: false
    })

    $("#modal_respuesta").modal('show');

    $("#txt_resp").val(data.respuesta);
    

});

$('#tabla_comentarios_estudiantes').on('click', '.comentar2', function() {
    var data = tabla_comentarios_estudiantes.row($(this).parents('tr')).data();
    if (tabla_comentarios_estudiantes.row(this).child.isShown()) {
        var data = tabla_comentarios_estudiantes.row(this).data();
    }
    $("#modal_comentario2").modal({
        backdrop: 'static',
        keyboard: false
    })
    $("#modal_comentario2").modal('show');
    $("#txt_id_comentario").val(data.ID).hide();
    $("#txt_titulo_editar2").val(data.titulo);

   // Verificar si data.respuesta está vacío o no
   var respuesta = data.respuesta ? data.respuesta : "NO RESPONDIDO";
   $("#lbl_ver").html(data.comentarios);
   $("#lbl_resp").html(respuesta);
  $("#lbl_estudiante").html(data.alumnos);
  $("#lbl_docente_es").html(data.docentes);
  $("#lbl_titulo").html(data.titulo);

// Asignar la ruta de la imagen al atributo src del elemento img
var rutaImagen = "../" + data.fotoestudiante; // Aquí asumo que el campo se llama "dotoestudiante"
$("#imagenestudiante").attr("src", rutaImagen);

var rutaImagen = "../" + data.fotodocente; // Aquí asumo que el campo se llama "dotoestudiante"
$("#imagendocente").attr("src", rutaImagen);

});





function volver(){


    $("#modal_abrir").modal('hide');
    $("#modal_respuesta").modal('hide');
    $("#modal_ver_comentarios").modal({
        backdrop: 'static',
        keyboard: false
    })

    $("#modal_ver_comentarios").modal('show');
}


function listar_combo_materias(){
    var id = $("#txtidusuario").val();

    $.ajax({
     url:"../controlador/calificaciones/controlador_combo_materia_listar.php",
     type:"POST",
     data:{
         id:id 
     }
 }).done(function(resp){
     let data = JSON.parse(resp);
     var cadena = "";
     if (data.length > 0) {

         for (var i = 0 ; i < data.length; i++) {
             cadena += "<option value='"+data[i][0]+"'>"+ "Asignatura:  " +data[i][1]+ "  --  "+"Profesor: " +  data[i][2] +" </option>" ;  

         }
         $("#cbm_grupos_comentarios").html(cadena);
         var id = $("#cbm_grupos_comentarios").val();


         if (id.length != '') {
            $("#cbm_grupos_comentarios").val(id).trigger("change");


        }
        


    } else{
     cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
     $("#cbm_grupos_comentarios").html(cadena);

 }


})
}

function buscar(){
    var id_grupo = $("#cbm_grupos_comentarios").val();
    var id_docente = $("#id_docente_verifity").val();
    listar_comentarios_estudiantes(id_grupo , id_docente);
}




// LISTAR COMENTARIOS DOCENTES

var tabla_comentarios_docentes;
function listar_comentarios_docentes(id_grupo,id_docente) {
  var id_usuario_es = $("#txtidusuario").val();
  if (id_grupo == null || id_docente == null ) {
   id_grupo = 1;
   id_docente = 1;

}
tabla_comentarios_docentes = $("#tabla_comentarios_docentes").DataTable({
   "ordering": false,
   "bLengthChange": true,
   "searching": { "regex": false },
   "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
   "pageLength": 10,
   "destroy": true,
   "async": false,
   "processing": true,
   "ajax": {
    "url": "../controlador/talleres/controlador_comentarios_docente_listar.php",
    type: 'POST',
    data:{
        id_usuario_es:id_usuario_es,
        id_usuario_doc:id_docente,
        id_grupo:id_grupo
    }
},

"columns": [
   { "defaultContent": "" },
   { "data": "titulo" },
   { "data": "alumnos" },

{
    "data": "Estado",
    render: function (data, type, row) {
        if (data == 'RESPONDIDO') {
            return "<span class='label label-success'>" + data + "</span>";
        } else {
            return "<span class='label label-danger'>" + data + "</span>";
        }
    }
},
{ "data": "fecha" },

{ "defaultContent": "<button style='font-size:13px;' type='button' title='Haz Un Comentario Aqui!' class='responder btn btn-primary'><i class='fa fa-commenting-o'></i></button>" 
}
],

"language": idioma_espanol,
select: true
});
document.getElementById("tabla_comentarios_docentes_filter").style.display = "none";
$('input.global_filter').on('keyup click', function () {
   filterGlobal();
});
$('input.column_filter').on('keyup click', function () {
   filterColumn($(this).parents('tr').attr('data-column'));
});
tabla_comentarios_docentes.on('draw.dt', function() {
   var PageInfo = $('#tabla_comentarios_docentes').DataTable().page.info();
   tabla_comentarios_docentes.column(0, {
       page: 'current'
   }).nodes().each(function(cell, i) {
       cell.innerHTML = i + 1 + PageInfo.start;
   });
});

}




$('#tabla_comentarios_docentes').on('click', '.abrir_comentario', function() {
    var data = tabla_comentarios_docentes.row($(this).parents('tr')).data();
    if (tabla_comentarios_docentes.row(this).child.isShown()) {
        var data = tabla_comentarios_docentes.row(this).data();
    }

    $("#modal_registro").modal({
        backdrop: 'static',
        keyboard: false
    })

    $("#modal_registro").modal('show');

    $("#txt_ver").val(data.comentarios);


});
$('#tabla_comentarios_docentes').on('click', '.editar', function() {
    var data = tabla_comentarios_docentes.row($(this).parents('tr')).data();
    if (tabla_comentarios_docentes.row(this).child.isShown()) {
        var data = tabla_comentarios_docentes.row(this).data();
    }

    $("#modal_editar").modal({
        backdrop: 'static',
        keyboard: false
    })

    $("#modal_editar").modal('show');
    $("#txt_ver_resp").val(data.respuesta);

});
$('#tabla_comentarios_docentes').on('click', '.responder', function() {
    var data = tabla_comentarios_docentes.row($(this).parents('tr')).data();
    if (tabla_comentarios_docentes.row(this).child.isShown()) {
        var data = tabla_comentarios_docentes.row(this).data();
    }

    $("#modal_responder").modal({
        backdrop: 'static',
        keyboard: false
    })

    $("#modal_responder").modal('show');

    $("#id_coemntario").val(data.ID).hide();
    $("#id_grupo").val(data.id_grupo).hide() ;
    $("#txt_resp").val(data.respuesta);
    $("#lbl_ver").html(data.comentarios);
    
     // Verificar si data.respuesta está vacío o no
     var respuesta = data.respuesta ? data.respuesta : "NO RESPONDIDO";
     $("#lbl_resp").html(respuesta);
    $("#lbl_estudiante").html(data.alumnos);
    $("#lbl_docente").html(data.docente);
    $("#lbl_titulo").html(data.titulo);

 // Asignar la ruta de la imagen al atributo src del elemento img
 var rutaImagen = "../" + data.fotoestudiante; // Aquí asumo que el campo se llama "dotoestudiante"
 $("#imagenestudiante").attr("src", rutaImagen);

 var rutaImagen = "../" + data.fotodocente; // Aquí asumo que el campo se llama "dotoestudiante"
 $("#imagendocente").attr("src", rutaImagen);
  


});
function listar_combo_verificar_docentes(){
 var id = $("#txtidusuario").val();
 $.ajax({
    url:"../controlador/calificaciones/controlador_combo_docentes_verificar_listar.php",
    type:"POST",
    data:{
        id:id
    }
}).done(function(resp){
    let data = JSON.parse(resp);

    
    if (data.length > 0) {
       for (var i = 0 ; i < data.length; i++) {
         $("#id_docente_verifity").val(data[i][0]).hide();



     }




 }
})
}
function listar_combo_verificar_docentes(){
 var id = $("#txtidusuario").val();
 $.ajax({
    url:"../controlador/calificaciones/controlador_combo_docentes_verificar_listar.php",
    type:"POST",
    data:{
        id:id
    }
}).done(function(resp){
    let data = JSON.parse(resp);

    
    if (data.length > 0) {
       for (var i = 0 ; i < data.length; i++) {
         $("#id_docente_verifity").val(data[i][0]).hide();

     }
 }
})
}


function responder(){
    var id_comentario = $("#id_coemntario").val();
    var id_grupo = $("#id_grupo").val();
    var id_docente = $("#id_docente_verifity").val();
    var respuesta = $("#txt_enviar_resp").val();

    if (id_comentario == null || id_docente == null || id_grupo == null ) {
        Swal.fire("Mensaje De Error", "Datos Vacios","error");
    }

    if (respuesta.length == 0) {
        return Swal.fire("Mensaje De Advertencia","Llene los datos vacios","warning");
    }
    $.ajax({
        url:"../controlador/talleres/controlador_resp_comentario.php",
        type:"POST",
        data:{
            id_comentario:id_comentario,
            id_docente:id_docente,
            id_grupo:id_grupo,
            respuesta:respuesta
        }
    }).done(function(resp){
        if (resp > 0) {
            Swal.fire("Mensaje De Confirmación","Respuesta registrada Correctamente","success").then((value) => {
             $("#modal_responder").modal('hide');
             tabla_comentarios_docentes.ajax.reload();

         });

        }
        else{
            Swal.fire("Mensaje de Error","no se pudo registrar el comentario", "error");

        }
    })

}

function listar(){
    var id_grupo = $("#cbm_grupo").val();
    var id_docente = $("#id_docente_verifity").val();
    listar_comentarios_docentes(id_grupo , id_docente);
}




function responder2(){
    var id_comentario = $("#txt_id_comentario").val();
    var respuesta = $("#txt_comentario2").val();

    if (id_comentario == null || respuesta == null ) {
        Swal.fire("Mensaje De Error", "Datos Vacios","error");
    }

    if (respuesta.length == 0) {
        return Swal.fire("Mensaje De Advertencia","Llene los datos vacios","warning");
    }
    $.ajax({
        url:"../controlador/talleres/controlador_resp_comentario_estudiante.php",
        type:"POST",
        data:{
            id_comentario:id_comentario,
            respuesta:respuesta
        }
    }).done(function(resp){
        if (resp > 0) {
            Swal.fire("Mensaje De Confirmación","Respuesta registrada Correctamente","success").then((value) => {
             $("#modal_comentario2").modal('hide');
             tabla_comentarios_estudiantes.ajax.reload();

         });

        }
        else{
            Swal.fire("Mensaje de Error","no se pudo registrar el comentario", "error");

        }
    })

}



