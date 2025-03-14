
$(document).ready(function(){
    TraerDatosUsuario();
    TraerNotificaciones();
    function TraerNotificaciones(){
      var id = $("#txtidusuario").val();

      $.ajax({
       url:"../controlador/talleres/controlador_traer_notificaciones.php",
       type:"POST",
       data:{
         id:id 
       }
     }).done(function(resp){

       let data = JSON.parse(resp);

       var llenaData = "";
       var contador = 0;
       if (data.length > 0) {

         for (var i = 0 ; i < data.length; i++) {


          llenaData += ' <li>'+'<a href="#">'+
          '<div class="pull-left">'+
          '<img src="'+ '../controlador/talleres/archivo/taller.png' +'" class="img-circle" alt="User Image" style="width: 50px;">'+
          '</div>'+'<h4>Taller:&nbsp;'+data[i][0]+'<small><b><i class="fa fa-clock-o"></i>&nbsp;Fecha Limite: '+data[i][1]+'</b></small>'+
          '</h4>'+'<p> Grado:&nbsp; '+data[i][4]+'</p>'+'<p> Estado:&nbsp; '+data[i][5]+' </p></a>'+
          '</li> ' ;

        }
        for (var j = 0 ; j < data.length; j++) {
         if (data[j][5] == "ACTIVO") {
          contador++;
          document.getElementById('lbl_contador').innerHTML = contador; 
          document.getElementById('lbl_contador1').innerHTML = "Tienes  "+ contador  + "  Talleres Pendientes";
        } else {
          document.getElementById('lbl_contador').innerHTML = 0; 
          document.getElementById('lbl_contador1').innerHTML = "Tienes  "+ 0  + "  Talleres Pendientes";
        }

      }



      document.getElementById('div_cuerpo').innerHTML = llenaData;


    } else{
     cadena += "<option value=''>NO SE ENCONTRARON REGISTROS</option>";
     $("#cbm_grupos_comentarios").html(cadena);

   }


 })
   } 
   listar_combo_verificar_docentes();
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
        TraerNotificacionescomentarios(data[i][0]);
        comentarios_estudiantes(data[i][0]);



      }




    }
  })
  }
  listar_combo_verificar_estudiantes();
  function listar_combo_verificar_estudiantes(){
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

      comentarios_docentes(data[i][0]);



    }




  }
})
}

TraerNotificacionescomentarios();
function TraerNotificacionescomentarios(id){
  var id_usuario = $("#txtidusuario").val();
  $.ajax({
   url:"../controlador/talleres/controlador_traer_notificaciones_talleres.php",
   type:"POST",
   data:{
     id_usuario:id_usuario 
   }
 }).done(function(resp){

   let data = JSON.parse(resp);

   var llenaData = "";
   var contador = 0;
   if (data.length > 0) {

     for (var i = 0 ; i < data.length; i++) {

       llenaData += '<li>'+'<a href="#">'+
       '<div class="pull-left">'+
       '<img src="'+ '../controlador/talleres/archivo/taller.png' +'" class="img-circle" alt="User Image" style="width: 50px;">'+
       '</div>'+'<h4>Taller:&nbsp;'+data[i][0]+'<small><b><i class="fa fa-clock-o"></i>&nbsp;Fecha Limite: '+data[i][1]+'</b></small>'+
       '</h4>'+'<p>Docente:&nbsp;'+data[i][2]+' <br> Grado:&nbsp; '+data[i][4]+'</p>'+'<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estado:&nbsp; <b> '+data[i][5]+' <b>--</b> '+data[i][6]+'</b> </p></a>'+
       '</li>' ;}
       for (var j = 0 ; j < data.length; j++) {
         if (data[j][6] == "NO ENTREGADO") {
          contador++;
          document.getElementById('lbl_contador2').innerHTML = contador;
          document.getElementById('lbl_contador3').innerHTML = "Tienes  "+ contador  + " Talleres Pendientes";
        }

      }
      document.getElementById('div_cuerpo1').innerHTML = llenaData;


    } 


  })
}

comentarios_estudiantes();
function  comentarios_estudiantes(id_docente){
  var id =  $("#txtidusuario").val();


  $.ajax({
   url:"../controlador/talleres/controlador_estudiante_comentarios_listar.php",
   type:"POST",
   data:{
     id_usuario:id,
     id_docente:id_docente
   }
 }).done(function(resp){

   let data = JSON.parse(resp);

   var llenaData = "";
   var datos = 0;
   var idusu = 2;
   if (data.length > 0) {

     for (var i = 0 ; i < data.length; i++) {

       llenaData += '<li>'+'<a href="#">'+
       '<div class="pull-left">'+
       '<img src="'+ '../controlador/talleres/archivo/comentarios.png' +'" class="img-circle" alt="User Image" style="width: 50px;">'+
       '</div>'+'<h4>Taller:&nbsp;'+data[i][1]+'<small><i class="fa fa-clock-o"></i>&nbsp;Fecha Comentario: '+data[i][6]+'</small>'+
       '</h4>'+'<p>ESTUDIANTE:&nbsp;'+data[i][2]+' <br></p>'+'<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COMENTARIO:&nbsp; '+data[i][5]+' </p></a>'+
       '</li>' ;


     }  

     for (var j = 0; j < data.length; j++) {
       if (data[j][5] == "NO RESPONDIDO"  ) {
        datos++;
        document.getElementById('lbl_contador4').innerHTML = datos;
        document.getElementById('lbl_contador5').innerHTML = "Tienes  "+ datos  + " Comentarios Pendientes";
        
      }


      

    }


    document.getElementById('div_cuerpo2').innerHTML = llenaData;


  }  




})
} 
comentarios_docentes();
function  comentarios_docentes(id_estudiante){
  var id =  $("#txtidusuario").val();


  $.ajax({
   url:"../controlador/talleres/controlador_docente_comentarios_listar.php",
   type:"POST",
   data:{
     id_usuario:id,
     id_estudiante:id
   }
 }).done(function(resp){

   let data = JSON.parse(resp);

   var llenaData = "";
   var datos = 0;
   if (data.length > 0) {

     for (var i = 0 ; i < data.length; i++) {

       llenaData += '<li>'+'<a href="#">'+
       '<div class="pull-left">'+
       '<img src="'+ '../controlador/talleres/archivo/comentarios.png' +'" class="img-circle" alt="User Image" style="width: 50px;">'+
       '</div>'+'<h4>Taller:&nbsp;'+data[i][1]+'<small><i class="fa fa-clock-o"></i>&nbsp;Fecha Comentario: '+data[i][6]+'</small>'+
       '</h4>'+'<p>DOCENTE:&nbsp;'+data[i][2]+' <br></p>'+'<p> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;COMENTARIO:&nbsp; '+data[i][5]+' </p></a>'+
       '</li>' ;
       

     }  

     for (var j = 0; j < data.length; j++) {
       if (data[j][5] == "NO RESPONDIDO"  ) {
        datos++;
        document.getElementById('lbl_contador6').innerHTML = datos;
        document.getElementById('lbl_contador7').innerHTML = "Tienes  "+ datos  + " Comentarios Pendientes";
      }


      

    }


    document.getElementById('div_cuerpo3').innerHTML = llenaData;


  }  

})
}
});

$(document).ready(function(){

  TraerNotificacionesMensajes();

  function TraerNotificacionesMensajes(){
      var id_usuario_es = $("#txtidusuario").val();
      console.log("ID de usuario actual:", id_usuario_es);

      $.ajax({
          url: "../controlador/chat/controlador_listar_chat_notificaciones.php",
          type: "POST",
          data: {
              id_usuario_es: id_usuario_es
          }
      }).done(function(resp){
          let data = JSON.parse(resp);

          var llenaData = "";
          var contador = 0;

          if (data.data && data.data.length > 0) {
              data.data.forEach(function(comentario) {
                  // Si el estado es NO ABIERTO, contar y mostrar
                  if (comentario.Estado == "NO VISTO") {
                      contador++;
                  }

                  var comentarioTruncado = comentario.Comentario.length > 45 ? comentario.Comentario.substring(0, 45) + '...' : comentario.Comentario;
                  var fechaFormateada = formatearFecha(comentario.Fecha);

                  var textoArchivo = obtenerTextoArchivo(comentario.archivo);

                  llenaData += '<li>'+
                      '<a href="#">'+
                          '<div class="pull-left">'+
                              '<img src="../'+ comentario.foto +'" class="img-circle" alt="User Image"  style="width: 40px; height: 40px; border-radius: 50%;">'+
                          '</div>'+
                          '<h4>'+ comentario.nombre +
                              '<small><b><i class="fa fa-clock-o"></i>&nbsp;'  + fechaFormateada +'</b></small>'+
                              '<span class="pull-right-container">'+
                              '<br>'+
                                  '<small class="label pull-right bg-green">'+ comentario.Estado +'</small>'+
                              '</span>'+
                          '</h4>'+
                          '<p>'+ comentarioTruncado +'</p>';
                  if (textoArchivo !== "") {
                      llenaData += '<p>'+ textoArchivo +'</p>';
                  }
                  llenaData += '</a>'+
                  '</li>';
              });
          }

          // Mostrar el contador y la lista de mensajes pendientes
          $('#lbl_contador_mensajes').text(contador);
          $('#div_cuerpo_mensajes').html(llenaData);
          $('#lbl_contador_total_mensajes').text("Tienes " + contador + " mensajes pendientes");

          // Llamar a la función nuevamente después de 2 segundos
          setTimeout(TraerNotificacionesMensajes, 2000);

        });
  }

  // Función para obtener el texto del tipo de archivo
  function obtenerTextoArchivo(archivo) {
      if (archivo) {
          var extension = archivo.split('.').pop().toLowerCase();
          if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
              return 'IMAGEN';
          } else if (['pdf', 'doc', 'docx', 'xls', 'xlsx', 'ppt', 'pptx'].includes(extension)) {
              return 'DOCUMENTO';
          } else {
              return '';
          }
      } else {
          return '';
      }
  }
});


function formatearFecha(fecha) {
  var fechaObjeto = new Date(fecha);

  var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

  var dia = fechaObjeto.getDate();
  var mes = meses[fechaObjeto.getMonth()];
  var año = fechaObjeto.getFullYear(); 
  var hora = fechaObjeto.getHours();
  var minutos = fechaObjeto.getMinutes();
  var ampm = hora >= 12 ? 'pm' : 'am';

  // Convertir hora a formato de 12 horas
  hora = hora % 12;
  hora = hora ? hora : 12; 

  minutos = minutos < 10 ? '0' + minutos : minutos;

  var fechaFormateada = dia + ' ' + mes + ' ' + año + ' ' + hora + ':' + minutos + ' ' + ampm;

  return fechaFormateada;
}


TraerNotificacionesforoes();

function TraerNotificacionesforoes() {
    var id_usuario = $("#txtidusuario").val();
    $.ajax({
        url: "../controlador/foro/controlador_traer_notificaciones_foro_estudiante.php",
        type: "POST",
        data: {
            id_usuario: id_usuario
        }
    }).done(function(resp) {

        let data = JSON.parse(resp);
        var contador = 0;
        var listaHTML = ""; 

        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                listaHTML += generarElementoLista(data[i]);

                if (data[i][1] == "ACTIVO") {
                    contador++;
                }
            }
            document.getElementById('lbl_contador_foro_n').innerHTML = contador;
            document.getElementById('lbl_contador_foro').innerHTML = "Tienes " + contador + " Foros Pendientes";
            document.getElementById('div_cuerpo_foro').innerHTML = listaHTML; 
        }
    });
}

function generarElementoLista(dataItem) {
  var maxLength = 25;
  var titulo = dataItem[0].length > maxLength ? dataItem[0].substring(0, maxLength) + "..." : dataItem[0];
  return '<li>' +
      '<a href="#">' +
      '<div class="pull-left">' +
      '<img src="../controlador/talleres/archivo/foro.png" alt="User Image" style="width: 50px;">' +
      '</div>' +
      '<h4>Foro:&nbsp;' + titulo + '<small><b><i class="fa fa-clock-o"></i>&nbsp;Fecha Limite: ' + dataItem[2] + '</b></small>' +
      '</h4>' +
      '<p>Docente:&nbsp;' + dataItem[3] + ' <br> Grado:&nbsp; ' + dataItem[4] + '</p>' +
      '<p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Estado:&nbsp;<b>' + dataItem[1] + '</b></p>' +
      '</a>' +
      '</li>';
}


TraerNotificacionesforodoc();

function TraerNotificacionesforodoc() {
    var id_usuario = $("#txtidusuario").val();
    $.ajax({
        url: "../controlador/foro/controlador_traer_notificaciones_foro_docente.php",
        type: "POST",
        data: {
            id_usuario: id_usuario
        }
    }).done(function(resp) {

        let data = JSON.parse(resp);
        var contador = 0;
        var listaHTML = ""; 

        if (data.length > 0) {
            for (var i = 0; i < data.length; i++) {
                listaHTML += generarElementoListaDocente(data[i]);

                if (data[i][1] == "ACTIVO") {
                    contador++;
                }
            }
            document.getElementById('lbl_contador_foro_n_doc').innerHTML = contador;
            document.getElementById('lbl_contador_foro_doc').innerHTML = "Tienes " + contador + " Foros Pendientes";
            document.getElementById('div_cuerpo_foro_doc').innerHTML = listaHTML; 
        }
    });
}

function generarElementoListaDocente(dataItem) {
    var maxLength = 25;
    var titulo = dataItem[0].length > maxLength ? dataItem[0].substring(0, maxLength) + "..." : dataItem[0];
    return '<li>' +
        '<a href="#">' +
        '<div class="pull-left">' +
        '<img src="../controlador/talleres/archivo/foro.png" alt="User Image" style="width: 50px;">' +
        '</div>' +
        '<h4>Foro:&nbsp;' + titulo + '<small><b><i class="fa fa-clock-o"></i>&nbsp;Fecha Limite: ' + dataItem[2] + '</b></small>' +
        '</h4>' +
        '<p> Grado:&nbsp; ' + dataItem[3] + '</p>' +
        '<p>Estado:&nbsp;<b>' + dataItem[1] + '</b></p>' +
        '</a>' +
        '</li>';
}
