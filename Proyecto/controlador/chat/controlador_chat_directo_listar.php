<?php
    require '../../modelo/modelo_chat.php';
    $MC = new Modelo_Chat();
    $id_chat = htmlspecialchars($_POST['id_chat'],ENT_QUOTES,'UTF-8');
    $consulta = $MC->listar_chat_directo($id_chat);
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