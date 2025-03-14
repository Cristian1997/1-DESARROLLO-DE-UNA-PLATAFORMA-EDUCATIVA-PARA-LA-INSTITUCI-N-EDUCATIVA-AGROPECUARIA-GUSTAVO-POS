<?php
    require '../../modelo/modelo_usuario.php';
    $MU = new Modelo_Usuario();
    $consulta = $MU->TraerDatosContador();
    echo json_encode($consulta);
?> 