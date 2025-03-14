<?php
    require '../../modelo/modelo_chat.php';
    $MC = new Modelo_Chat();
    
    $id_usuario = htmlspecialchars($_POST['id_usuario'], ENT_QUOTES, 'UTF-8');
    $id_chat_nuevo = htmlspecialchars($_POST['id_chat_nuevo'], ENT_QUOTES, 'UTF-8');
 
    $consulta = $MC->registrar_nuevo_chat($id_usuario, $id_chat_nuevo);
    echo intval($consulta); // Convertir el resultado a entero antes de imprimirlo
?>
