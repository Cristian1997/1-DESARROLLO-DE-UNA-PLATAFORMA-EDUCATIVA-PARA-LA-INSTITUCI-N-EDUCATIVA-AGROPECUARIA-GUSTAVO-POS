 var tabla_Grupo;
 function listar_grupo(id_grado,id_asignatura,id_usuario_doc) {

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

function datos() {
    var id_grado = $("#cbm_grupo").val();
    var id_asignatura = $("#cbm_grupo").val();
    var id_usuario_doc = $("#id_docente_verifity").val();
    listar_grupo(id_grado, id_asignatura,id_usuario_doc);

    // Limpia el contenido actual antes de mostrar los nuevos datos
    $("#lista_grupos").empty();

    // Variable para almacenar la cantidad total de estudiantes
    var totalEstudiantes = 0;

    // Utilizamos la función drawCallback de DataTables para asegurar que la tabla se haya dibujado completamente
    tabla_Grupos.on('draw.dt', function() {
        // Obtener los datos de la tabla después de que se haya dibujado completamente
        var data = tabla_Grupo.rows().data();

        // Verificar si hay datos para mostrar
        if (data.length > 0) {
            var listaGruposHTML = '<div class="box-body no-padding"><ul class="users-list clearfix">';

            for (var i = 0; i < data.length; i++) {
                listaGruposHTML += '<li>' +
                    '<img src="../' + data[i].foto + '" alt="User Image" style="width: 50px; height: 50px;">' +
                    '<a class="users-list-name" href="#">' + data[i].Estudiante + '</a>' +
                    '<span class="users-list-date">' + data[i].nombre + '</span>' +
                    '<span class="users-list-date">' + data[i].aula + '</span>' +
                    '</li>';

                // Sumar 1 al total de estudiantes por cada iteración del bucle
                totalEstudiantes++;
            }

            listaGruposHTML += '</ul></div>';

            // Agrega la lista de grupos al contenedor con el id "lista_grupos"
            $("#lista_grupos").html(listaGruposHTML);

            // Mostrar el total de estudiantes en el span con el id "txt_contador"
            $("#txt_contador").text(totalEstudiantes);
        }
    }).draw(); // Asegura que la tabla se vuelva a dibujar para que se ejecute la función drawCallback
}













