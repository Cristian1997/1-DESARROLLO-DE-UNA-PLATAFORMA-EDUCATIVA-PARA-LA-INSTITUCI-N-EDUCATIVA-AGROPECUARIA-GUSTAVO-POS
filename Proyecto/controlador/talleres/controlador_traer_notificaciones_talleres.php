<?php
    require '../../modelo/modelo_talleres.php';
    $MS = new Modelo_Talleres();

    $id_usuario = htmlspecialchars($_POST['id_usuario'],ENT_QUOTES,'UTF-8');
    $consulta = $MS->TraerNotificacionestalleres($id_usuario);
    echo json_encode($consulta);
