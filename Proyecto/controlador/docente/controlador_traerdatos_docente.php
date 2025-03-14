<?php
    require '../../modelo/modelo_docente.php';

    $MU = new Modelo_Docente();
    $usuario = htmlspecialchars($_POST['usuario'],ENT_QUOTES,'UTF-8'); 
    $consulta = $MU->TraerDatos($usuario);
    echo json_encode($consulta);
?> 