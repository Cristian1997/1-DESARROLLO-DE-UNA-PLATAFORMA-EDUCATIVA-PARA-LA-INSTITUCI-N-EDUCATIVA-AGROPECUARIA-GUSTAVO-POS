<?php
    require '../../modelo/modelo_secretaria.php';
    $MS = new Modelo_Secretaria();
    $consulta = $MS->listar_combo_asignatura();
    echo json_encode($consulta);
    ?>