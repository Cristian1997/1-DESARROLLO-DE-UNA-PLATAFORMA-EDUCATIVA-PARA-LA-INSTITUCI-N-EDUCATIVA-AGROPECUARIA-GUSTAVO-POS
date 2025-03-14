<?php
    require '../../modelo/modelo_cursos.php';

    $MU = new Modelo_Cursos();
    $ID = htmlspecialchars($_POST['ID'],ENT_QUOTES,'UTF-8');
    $estatus = htmlspecialchars($_POST['estatus'],ENT_QUOTES,'UTF-8');
    $consulta = $MU->Modificar_Estatus_Asgnatura($ID,$estatus);
    echo $consulta;

