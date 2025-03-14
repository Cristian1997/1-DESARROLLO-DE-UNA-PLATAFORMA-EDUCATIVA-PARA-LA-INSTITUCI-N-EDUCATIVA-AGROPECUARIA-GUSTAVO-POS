
//-------------TABLA CHAT ESTUDIANTES-----------------------
var tabla_chat_estudiantes;
function listar_chat_estudiantes() {
  var id_usuario_es = $("#txtidusuario").val();
 
tabla_chat_estudiantes = $("#tabla_chat_estudiantes").DataTable({
   "ordering": false,
   "bLengthChange": true,
   "searching": { "regex": false },
   "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
   "pageLength": 10,
   "destroy": true,
   "async": false,
   "processing": true,
   "ajax": {
    "url": "../controlador/chat/controlador_chat_estudiantes_listar.php",
    type: 'POST',
    data:{
        id_usuario_es:id_usuario_es
    }
},

"columns": [
   { "defaultContent": "" },
   { 
    "data": "nombre_usuario_principal",
},

{
    "data": null,
    "render": function (data, type, row) {
        return '<img class="img-responsibe img-circle elevation-2" style="width:60px" src="../' + row.foto_usuario_principal + '">' +
               '&nbsp;&nbsp;&nbsp;Inicio un chat con&nbsp;&nbsp;&nbsp;' +
               '<img class="img-responsibe img-circle elevation-2" style="width:60px" src="../' + row.foto_usuario_secundario + '">';
    }
},



{
    "data": "nombre_usuario_secundario",
},
 


{ "defaultContent": "<button style='font-size:13px;' type='button' title='Haz Un Comentario Aqui!' class='abrir_chat btn btn-primary'><i class='fa fa-commenting-o'></i></button>" 
}
],

"language": idioma_espanol,
select: true
});
document.getElementById("tabla_chat_estudiantes_filter").style.display = "none";

$('input#global_filter').on('keyup', function () {
    filterGlobal($(this).val()); 
});

// Función para filtrar busqueda
function filterGlobal(value) {
    tabla_chat_estudiantes.search(value).draw(); 
}

tabla_chat_estudiantes.on('draw.dt', function() {
   var PageInfo = $('#tabla_chat_estudiantes').DataTable().page.info();
   tabla_chat_estudiantes.column(0, {
       page: 'current'
   }).nodes().each(function(cell, i) {
       cell.innerHTML = i + 1 + PageInfo.start;
   });
});

}

//-------------------modales-----------------
function nuevo_chat_estudiantes() {
    $("#modal_nuevo_chat_estudiantes").modal({ backdrop: 'static', keyboard: false })
    $("#modal_nuevo_chat_estudiantes").modal('show');
    listar_integrantes_salon_estudiantes();
}

$(document).ready(function() {
    function archivo_documento() {
        $("#modal_archivo_documento").modal({ backdrop: 'static', keyboard: false });
        $("#modal_archivo_documento").modal('show');
    }

    $("#elegir_documento").click(function() {
        archivo_documento();
    });
  
});



$(document).ready(function() {
    function archivo_imagen() {
        $("#modal_archivo_imagen").modal({ backdrop: 'static', keyboard: false });
        $("#modal_archivo_imagen").modal('show');
    }
     $("#elegir_imagen").click(function() {
        archivo_imagen();
    });
});

function previewImage() {
    var preview = document.getElementById('imagen_previa');
    var file = document.getElementById('txt_imagen_subir').files[0];
    var reader = new FileReader();

    reader.onloadend = function() {
        preview.src = reader.result;
        preview.style.display = 'block'; 
    }

    if (file) {
        reader.readAsDataURL(file); 
    } else {
        preview.src = ''; 
        preview.style.display = 'none'; 
    }
}


function nuevo_chat_docentes() {
    $("#modal_nuevo_chat_docentes").modal({ backdrop: 'static', keyboard: false })
    $("#modal_nuevo_chat_docentes").modal('show');
    listar_integrantes_salon_docentes();
}

$(document).ready(function() {
    $(document).on('click', '.abrir_imagen', function() {
       
        var imageUrl = $(this).closest('.attachment').find('img').attr('src');
        
      
        $('#modal_archivo_imagen_ver .modal-body').html('<img src="' + imageUrl + '" style="max-width: 100%; height: auto;">');
        
  
        $("#modal_archivo_imagen_ver").modal({ backdrop: 'static', keyboard: false });
        $("#modal_archivo_imagen_ver").modal('show');
    });
});


//------------registros-----------------------------


function actualizarVistaChat() {
    listar_chat_directo(); 
}

setInterval(actualizarVistaChat, 3000 );

function responder_chat(){
    var comentario = $("#txt_comentario").val();
    var id_chat = $("#id_chat").val();
    var id_usuario = $("#txtidusuario").val();


  if (!id_chat || !comentario || !id_usuario) {
    Swal.fire("Mensaje De Error", "Seleccione un chat y escriba un mensaje", "warning");
    return; 
}
 

    $.ajax({
        url:"../controlador/chat/controlador_responder_chat.php",
        type:"POST",
        data:{
            comentario:comentario,
            id_chat: id_chat,
            id_usuario:id_usuario
        }
    }).done(function(resp){
        if (resp > 0) {
            listar_chat_directo();
            $("#txt_comentario").val("");
        }
        else{
            Swal.fire("Mensaje de Error","no se pudo registrar el comentario", "error");
        }
    })
}






function nuevo_chat(){
    var id_chat_nuevo = $("#id_nuevo_chat").val();
    var id_usuario = $("#txtidusuario").val();

    if ( id_chat_nuevo == null || id_usuario == null ) {
        Swal.fire("Mensaje De Advertencia", "Datos Vacios","warning");
        return; 
    }

    $.ajax({
        url:"../controlador/chat/controlador_nuevo_chat.php",
        type:"POST",
        data:{
            id_usuario:id_usuario,
            id_chat_nuevo:id_chat_nuevo
        }
    }).done(function (resp) {
        if (resp != "") {
            if (resp == -1) {
                Swal.fire("Mensaje De Advertencia", "Ya existe un chat iniciado con este usuario. Por favor, seleccione otro usuario.", "warning");
                return;
            }
    
            if (resp == 1) {
                Swal.fire("Mensaje De Confirmacion", "Datos correctamente, Nuevo Chat Registrado", "success")
                    .then((value) => {
                        listar_chat_estudiantes_es();
                    });
                return;
            }
        }
        
        Swal.fire("Mensaje De Error", "Lo sentimos, no se pudo completar el registro", "error");
    });
}



function mensaje_visto(){
    var id_chat_visto = $("#id_chat_visto").val();
    if (id_chat_visto.trim().length === 0) { 
        return; 
    }

   
    $.ajax({
        url:"../controlador/chat/controlador_chat_visto.php",
        type:"POST",
        data:{
            id_chat_visto:id_chat_visto
        }
    }).done(function (resp) {
      
        if (resp != "") {
            if (resp == -1) {
                return; 
            }
            if (resp == 1) {
                return; 
            }
        }
    });
}

function mensaje_abierto(){
    var id_chat_abierto = $("#id_chat_no_abierto").val();
    if (id_chat_abierto.trim().length === 0) { 
        return; 
    }

    $.ajax({
        url:"../controlador/chat/controlador_chat_abierto.php",
        type:"POST",
        data:{
            id_chat_abierto:id_chat_abierto
        }
    }).done(function (resp) {
        if (resp != "") {
            if (resp == -1) {
                return;
            }
            if (resp == 1) {
                return; 
            }
        }
    });
}

function enviar_archivo() {
    var id_chat = $("#id_chat").val();
    var mensaje = $("#txt_mensaje_documento").val();
    var id_usuario = $("#txtidusuario").val();
    var archivoInput = $("#txt_archivo_subir")[0];
    var archivo = archivoInput.files[0];

  if (!id_chat) {
    Swal.fire("Mensaje De Error", "Seleccione un chat y escriba un mensaje", "error");
    return; 
}

    if (!archivo) {
        return Swal.fire("Mensaje De Advertencia", "Adjunte el archivo", "warning");
    }


    // Extensiones permitidas
    var extensionesPermitidas = ["pdf", "doc", "docx", "xls", "xlsx", "ppt", "pptx"];
    var extension = archivo.name.split('.').pop().toLowerCase();

    if (extensionesPermitidas.indexOf(extension) === -1) {
        return Swal.fire("Mensaje De Advertencia", "Solo se permiten archivos PDF, Word, Excel y PowerPoint", "warning");
    }

    var caracteresNoDeseados = [":", ",", ";", "!"];

    // Generar un nombre de archivo aleatorio
    var fecha = new Date();
    var nombreAleatorio = Math.random().toString(36).substring(7);
    var nombrearchivo = nombreAleatorio + "_" + fecha.getDate() + "" + (fecha.getMonth() + 1) + "" + fecha.getFullYear() + "" + fecha.getMinutes() + "" + fecha.getMilliseconds() + "." + extension;

    // Reemplazar los caracteres no deseados con "_"
    caracteresNoDeseados.forEach(function(caracter) {
        nombrearchivo = nombrearchivo.replace(new RegExp("\\" + caracter, "g"), "_");
    });

    var formData = new FormData();
    formData.append('id_chat', id_chat);
    formData.append('mensaje', mensaje);
    formData.append('id_usuario', id_usuario);
    formData.append('nombrearchivo', nombrearchivo);
    formData.append('archivo', archivo);

    $.ajax({
        url: "../controlador/chat/controlador_enviar_chat_archivo.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(resp) {
            if (resp > 0) {
                Swal.fire("Mensaje de Confirmación", "Mensaje enviado correctamente", "success").then((value) => {
                    $("#modal_archivo_documento").modal('hide');
                });
            } else {
                Swal.fire("Mensaje De Error", "No se pudo entregar el mensaje", "error");
            }
        }
    });

    return false;
}


function enviar_imagen() {
    var id_chat = $("#id_chat").val();
    var mensaje = $("#txt_mensaje_imagen").val();
    var id_usuario = $("#txtidusuario").val();
    var archivoInput = $("#txt_imagen_subir")[0];
    var archivo = archivoInput.files[0];

  if (!id_chat) {
    Swal.fire("Mensaje De Error", "Seleccione un chat y escriba un mensaje", "error");
    return; 
}

    if (!archivo) {
        return Swal.fire("Mensaje De Advertencia", "Adjunte la imagen", "warning");
    }

// Verificar el tamaño del archivo
var fileSize = archivo.size;
var maxSize = 2 * 1024 * 1024; // 2 MB en bytes

if (fileSize > maxSize) {
    return Swal.fire("Mensaje De Advertencia", "La imagen supera el límite de tamaño de 2 MB", "warning");
}


    // Extensiones permitidas para imágenes
    var extensionesPermitidas = ["jpg", "jpeg", "png", "gif"];
    var extension = archivo.name.split('.').pop().toLowerCase();

    if (extensionesPermitidas.indexOf(extension) === -1) {
        return Swal.fire("Mensaje De Advertencia", "Solo se permiten archivos de imagen JPG, JPEG, PNG y GIF", "warning");
    }

    var caracteresNoDeseados = [":", ",", ";", "!"];

    // Generar un nombre de archivo aleatorio para la imagen
    var fecha = new Date();
    var nombreAleatorio = Math.random().toString(36).substring(7);
    var nombrearchivo = nombreAleatorio + "_" + fecha.getDate() + "" + (fecha.getMonth() + 1) + "" + fecha.getFullYear() + "" + fecha.getMinutes() + "" + fecha.getMilliseconds() + "." + extension;

    // Reemplazar los caracteres no deseados"
    caracteresNoDeseados.forEach(function(caracter) {
        nombrearchivo = nombrearchivo.replace(new RegExp("\\" + caracter, "g"), "_");
    });

    var formData = new FormData();
    formData.append('id_chat', id_chat);
    formData.append('mensaje', mensaje);
    formData.append('id_usuario', id_usuario);
    formData.append('nombrearchivo', nombrearchivo);
    formData.append('archivo', archivo);

    $.ajax({
        url: "../controlador/chat/controlador_enviar_chat_archivo.php",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function(resp) {
            if (resp > 0) {
                Swal.fire("Mensaje de Confirmación", "Imagen enviada correctamente", "success").then((value) => {
                    $("#modal_archivo_imagen").modal('hide');
                });
            } else {
                Swal.fire("Mensaje De Error", "No se pudo enviar la imagen", "error");
            }
        }
    });

    return false;
}

//----------------chat---------------

$(document).on('click', '.abrir_chat', function() {
    var id_conversacion = $(this).data('id');
    var imagenUsuario = $(this).closest('li').find('.contacts-list-img').attr('src');
    var nombreUsuario = $(this).closest('li').find('.contacts-list-name').text();

    $('#id_chat').val(id_conversacion);

    $('#id_chat_no_abierto').val('');

    $('#message_user_image').attr('src', imagenUsuario);
    $('#message_user_name').text(nombreUsuario);

  $('.box-tools.pull-right').show();

    listar_chat_directo();
    mensaje_visto();
 
});


function listar_chat_estudiantes_es() {
    var id_usuario_es = $("#txtidusuario").val();

    $.ajax({
        url: "../controlador/chat/controlador_chat_estudiantes_listar.php",
        type: "POST",
        data: {
            id_usuario_es: id_usuario_es
        }
    }).done(function(resp) {
        let data = JSON.parse(resp);
        var totalConversaciones = 0;

        $("#lista_conversaciones").empty();

        if (data.data.length > 0) {
            var listaConversacionesHTML = '';

            data.data.forEach(function(conversacion, index) {
                var fotoUsuario = '';
                var nombreUsuario = '';
                var mensaje = '';

                console.log("id_principal:", conversacion.id_principal);
                console.log("id_segundario:", conversacion.id_segundario);
                console.log("id_usuario_es:", id_usuario_es);

                if (conversacion.id_principal == id_usuario_es) {
                    fotoUsuario = conversacion.foto_usuario_secundario;
                    nombreUsuario = conversacion.nombre_usuario_secundario;
                    mensaje = 'Iniciaste un chat con este usuario';
                } else if (conversacion.id_segundario == id_usuario_es) {
                    fotoUsuario = conversacion.foto_usuario_principal;
                    nombreUsuario = conversacion.nombre_usuario_principal;
                    mensaje = 'Este usuario Inicio un chat contigo';
                }

        

                listaConversacionesHTML += '<li>' +
    '<a>' +
    '<img class="contacts-list-img" src="../' + fotoUsuario + '" alt="User Image" style="width: 40px; height: 40px; border-radius: 50%;">' +
    '<div class="contacts-list-info">' +
    '<span class="contacts-list-name" style="display: inline-block;">' + nombreUsuario + '</span>' +
    '<small class="contacts-list-date pull-right" style="display: inline-block; vertical-align: middle;">' +
    '<button style="font-size: 13px;" type="button" title="Haz Un Comentario Aquí!" class="abrir_chat btn btn-primary" data-id="' + conversacion.ID + '"><i class="fa fa-commenting-o"></i></button>' +
    '</small>' +
    '</div>' +
    '</a>' +
    '<span class="contacts-list-msg" style="margin-left: 6px;">' + mensaje + '</span>' +
    '</li>';

            
                
                totalConversaciones++;
            });

            $("#lista_conversaciones").html(listaConversacionesHTML);
        }

        $("#txt_contador_conversaciones").text(totalConversaciones);
    });
}



$('input#global_filter_nombre_conversaciones').on('keyup', function () {
    filterGlobalNombreConversaciones($(this).val()); 
});

// Función para filtrar globalmente por nombre en las conversaciones
function filterGlobalNombreConversaciones(value) {
    var $listaConversaciones = $("#lista_conversaciones");
    $listaConversaciones.find(".contacts-list-name").each(function() {
        var nombreUsuario = $(this).text().toLowerCase();
        var searchTerm = value.toLowerCase();
        if (nombreUsuario.indexOf(searchTerm) !== -1) {
            $(this).closest("li").show();
        } else {
            $(this).closest("li").hide();
        }
    });
}

function listar_chat_directo() {
    var id_chat = $("#id_chat").val();
    var id_usuario_es = $("#txtidusuario").val();
    var ultimoMensajeNoVisto = [];

    $.ajax({
        url: "../controlador/chat/controlador_chat_directo_listar.php",
        type: "POST",
        data: {
            id_chat: id_chat
        }
    }).done(function(resp) {
        let data = JSON.parse(resp);

        $(".direct-chat-messages").empty();

        if (data.data && data.data.length > 0) {
            data.data.forEach(function(comentario) {
                var esUsuarioActual = comentario.id_comentario == id_usuario_es;
            
                if (!esUsuarioActual && comentario.Estado === 'NO VISTO') {
                    ultimoMensajeNoVisto.push(comentario.ID);
                }
            
                var fechaFormateada = formatearFecha(comentario.Fecha);
            
                var comentarioHTML = '<div class="direct-chat-msg';
                comentarioHTML += esUsuarioActual ? ' right">' : '">'; // Agregar la clase 'right' si es el usuario actual
                comentarioHTML += '<div class="direct-chat-info clearfix">';
                comentarioHTML += '<span class="direct-chat-name pull-' + (esUsuarioActual ? 'right' : 'left') + '">' + comentario.nombre + '</span>';
                comentarioHTML += '<span class="direct-chat-timestamp pull-' + (esUsuarioActual ? 'left' : 'right') + '">' + fechaFormateada + '</span>';
                comentarioHTML += '</div>';
                comentarioHTML += '<img class="direct-chat-img" src="../' + comentario.foto + '" alt="Message User Image">';
                comentarioHTML += '<div class="direct-chat-text">';
            
                comentarioHTML += comentario.Comentario;
            
                if (comentario.archivo) {
                    comentarioHTML += '<div class="attachment">';
                    comentarioHTML += '<h4>Archivo:</h4>';
                    
                    var nombreArchivo = comentario.archivo.split('/').pop();
                    
                    comentarioHTML += '<p>' + nombreArchivo + '</p>';
                    
                    if (/\.(jpeg|jpg|png|gif)$/i.test(nombreArchivo)) {
                        comentarioHTML += '<img src="../' + comentario.archivo + '" alt="Archivo adjunto" style="max-width: 100px;">'; // Ajusta el valor de max-width
                        comentarioHTML += '<div class="clearfix">';
                        comentarioHTML += '<div class="pull-right">';
                        comentarioHTML += '<button type="button" class="abrir_imagen btn btn-primary btn-sm btn-flat">Abrir</button>';
                        comentarioHTML += '</div>';
                        comentarioHTML += '</div>';
                    } else {
                        comentarioHTML += '<a href="../' + comentario.archivo + '" download="' + nombreArchivo + '" style="color: black; font-weight: bold; text-decoration: none;">Descargar archivo</a>';
                    }
                    
                    comentarioHTML += '</div>';
                }
            
                comentarioHTML += '</div>'; 
            
                $(".direct-chat-messages").append(comentarioHTML);
            });
        } else {
            $(".direct-chat-messages").html('<div class="alert alert-warning">Aún no se ha iniciado una conversación.</div>');
        }

        if (ultimoMensajeNoVisto.length > 0) {
            $('#id_chat_visto').val(ultimoMensajeNoVisto.join(',')); // Convertir el array a una cadena separada por comas
        }

        setTimeout(function() {
            mensaje_visto();
        }, 1000); 
    });
}


function formatearFecha(fecha) {
    var fechaObjeto = new Date(fecha);

    var meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    var dia = fechaObjeto.getDate();
    var mes = meses[fechaObjeto.getMonth()];
    var año = fechaObjeto.getFullYear(); 
    var hora = fechaObjeto.getHours();
    var minutos = fechaObjeto.getMinutes();
    var ampm = hora >= 12 ? 'pm' : 'am';

    hora = hora % 12;
    hora = hora ? hora : 12; 

    minutos = minutos < 10 ? '0' + minutos : minutos;

    var fechaFormateada = dia + ' ' + mes + ' ' + año + ' ' + hora + ':' + minutos + ' ' + ampm;

    return fechaFormateada;
}

$('#scrollDownButton').on('click', function() {
    $(".direct-chat-messages").scrollTop($(".direct-chat-messages")[0].scrollHeight);
 
});


function listar_integrantes_salon_estudiantes() {
    var id_usuario_es = $("#txtidusuario").val();

    $.ajax({
        url: "../controlador/chat/controlador_listar_chat_integrantes_estudiantes.php",
        type: "POST",
        data: {
            id_usuario_es: id_usuario_es
        }
    }).done(function(resp) {
        let data = JSON.parse(resp);
        var totalIntegrantes = 0;

        $("#lista_estudiantes").empty();

        if (data.data.length > 0) {
            data.data.forEach(function(integrante) {
                var usuarioHTML = '<li>' +
                    '<img src="../' + integrante.foto_usuario + '" alt="User Image" style="width: 50px; height: 50px; border-radius: 50%;">' +
                    '<a class="users-list-name" href="#">' + integrante.nombre + '</a>' +
                    '<span class="users-list-date">' + integrante.rol_nombre + '</span>' +
                    '<span class="users-list-date"><button type="button" title="Iniciar un chat con este usuario!" class="iniciar_chat btn btn-success" data-id="' + integrante.id_usuario + '"><i class="fa fa-plus"></i></button></span>' +
                    '</li>';
                $("#lista_estudiantes").append(usuarioHTML);
                totalIntegrantes++;
            });
        }

        $("#txt_contador_integrantes").text(totalIntegrantes);
    });
}

function listar_integrantes_salon_docentes() {
    var id_usuario_es = $("#txtidusuario").val();

    $.ajax({
        url: "../controlador/chat/controlador_listar_chat_integrantes_docentes.php",
        type: "POST",
        data: {
            id_usuario_es: id_usuario_es
        }
    }).done(function(resp) {
        let data = JSON.parse(resp);
        var totalIntegrantes = 0;

        $("#lista_docentes").empty();

        if (data.data.length > 0) {
            data.data.forEach(function(integrante) {
                var usuarioHTML = '<li>' +
                    '<img src="../' + integrante.foto_usuario + '" alt="User Image" style="width: 50px; height: 50px; border-radius: 50%;">' +
                    '<a class="users-list-name" href="#">' + integrante.nombre + '</a>' +
                    '<span class="users-list-date">' + integrante.rol_nombre + '</span>' +
                    '<span class="users-list-date"><button type="button" title="Iniciar un chat con este usuario!" class="iniciar_chat btn btn-success" data-id="' + integrante.id_usuario + '"><i class="fa fa-plus"></i></button></span>' +
                    '</li>';
                $("#lista_docentes").append(usuarioHTML);
                totalIntegrantes++;
            });
        }

        $("#txt_contador_integrantes").text(totalIntegrantes);
    });
}


$(document).on("click", ".iniciar_chat", function() {
    var idUsuario = $(this).data("id");
    $("#id_nuevo_chat").val(idUsuario);

      nuevo_chat();

});
