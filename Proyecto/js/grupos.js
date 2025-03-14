 var tabla_Grupos;
 function listar_grupos(id_grado,id_asignatura) {
   var id_usuario_doc = $("#txtidusuario").val();
   if (id_grado == null || id_asignatura == null) {
    id_grado = 1;
    id_asignatura = 1;
}
tabla_Grupos = $("#tabla_Grupos").DataTable({
    "ordering": false,
    "bLengthChange": true,
    "searching": { "regex": false },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    "pageLength": 10,
    "destroy": true,
    "async": false,
    "processing": true,
    "ajax": {
        "url": "../controlador/grupos/controlador_grupos_listar.php",
        type: 'POST',
        data:{
            id_usuario_doc:id_usuario_doc,
            id_asignatura:id_asignatura,
            id_grado:id_grado
        }
    },

    "columns": [
        { "defaultContent": "" },
        { "data": "Estudiante" },
        { "data": "nombre" },
        { "data": "aula" }
  
],

    "language": idioma_espanol,
    select: true
});
document.getElementById("tabla_Grupos_filter").style.display = "none";
$('input.global_filter').on('keyup click', function () {
    filterGlobal();
});
$('input.column_filter').on('keyup click', function () {
    filterColumn($(this).parents('tr').attr('data-column'));
});
tabla_Grupos.on('draw.dt', function() {
    var PageInfo = $('#tabla_Grupos').DataTable().page.info();
    tabla_Grupos.column(0, {
        page: 'current'
    }).nodes().each(function(cell, i) {
        cell.innerHTML = i + 1 + PageInfo.start;
    });
});

}


function listar_combo_asignatura(id_grupo){
  var id = $("#txtidusuario").val();
  if (id_grupo == null) {
    id_grupo = 1;
  }
 
  $.ajax({
    url:"../controlador/grupos/controlador_combo_asignatura_listar.php",
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
            $("#id_docente_verifity").val(data[i][0]).hide();
   
   
   
        }
   
   
   
   
    }
   })
   }
   function listar_combo_materia(){
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






function datos() {
    var id_grado = $("#cbm_grado").val();
    var id_asignatura = $("#cbm_asignatura").val();

    listar_grupos(id_grado, id_asignatura);

    $("#lista_grupos").empty();

    var totalEstudiantes = 0;

    tabla_Grupos.on('draw.dt', function() {
        var data = tabla_Grupos.rows().data();

        if (data.length > 0) {
            var listaGruposHTML = '<div class="box-body no-padding"><ul class="users-list clearfix">';

            for (var i = 0; i < data.length; i++) {
                listaGruposHTML += '<li>' +
                    '<img src="../' + data[i].foto + '" alt="User Image" style="width: 50px; height: 50px;">' +
                    '<a class="users-list-name" >' + data[i].Estudiante + '</a>' +
                    '<span class="users-list-date">' + data[i].nombre + '</span>' +
                    '<span class="users-list-date">' + data[i].aula + '</span>' +
                    '</li>';

                totalEstudiantes++;
            }

            listaGruposHTML += '</ul></div>';

            $("#lista_grupos").html(listaGruposHTML);

            $("#txt_contador").text(totalEstudiantes);
        }
    }).draw(); 
}





// estudiante-----------------------------------------------------------------------------------------

     var tabla_Grupo;
     function listar_grupo(id_grado,id_asignatura) {
       
       if (id_grado == null || id_asignatura == null) {
        id_grado = 1;
        id_asignatura = 1;
    }
    tabla_Grupo = $("#tabla_Grupo").DataTable({
        "ordering": false,
        "bLengthChange": true,
        "searching": { "regex": false },
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        "pageLength": 10,
        "destroy": true,
        "async": false,
        "processing": true,
        "ajax": {
            "url": "../controlador/grupos/controlador_grupos_listar_estudiante.php",
            type: 'POST',
            data:{
        
                id_asignatura:id_asignatura,
                id_grado:id_grado
            }
        },
    
        "columns": [
            { "defaultContent": "" },
            { "data": "Estudiante" },
            { "data": "nombre" },
            { "data": "aula" }
      
    ],
    
        "language": idioma_espanol,
        select: true
    });
    document.getElementById("tabla_Grupo_filter").style.display = "none";
    $('input.global_filter').on('keyup click', function () {
        filterGlobal();
    });
    $('input.column_filter').on('keyup click', function () {
        filterColumn($(this).parents('tr').attr('data-column'));
    });
    tabla_Grupo.on('draw.dt', function() {
        var PageInfo = $('#tabla_Grupo').DataTable().page.info();
        tabla_Grupo.column(0, {
            page: 'current'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1 + PageInfo.start;
        });
    });
    
    }
    
    
    
    
    function listar_combo_materia(){
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
    
    
    
    
    function listar() {
        var id_grado = $("#cbm_grado").val();
        var id_asignatura = $("#cbm_grupo").val();

        listar_grupo(id_grado, id_asignatura);
    
        $("#lista_grupos").empty();
    
        var totalEstudiantes = 0;
    
        tabla_Grupo.on('draw.dt', function() {
            var data = tabla_Grupo.rows().data();
    
            if (data.length > 0) {
                var listaGruposHTML = '<div class="box-body no-padding"><ul class="users-list clearfix">';
    
                for (var i = 0; i < data.length; i++) {
                    listaGruposHTML += '<li>' +
                        '<img src="../' + data[i].FotoEstudiante + '" alt="User Image" style="width: 50px; height: 50px;">' +
                        '<a class="users-list-name" >' + data[i].Estudiante + '</a>' +
                        '<span class="users-list-date">' + data[i].nombre + '</span>' +
                        '<span class="users-list-date">' + data[i].aula + '</span>' +
                        '</li>';
    
                    totalEstudiantes++;
                }
    
                listaGruposHTML += '</ul></div>';
    
                $("#lista_grupos").html(listaGruposHTML);
    
                $("#txt_contador").text(totalEstudiantes);

            var fotoDocente = "../" + data[0].FotoDocente; 
            var nombreDocente = data[0].Docente;

            $("#fotodocente").attr("src", fotoDocente);
            $("#lblnombre").text(nombreDocente);

                
            }
        }).draw(); 
    }
