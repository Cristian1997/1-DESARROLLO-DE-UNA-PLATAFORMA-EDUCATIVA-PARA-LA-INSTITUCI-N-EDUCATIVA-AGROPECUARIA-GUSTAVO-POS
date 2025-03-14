<?php
    require '../../modelo/modelo_chat.php';
    $MC = new Modelo_Chat();
    $id_chat_visto = htmlspecialchars($_POST['id_chat_visto'], ENT_QUOTES, 'UTF-8');
 
    $consulta = $MC->modificar_chat_visto($id_chat_visto);
    echo $consulta;
?>
