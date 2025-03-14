 var tabla_calificaciones;
 function listar_calificaciones(id_grado,id_asignatura) {
   var id_usuario_doc = $("#txtidusuario").val();
   var id_grupo = $("#cbm_grupo").val();
   var id_docente = $("#id_docente_verifity").val();
   if (id_grado == null || id_asignatura == null || id_grupo == null || id_docente== null) {
    id_grado = 1;
    id_asignatura = 1;
    id_asignatura = 1;
    id_grupo = 1;
    id_docente = 0;
}
tabla_calificaciones = $("#tabla_calificaciones").DataTable({
    "ordering": false,
    "bLengthChange": true,
    "searching": { "regex": false },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    "pageLength": 10,
    "destroy": true,
    "async": false,
    "processing": true,
    "ajax": {
        "url": "../controlador/calificaciones/controlador_calificaciones_listar.php",
        type: 'POST',
        data:{
            id_usuario_doc:id_usuario_doc,
            id_asignatura:id_asignatura,
            id_grado:id_grado,
            id_grupo:id_grupo,
            id_docente:id_docente
        }
    },

    "columns": [
        { "defaultContent": "" },
        { "data": "Estudiante" },
        { "data": "primera_nota" },
        { "data": "segunda_nota" },
        { "data": "tercera_nota" }, 
        { "data": "cuarta_nota" }, 
        { "data": "nota_def" },

        {"data": "nota_def",
        render: function (data, type, row) {
            if (data >= 3.0) {
               return "<span class='label label-success'>APROBADO</span>";
           } else {
            return "<span class='label label-danger'>REPROBADO</span>";
        }
    }
},

{ "defaultContent": "<button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fa fa-edit'></i></button>" }
],

    "language": idioma_espanol,
    select: true
});
document.getElementById("tabla_calificaciones_filter").style.display = "none";
$('input.global_filter').on('keyup click', function () {
    filterGlobal();
});
$('input.column_filter').on('keyup click', function () {
    filterColumn($(this).parents('tr').attr('data-column'));
});
tabla_calificaciones.on('draw.dt', function() {
    var PageInfo = $('#tabla_calificaciones').DataTable().page.info();
    tabla_calificaciones.column(0, {
        page: 'current'
    }).nodes().each(function(cell, i) {
        cell.innerHTML = i + 1 + PageInfo.start;
    });
});

}
function cargar_registros() {
    $("#modal_registro").modal({ backdrop: 'static', keyboard: false })
    $("#modal_registro").modal('show');
    $("#cbm_verificar_estudiantes").hide();
}
$('#tabla_calificaciones').on('click', '.editar', function () {
    var  data =  tabla_calificaciones.row($(this).parents('tr')).data();
    if ( tabla_calificaciones.row(this).child.isShown()) {
        var data =  tabla_calificaciones.row(this).data();
    }

    $("#modal_editar").modal({ backdrop: 'static', keyboard: false })
    $("#modal_editar").modal('show');
    $("#id_calificaciones").val(data.ID).hide();
    $("#txt_nota1_editar").val(data.primera_nota);
    $("#txt_nota2_editar").val(data.segunda_nota);
    $("#txt_nota3_editar").val(data.tercera_nota);
    $("#txt_nota4_editar").val(data.cuarta_nota);
    $("#txt_def_editar").val(data.nota_def).hide();

})

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



function Editar_calificaciones(){

    var id_calificaciones =  $("#id_calificaciones").val();
    var nota_1 = $("#txt_nota1_editar").val();
    var nota_2 = $("#txt_nota2_editar").val();
    var nota_3 = $("#txt_nota3_editar").val();
    var nota_4 = $("#txt_nota4_editar").val();
    nota1 = parseFloat(nota_1);
    nota2 = parseFloat(nota_2);
    nota3 = parseFloat(nota_3);
    nota4 = parseFloat(nota_4);
    if (id_calificaciones == null ) {
        return Swal.fire("Mensaje De Error","Datos Vacios","error");
    }


    $.ajax({
        "url": "../controlador/calificaciones/controlador_calificaciones_modificar.php",
        type: 'POST',
        data: {
            id_calificaciones:id_calificaciones,
            nota_1:nota1,
            nota_2:nota2,
            nota_3:nota3,
            nota_4:nota4

        }

    }).done(function (resp) {
        if (resp > 0) {
            if (resp == 1) {
              
                Swal.fire("Mensaje De Confirmacion", "Nota Actualizada correctamente", "success")
                .then((value) => {
                    $("#modal_editar").modal('hide');
                    $("#modal_editar_admin").modal('hide');
                  
                    tabla_calificaciones_admin.ajax.reload();
                    tabla_calificaciones.ajax.reload();
                  
                });
            } 
        } else {
            Swal.fire("Mensaje De Error", "Lo sentimos, no se realizar la actualización", "error");
        }
    })

}

function datos(){
    var id_grado = $("#cbm_grado").val();
    var id_asignatura = $("#cbm_asignatura").val();
    listar_calificaciones(id_grado,id_asignatura);
    listar_combo_estudiante(id_grado,id_asignatura);

}


// session del estudiantes 

var tabla_notas;
function listar_notas(id_grupo) {
   var id_usuario_es = $("#txtidusuario").val();
   var id_docente = $("#id_docente_verifity_es").val();
   if (id_grupo == null || id_docente == null) {
    id_grupo = 1;
    id_docente = 0;
   }
   tabla_notas = $("#tabla_notas").DataTable({
    "ordering": false,
    "bLengthChange": true,
    "searching": { "regex": false },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    "pageLength": 10,
    "destroy": true,
    "async": false,
    "processing": true,
    "ajax": {
        "url": "../controlador/calificaciones/controlador_notas_listar.php",
        type: 'POST',
        data:{
            id_usuario_es:id_usuario_es,
            id_grupo:id_grupo,
            id_docente:id_docente
        }
    },

    "columns": [
        { "defaultContent": "" },
        { "data": "primera_nota" },
        { "data": "segunda_nota" },
        { "data": "tercera_nota" }, 
        { "data": "cuarta_nota" }, 
        { "data": "nota_def" },

        {"data": "nota_def",
        render: function (data, type, row) {
            if (data >= 3.0) {
               return "<span class='label label-success'>APROBADO</span>";
           } else {
            return "<span class='label label-danger'>REPROBADO</span>";
        }
    }
}


],

    "language": idioma_espanol,
    select: true
});
   document.getElementById("tabla_notas_filter").style.display = "none";
   $('input.global_filter').on('keyup click', function () {
    filterGlobal();
});
   $('input.column_filter').on('keyup click', function () {
    filterColumn($(this).parents('tr').attr('data-column'));
});
   tabla_notas.on('draw.dt', function() {
    var PageInfo = $('#tabla_notas').DataTable().page.info();
    tabla_notas.column(0, {
        page: 'current'
    }).nodes().each(function(cell, i) {
        cell.innerHTML = i + 1 + PageInfo.start;
    });
});

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



function listar_combo_materia() {
    var id = $("#txtidusuario").val();

    $.ajax({
        url: "../controlador/calificaciones/controlador_combo_materia_listar.php",
        type: "POST",
        data: { id: id }
    }).done(function(resp) {
        let data = JSON.parse(resp);
        console.log(data); 
        var cadena = "";
        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                cadena += "<option value='" + data[i][0] + "' data-docente='" + data[i][4] + "'>" +
                          "Asignatura: " + data[i][1] + " -- " + "Profesor: " + data[i][2] + "</option>";
            }
            $("#cbm_grupo").html(cadena);

            var docente = $("#cbm_grupo option:selected").data("docente");
            $("#id_docente_verifity_es").val(docente);
            console.log("Initial input value:", docente); 

            id = $("#cbm_grupo").val();
            listar_combo_grado(id);
            listar_combo_asignatura(id);

            if (id.length != '') {
                $("#cbm_grupo_listar").val(id).trigger("change");
            }
        } else {
            cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
            $("#cbm_grupo").html(cadena);
            $("#id_docente_verifity_es").val(''); 
        }
    });

    $("#cbm_grupo").change(function() {
        var docente = $("#cbm_grupo option:selected").data("docente");
        console.log("Selected docente:", docente); 
        $("#id_docente_verifity_es").val(docente);
        console.log("Updated input value:", $("#id_docente_verifity_es").val()); 
    });
}



function listar(){
    var id_grupo = $("#cbm_grupo").val();
    listar_notas(id_grupo);
}

// session del administrador

var tabla_calificaciones_admin;
 function listar_calificaciones_admin() {
}
tabla_calificaciones_admin = $("#tabla_calificaciones_admin").DataTable({
    "ordering": false,
    "bLengthChange": true,
    "searching": { "regex": false },
    "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
    "pageLength": 10,
    "destroy": true,
    "async": false,
    "processing": true,
    "ajax": {
        "url": "../controlador/calificaciones/controlador_notas_admin.php",
        type: 'POST',
    },
    "order": [[1, 'asc']],
    "columns": [
        { "defaultContent": "" },
        { "data": "Estudiante" },
        { "data": "Docente" },
        { "data": "nombre" },
        { "data": "aula" },
        { "data": "nota_1" },
        { "data": "nota_2" },
        { "data": "nota_3" }, 
        { "data": "nota_4" }, 
        { "data": "nota_def" },

        {"data": "nota_def",
        render: function (data, type, row) {
            if (data >= 3.0) {
               return "<span class='label label-success'>APROBADO</span>";
           } else {
            return "<span class='label label-danger'>REPROBADO</span>";
        }
    }
},

{ "defaultContent": "<button style='font-size:13px;' type='button' class='editar btn btn-primary'><i class='fa fa-edit'></i></button>" }
],

    "language": idioma_espanol,
    select: true
});
document.getElementById("tabla_calificaciones_admin_filter").style.display = "none";
$('input.global_filter').on('keyup click', function () {
    filterGlobal();
});
$('input.column_filter').on('keyup click', function () {
    filterColumn($(this).parents('tr').attr('data-column'));
});
function filterGlobal() {
    $('#tabla_calificaciones_admin').DataTable().search(
        $('#global_filter').val()
        ).draw();
}
tabla_calificaciones_admin.on('draw.dt', function() {
    var PageInfo = $('#tabla_calificaciones_admin').DataTable().page.info();
    tabla_calificaciones_admin.column(0, {
        page: 'current'
    }).nodes().each(function(cell, i) {
        cell.innerHTML = i + 1 + PageInfo.start;
    });
});

$('#tabla_calificaciones_admin').on('click', '.editar', function () {
    var  data =  tabla_calificaciones_admin.row($(this).parents('tr')).data();
    if ( tabla_calificaciones_admin.row(this).child.isShown()) {
        var data =  tabla_calificaciones_admin.row(this).data();
    }

    $("#modal_editar_admin").modal({ backdrop: 'static', keyboard: false })
    $("#modal_editar_admin").modal('show');
    $("#id_calificaciones").val(data.ID).hide();
    $("#txt_nota1_editar").val(data.nota_1);
    $("#txt_nota2_editar").val(data.nota_2);
    $("#txt_nota3_editar").val(data.nota_3);
    $("#txt_nota4_editar").val(data.nota_4);
    $("#txt_def_editar").val(data.nota_def).hide();

})



function imprimir_nota_estudiante() {
    var data = tabla_notas.rows().data().toArray();

    $.ajax({
        url: '../controlador/calificaciones/mpdf/reporte/reporte_nota_estudiante.php',
        method: 'POST',
        data: { data: JSON.stringify(data) },
        responseType: 'arraybuffer',
        success: function(response) {
            var pdfData = base64ToArrayBuffer(response);
            downloadPDF(pdfData, 'reporte_notas_estudiante.pdf');
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}



function imprimir_nota() {
    var data = tabla_calificaciones.rows().data().toArray();

    $.ajax({
        url: '../controlador/calificaciones/mpdf/reporte/reporte_nota_docente.php',
        method: 'POST',
        data: { data: JSON.stringify(data) },
        responseType: 'arraybuffer',
        success: function(response) {
            var pdfData = base64ToArrayBuffer(response);
            downloadPDF(pdfData, 'reporte_notas.pdf');
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}

// Función para convertir base64 a ArrayBuffer
function base64ToArrayBuffer(base64) {
    var binaryString = window.atob(base64);
    var binaryLen = binaryString.length;
    var bytes = new Uint8Array(binaryLen);
    for (var i = 0; i < binaryLen; i++) {
        var ascii = binaryString.charCodeAt(i);
        bytes[i] = ascii;
    }
    return bytes.buffer;
}

// Función para descargar el PDF
function downloadPDF(pdfData, fileName) {
    var blob = new Blob([pdfData], { type: 'application/pdf' });
    if (window.navigator && window.navigator.msSaveOrOpenBlob) {
       
        window.navigator.msSaveOrOpenBlob(blob, fileName);
    } else {
        var url = window.URL.createObjectURL(blob);
        var a = document.createElement('a');
        a.href = url;
        a.download = fileName;
        document.body.appendChild(a);
        a.click();
        window.URL.revokeObjectURL(url);
        document.body.removeChild(a);
    }
}

function imprimir_nota_E() {
    var data = tabla_calificaciones.rows().data().toArray();

    $.ajax({
        url: '../controlador/calificaciones/PhpSpreadsheet/reporte/reporte_nota_docente_excel.php',
        method: 'POST',
        data: { data: JSON.stringify(data) },
        xhrFields: {
            responseType: 'blob'
        },
        success: function(response) {
            var blob = new Blob([response], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
            var url = window.URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = 'reporte_notas.xlsx';
            document.body.appendChild(a);
            a.click();
            window.URL.revokeObjectURL(url);
            document.body.removeChild(a);
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}
