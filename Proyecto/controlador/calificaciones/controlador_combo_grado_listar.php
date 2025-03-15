<?php
    require '../../modelo/modelo_calificaciones.php';
    $MS = new Modelo_Calificaciones();

    $id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
    $id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');

    $consulta = $MS->listar_combo_grado($id,$id_grupo);
    echo json_encode($consulta);
?>
