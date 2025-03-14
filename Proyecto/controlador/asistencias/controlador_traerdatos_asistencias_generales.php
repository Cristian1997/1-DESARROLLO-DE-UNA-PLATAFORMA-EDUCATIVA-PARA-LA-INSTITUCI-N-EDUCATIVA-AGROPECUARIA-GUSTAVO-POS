<?php
    require '../../modelo/modelo_asistencias.php';

    $MA = new Modelo_Asistencias();
    $id_usuario_doc = htmlspecialchars($_POST['id_usuario_doc'],ENT_QUOTES,'UTF-8');
    $id_asignatura = htmlspecialchars($_POST['id_asignatura'],ENT_QUOTES,'UTF-8');
    $id_grado = htmlspecialchars($_POST['id_grado'],ENT_QUOTES,'UTF-8');
    $consulta = $MA->TraerDatos_Asistencias_Generales($id_usuario_doc ,   $id_asignatura ,    $id_grado );
    echo json_encode($consulta);
?> 