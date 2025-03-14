<?php
    require '../../modelo/modelo_chat.php';
    $MC = new Modelo_Chat();
    
    $comentario = htmlspecialchars($_POST['comentario'], ENT_QUOTES, 'UTF-8');
    $id_chat = htmlspecialchars($_POST['id_chat'], ENT_QUOTES, 'UTF-8');
    $id_usuario = htmlspecialchars($_POST['id_usuario'], ENT_QUOTES, 'UTF-8');
 
    $consulta = $MC->registrar_respuesta_chat($id_chat, $id_usuario, $comentario);
    echo $consulta;
?>
