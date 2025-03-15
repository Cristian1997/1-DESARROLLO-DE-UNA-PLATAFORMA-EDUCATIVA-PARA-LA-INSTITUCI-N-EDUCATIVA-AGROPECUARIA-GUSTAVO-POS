<?php
    require '../../modelo/modelo_cursos.php';
    $MD = new Modelo_Cursos();
    $nombre = htmlspecialchars($_POST['nombre'],ENT_QUOTES,'UTF-8');
 
    $consulta = $MD->Registrar_Asignatura($nombre);
    echo $consulta;
    ?>