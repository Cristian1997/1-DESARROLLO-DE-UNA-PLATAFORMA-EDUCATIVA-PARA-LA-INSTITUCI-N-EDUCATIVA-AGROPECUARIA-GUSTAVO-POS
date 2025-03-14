<?php
    require '../../modelo/modelo_asistencias.php';

    $MA = new Modelo_Asistencias();

    $consulta = $MA->TraerDatos_fechas_Asistencias();
    echo json_encode($consulta);
?> 