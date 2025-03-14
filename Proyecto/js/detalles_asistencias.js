var tabla_detalles_asistencias;
function listar_detalles_asistencias(id_grado, id_asignatura, id_estudiantes) {
    var id_usuario_doc = $("#txtidusuario").val();
    if (id_grado == null || id_asignatura == null || id_estudiantes == null) {
        id_grado = 1;
        id_asignatura = 1;
        id_estudiantes = 1;
    }
    tabla_detalles_asistencias = $("#tabla_detalles_asistencias").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "processing": false, // Deshabilitar el mensaje de "Procesando..."
        "ajax": {
            "url": "../controlador/asistencias/controlador_detalles_asistencias_listar.php",
            type: 'POST',
            data: {
                id_usuario_doc: id_usuario_doc,
                id_estudiantes: id_estudiantes,
                id_asignatura: id_asignatura,
                id_grado: id_grado
            },
            dataSrc: function (json) {
                var totalAbsences = 0;
                json.data.forEach(function (row) {
                    totalAbsences += parseInt(row.Total_No_Asistencias);
                });
                document.getElementById("txtregistroINA").innerHTML = totalAbsences;
                return json.data;
            }
        },
        "columns": [
            { "defaultContent": "" },
            { "data": "Estudiante" },
            {
                "data": "asistencia",
                render: function (data, type, row) {
                    if (data == 'ASISTIÓ') {
                        return "<span class='btn btn-success'> " + data + "</span>";
                    } else {
                        return "<span class='btn btn-danger'> " + data + "</span>";
                    }
                }
            },
            { "data": "dia" },
            { "data": "fecha" },
            { "defaultContent": "<button style='font-size:13px; margin-right: 1px;' type='button' class='modal_ver_asistencia btn btn-default' title='Ver asistencias de estudiante' ><i class='fa fa-eye'></i></button>" }
        ],
        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_detalles_asistencias_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });
    tabla_detalles_asistencias.on('draw.dt', function () {
        var PageInfo = $('#tabla_detalles_asistencias').DataTable().page.info();
        tabla_detalles_asistencias.column(0, {
            page: 'current'
        }).nodes().each(function (cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });

    $('#tabla_detalles_asistencias').on('click', '.modal_ver_asistencia', function () {
        var data = tabla_detalles_asistencias.row($(this).parents('tr')).data();
        $("#id_ES").val(data.ID);
        $('#modal_ver_asistencia_estudiante').modal('show');
        listar_tabla_detalles_asistencias_ES();
        TraerDatosContador1();
    });
}





function listar_combo_asignatura(id_asignatura){
  var id = $("#txtidusuario").val();
  if (id_asignatura == null) {
    id_asignatura = 1;
}

$.ajax({
    url:"../controlador/calificaciones/controlador_combo_asignatura_listar.php",
    type:"POST",
    data:{
        id:id,
        id_asignatura:id_asignatura
    }
}).done(function(resp){
    let data = JSON.parse(resp);
    var cadena = "";
    if (data.length > 0) {

        for (var i = 0 ; i < data.length; i++) {
            cadena += "<option value='"+data[i][0]+"'>"+data[i][1]+" </option>" ;  

        }
        $("#cbm_asignatura").html(cadena);


    } else{
        cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
        $("#cbm_asignatura").html(cadena);


    }


})

} 

function listar_combo_grupo(){
    var id = $("#txtidusuario").val();
    $.ajax({
        url: "../controlador/talleres/controlador_combo_grupo_listar.php",
        type: "POST",
        data: { id: id }
    }).done(function(resp){
        let data = JSON.parse(resp);
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "'>" + "Asignatura:  " + data[i][1] + "  --  " + "Grado: " + data[i][2] + " </option>";  
            }
            $("#cbm_grupo").html(cadena);
            id = $("#cbm_grupo").val();
            listar_combo_grado(id);
            listar_combo_asignatura(id);
            
            $("#id_grupo").val(id);
            
            if (id.length != '') {
                $("#cbm_grupo_listar").val(id).trigger("change");
            }
        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_grupo").html(cadena);
        }

        $("#cbm_grupo").on("change", function() {
            var selectedValue = $(this).val();
            $("#id_grupo").val(selectedValue);
        });
    });
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


function listar_combo_estudiantes(id_grado,id_asignatura){
  var id_usuario_doc = $("#txtidusuario").val();
  if (id_grado == null || id_asignatura == null) {
    id_grado = 1;
    id_asignatura = 1;
}
$.ajax({
    url:"../controlador/asistencias/controlador_combo_estudiantes_listar.php",
    type:"POST",
    data:{
      id_usuario_doc:id_usuario_doc,
      id_asignatura:id_asignatura,
      id_grado:id_grado
  }
}).done(function(resp){
    let data = JSON.parse(resp);
    var cadena = "";
    if (data.length > 0) {

        for (var i = 0 ; i < data.length; i++) {
            cadena += "<option value='"+data[i][0]+"'>"+data[i][1]+" </option>" ;  

        }
        $("#cbm_estudiantes").html(cadena);
        



    } else{
        cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
        $("#cbm_estudiantes").html(cadena);

    }


})
}



function datos(){

    var id_grado = $("#cbm_grado").val();
    var id_asignatura = $("#cbm_asignatura").val();
    var id_estudiantes = $("#cbm_estudiantes").val();
    listar_combo_estudiantes(id_grado,id_asignatura);
    listar_detalles_asistencias(id_grado,id_asignatura,id_estudiantes);
    TraerDatosContador(id_grado,id_asignatura);
  
    

}


function TraerDatosContador(id_grado,id_asignatura) {
  var id_usuario_doc = $("#txtidusuario").val();
  if (id_grado == null || id_asignatura == null) {
    id_grado = 1;
    id_asignatura = 1;
}
$.ajax({
    "url": "../controlador/asistencias/controlador_traerdatos_asistencias_generales.php",
    type: 'POST',
    data:{
       id_usuario_doc:id_usuario_doc,
       id_asignatura:id_asignatura,
       id_grado:id_grado
   }
}).done(function (resp) {
    var data = JSON.parse(resp);
    document.getElementById('txtregistro').innerHTML = data[0].asistencias;

})
}
function TraerDatosContador1() {
    var id_ES = $("#id_ES").val();
    var id_grupo = $("#id_grupo").val();
    $.ajax({
      "url": "../controlador/asistencias/controlador_traerdatos_asistencias_especificas.php",
      type: 'POST',
      data: {
        id_ES: id_ES,
        id_grupo: id_grupo
      }
    }).done(function (resp) {
      var data = JSON.parse(resp);
      var totalAsistencias = data[0].Total_No_Asistencias;
      if (totalAsistencias === "(N/A)") {
        totalAsistencias = 0; 
      }
      document.getElementById('txtregistro1').innerHTML = totalAsistencias;
    }).fail(function () {
      document.getElementById('txtregistro1').innerHTML = '0';
    });
  }
  
  

// listar detalles de asistencias 


// lista combo asistencia 
function listar_combo_estudiantes_2(id_grado,id_asignatura){
    var id_usuario_doc = $("#txtidusuario").val();
    if (id_grado == null || id_asignatura == null) {
      id_grado = 1;
      id_asignatura = 1;
  }
  $.ajax({
      url:"../controlador/asistencias/controlador_combo_estudiantes_listar.php",
      type:"POST",
      data:{
        id_usuario_doc:id_usuario_doc,
        id_asignatura:id_asignatura,
        id_grado:id_grado
    }
  }).done(function(resp){
      let data = JSON.parse(resp);
      var cadena = "";
      if (data.length > 0) {
  
          for (var i = 0 ; i < data.length; i++) {
              cadena += "<option value='"+data[i][0]+"'>"+data[i][1]+" </option>" ;  
  
          }
          $("#cbm_estudiantes2").html(cadena);
          
  
  
  
      } else{
          cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
          $("#cbm_estudiantes2").html(cadena);
  
      }
  
  
  })
  }
  
  function listar_combo_grupo_2(){
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
         $("#cbm_grupo2").html(cadena);
         id  =  $("#cbm_grupo2").val();
         listar_combo_grado(id);
         listar_combo_asignatura(id);

         if (id.length != '') {
            $("#cbm_grupo_listar").val(id).trigger("change");


        }
        


    } else{
     cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
     $("#cbm_grupo2").html(cadena);
 }
})
}


// lista combo asistencia 



// LISTAR ASISTEENCIAS ESTUDIANTE

var tabla_detalles_asistencias_ES;
function listar_tabla_detalles_asistencias_ES() {
    var id_ES = $("#id_ES").val();
    var id_curso = $("#id_grupo").val();
    

   tabla_detalles_asistencias_ES = $("#tabla_detalles_asistencias_ES").DataTable({
       "ordering": false,
       "bLengthChange": true,
       "searching": { "regex": false },
       "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
       "pageLength": 10,
       "destroy": true,
       "async": false,
       "processing": true,
       "ajax": {
           "url": "../controlador/asistencias/controlador_detalles_asistencias_listar_ES.php",
           type: 'POST',
           data:{
               id_ES:id_ES,
               id_curso: id_curso
           }
       },

       "columns": [
           { "defaultContent": "" },
           { "data": "Estudiante" },

           {"data": "asistencia",
           render: function (data, type, row) {
               if (data == 'ASISTIÓ') {

                return "<span class='btn btn-success'> "+data+"</span>";

            } else{
               return "<span class='btn btn-danger'> "+data+"</span>";
           }
       }
   }, 

   {"data": "dia"},
   {"data": "fecha"}
   ],

       "language": idioma_espanol,
       select: true
   });
   document.getElementById("tabla_detalles_asistencias_ES_filter").style.display = "none";
   $('input.global_filter').on('keyup click', function () {
       filterGlobal();
   });
   $('input.column_filter').on('keyup click', function () {
       filterColumn($(this).parents('tr').attr('data-column'));
   });
   tabla_detalles_asistencias_ES.on('draw.dt', function() {
       var PageInfo = $('#tabla_detalles_asistencias_ES').DataTable().page.info();
       tabla_detalles_asistencias_ES.column(0, {
           page: 'current'
       }).nodes().each(function(cell, i) {
           cell.innerHTML = i + 1 + PageInfo.start;
       });
   });
}
