
// TABLA COMENTARIOS ESTUDIANTES

function listar_comentarios_estudiantes() {
    var id_usuario_es = $("#txtidusuario").val();
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
        "url": "../controlador/talleres/controlador_comentarios_estudiante_listar_asunto.php",
        "type": 'POST',
        "data": {
          "id_usuario_es": id_usuario_es
        },
        "dataSrc": ""
      },
  
      "columns": [
        { "data": null },
        { "data": "asunto" },
        { "data": "docente" },
        {
          "data": "estado",
          "render": function (data, type, row) {
            if (data == 'RESPONDIDO') {
              return "<span class='label label-success'>" + data + "</span>";
            } else {
              return "<span class='label label-danger'>" + data + "</span>";
            }
          }
        },
        { "data": "fecha" },
        {
          "data": null,
          "defaultContent": "<button style='font-size:13px;' type='button' title='Haz Un Comentario Aqui!' class='comentar2 btn btn-primary'><i class='fa fa-commenting-o'></i></button>"
        }
      ],
  
      "language": idioma_espanol,
      "select": true
    });
  
    // Ocultar el filtro de búsqueda
    document.getElementById("tabla_comentarios_estudiantes_filter").style.display = "none";
  
    // Función para filtrar globalmente
    $('input.global_filter').on('keyup click', function () {
      tabla_comentarios_estudiantes.search($(this).val()).draw();
    });
  
    // Función para filtrar por columna
    $('input.column_filter').on('keyup click', function () {
      var columnIndex = $(this).parents('tr').attr('data-column');
      tabla_comentarios_estudiantes.column(columnIndex).search($(this).val()).draw();
    });
  
    // Personalizar el número de fila
    tabla_comentarios_estudiantes.on('order.dt search.dt', function () {
      tabla_comentarios_estudiantes.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();
  }
  
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
   $("#lbl_ver").html(data.comentario);
   $("#lbl_resp").html(respuesta);
  $("#lbl_estudiante").html(data.estudiante);
  $("#lbl_docente_es").html(data.docente);
  $("#lbl_titulo").html(data.asunto);

// Asignar la ruta de la imagen al atributo src del elemento img
var rutaImagen = "../" + data.fotoestudiante; // Aquí asumo que el campo se llama "dotoestudiante"
$("#imagenestudiante").attr("src", rutaImagen);

var rutaImagen = "../" + data.fotodocente; // Aquí asumo que el campo se llama "dotoestudiante"
$("#imagendocente").attr("src", rutaImagen);

});


function comentario_nuevo() {
    $("#modal_comentario_nuevo").modal({
        backdrop: 'static',
        keyboard: false
    });
    $("#modal_comentario_nuevo").modal('show');
}

$('#tabla_comentarios_estudiantes').on('click', '.comentario_nuevo', function() {
    var data = tabla_comentarios_estudiantes.row($(this).parents('tr')).data();
    if (tabla_comentarios_estudiantes.row(this).child.isShown()) {
        var data = tabla_comentarios_estudiantes.row(this).data();
    }
    comentario_nuevo(); // Llamar a la función comentario_nuevo() aquí
});
//---------------registros----------------------------

function registrar_comentario_nuevo(){
  var id_docente = $("#cbm_docente").val();
  var id_usuario_es = $("#txtidusuario").val();
  var asunto = $("#txt_comentario_nuevo").val();
  var comentario = $("#txt_comentario_nuevo").val();


  if (comentario.length == 0) {
      return Swal.fire("Mensaje De Advertencia", "Llene los datos vacios" , "warning");
  }

  $.ajax({
      url: "../controlador/talleres/controlador_registrar_comentarios_asunto.php",
      type:"POST",
      data:{
          id_docente:id_docente,
          id_usuario_es:id_usuario_es,
          asunto:asunto,
          comentario:comentario
      }
  }).done(function(resp){

    if (resp > 0) {
      Swal.fire("Mensaje De Confirmación", "Comentario Resgistrado Correctamente","success").then((value) => {
       $("#modal_comentario_nuevo").modal('hide');
   
       tabla_comentarios_estudiantes.ajax.reload();

   });

  }else{
      Swal.fire("Mensaje De Error","no se pudo registrar los Datos","error");


  }
});
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
      url:"../controlador/talleres/controlador_resp_comentario_estudiante_asunto.php",
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

//---------------listar combo---------------------------
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




function listar_combo_docentes() {
    var id = $("#txtidusuario").val();
    $.ajax({
        "url": "../controlador/talleres/controlador_combo_docente_asunto_listar.php",
        type: 'POST',
        data:{
            id:id
        }
    }).done(function (resp) {
        var data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][1] + "'>" + data[i][0] + "</option>";
            }
            $("#cbm_docente").html(cadena);
    
        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_docente").html(cadena);
         
        }
    })
}

// TABLA COMENTARIOS DOCENTES

function listar_comentarios_docentes() {
    var id_usuario_es = $("#txtidusuario").val();
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
        "url": "../controlador/talleres/controlador_comentarios_docente_listar_asunto.php",
        "type": 'POST',
        "data": {
          "id_usuario_es": id_usuario_es
        },
        "dataSrc": ""
      },
  
      "columns": [
        { "data": null },
        { "data": "asunto" },
        { "data": "estudiante" },
        {
          "data": "estado",
          "render": function (data, type, row) {
            if (data == 'RESPONDIDO') {
              return "<span class='label label-success'>" + data + "</span>";
            } else {
              return "<span class='label label-danger'>" + data + "</span>";
            }
          }
        },
        { "data": "fecha" },
        {
          "data": null,
          "defaultContent": "<button style='font-size:13px;' type='button' title='Haz Un Comentario Aqui!' class='comentar btn btn-primary'><i class='fa fa-commenting-o'></i></button>"
        }
      ],
  
      "language": idioma_espanol,
      "select": true
    });
  
    // Ocultar el filtro de búsqueda
    document.getElementById("tabla_comentarios_estudiantes_filter").style.display = "none";
  
    // Función para filtrar globalmente
    $('input.global_filter').on('keyup click', function () {
      tabla_comentarios_estudiantes.search($(this).val()).draw();
    });
  
    // Función para filtrar por columna
    $('input.column_filter').on('keyup click', function () {
      var columnIndex = $(this).parents('tr').attr('data-column');
      tabla_comentarios_estudiantes.column(columnIndex).search($(this).val()).draw();
    });
  
    // Personalizar el número de fila
    tabla_comentarios_estudiantes.on('order.dt search.dt', function () {
      tabla_comentarios_estudiantes.column(0, { search: 'applied', order: 'applied' }).nodes().each(function (cell, i) {
        cell.innerHTML = i + 1;
      });
    }).draw();
  }


  
  $('#tabla_comentarios_estudiantes').on('click', '.comentar', function() {
    var data = tabla_comentarios_estudiantes.row($(this).parents('tr')).data();
    if (tabla_comentarios_estudiantes.row(this).child.isShown()) {
        var data = tabla_comentarios_estudiantes.row(this).data();
    }

    $("#modal_responder").modal({
        backdrop: 'static',
        keyboard: false
    })

    $("#modal_responder").modal('show');

    $("#id_coemntario").val(data.ID).hide();
   
    $("#txt_resp").val(data.respuesta);
    $("#lbl_ver").html(data.comentario);
    
     // Verificar si data.respuesta está vacío o no
     var respuesta = data.respuesta ? data.respuesta : "NO RESPONDIDO";
     $("#lbl_resp").html(respuesta);
    $("#lbl_estudiante").html(data.estudiante);
    $("#lbl_docente").html(data.docente);
    $("#lbl_titulo").html(data.asunto);

 // Asignar la ruta de la imagen al atributo src del elemento img
 var rutaImagen = "../" + data.fotoestudiante; // Aquí asumo que el campo se llama "dotoestudiante"
 $("#imagenestudiante").attr("src", rutaImagen);

 var rutaImagen = "../" + data.fotodocente; // Aquí asumo que el campo se llama "dotoestudiante"
 $("#imagendocente").attr("src", rutaImagen);
  


});



function responder(){
  var id_comentario = $("#id_coemntario").val();
  var respuesta = $("#txt_enviar_resp").val();

  if (id_comentario == null) {
      Swal.fire("Mensaje De Error", "Datos Vacios","error");
  }

  if (respuesta.length == 0) {
      return Swal.fire("Mensaje De Advertencia","Llene los datos vacios","warning");
  }
  $.ajax({
      url:"../controlador/talleres/controlador_resp_comentario_docente.php",
      type:"POST",
      data:{
          id_comentario:id_comentario,
          respuesta:respuesta
      }
  }).done(function(resp){
      if (resp > 0) {
          Swal.fire("Mensaje De Confirmación","Respuesta registrada Correctamente","success").then((value) => {
           $("#modal_responder").modal('hide');
           tabla_comentarios_estudiantes.ajax.reload();

       });

      }
      else{
          Swal.fire("Mensaje de Error","no se pudo registrar el comentario", "error");

      }
  })

}