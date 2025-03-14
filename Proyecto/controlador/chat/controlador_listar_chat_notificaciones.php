<?php
    require '../../modelo/modelo_chat.php';
    $MC = new Modelo_Chat();
    $id_usuario_es = htmlspecialchars($_POST['id_usuario_es'],ENT_QUOTES,'UTF-8');
    $consulta = $MC->listar_chat_notificaciones($id_usuario_es);
    if($consulta){
        echo json_encode($consulta);
    }else{
        echo '{
            "sEcho": 1,
            "iTotalRecords": "0",
            "iTotalDisplayRecords": "0",
            "aaData": []
        }';
    }
    ?>