<?php
    require '../../modelo/modelo_foro.php';
    $MF = new Modelo_Foro();
    $id_usuario = htmlspecialchars($_POST['id_usuario'],ENT_QUOTES,'UTF-8');
    $consulta = $MF->TraerNotificacionesforodoc($id_usuario);
    echo json_encode($consulta);
    ?>