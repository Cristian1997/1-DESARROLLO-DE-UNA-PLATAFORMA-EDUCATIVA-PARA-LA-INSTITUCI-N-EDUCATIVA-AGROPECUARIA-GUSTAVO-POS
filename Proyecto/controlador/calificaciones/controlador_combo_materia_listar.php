<?php
    require '../../modelo/modelo_calificaciones.php';
    $MC = new Modelo_Calificaciones();
    $id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
    $consulta = $MC->listar_combo_Materia($id);
    echo json_encode($consulta);
