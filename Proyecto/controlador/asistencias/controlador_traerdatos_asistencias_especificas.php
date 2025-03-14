<?php
    require '../../modelo/modelo_asistencias.php';

    $MA = new Modelo_Asistencias();
    $id_ES = htmlspecialchars($_POST['id_ES'],ENT_QUOTES,'UTF-8');
    $id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
    $consulta = $MA->TraerDatos_Asistencias_Espefificas($id_ES ,$id_grupo);
    echo json_encode($consulta);
?> 