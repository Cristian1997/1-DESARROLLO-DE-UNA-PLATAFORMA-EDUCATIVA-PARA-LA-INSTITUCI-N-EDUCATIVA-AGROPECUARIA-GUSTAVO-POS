<?php
    require '../../modelo/modelo_talleres.php';

    $MA = new Modelo_Talleres();
    

    $consulta = $MA->TraerDatos_fechas_talleres();
    echo json_encode($consulta);
?>