<?php
    require '../../modelo/modelo_calificaciones.php';
    $MS = new Modelo_Calificaciones();

    $id_grado = htmlspecialchars($_POST['id_grado'],ENT_QUOTES,'UTF-8');
    $id_asignatura = htmlspecialchars($_POST['id_asignatura'],ENT_QUOTES,'UTF-8');
    $id_docente = htmlspecialchars($_POST['id_docente'],ENT_QUOTES,'UTF-8');

    $consulta = $MS->listar_combo_estudiante($id_grado,$id_asignatura,$id_docente);
    echo json_encode($consulta);
?>
