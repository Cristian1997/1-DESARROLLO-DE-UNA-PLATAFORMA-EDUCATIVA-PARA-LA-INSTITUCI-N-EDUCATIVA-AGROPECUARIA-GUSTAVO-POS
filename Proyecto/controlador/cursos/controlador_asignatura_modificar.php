<?php
    require '../../modelo/modelo_cursos.php';
    $MD = new Modelo_Cursos();
    $idasignatura = htmlspecialchars($_POST['idasignatura'],ENT_QUOTES,'UTF-8');
    $nombre = htmlspecialchars($_POST['nombre'],ENT_QUOTES,'UTF-8');
 
    $consulta = $MD->Modificar_Asignatura($idasignatura,$nombre);
    echo $consulta;
    ?>