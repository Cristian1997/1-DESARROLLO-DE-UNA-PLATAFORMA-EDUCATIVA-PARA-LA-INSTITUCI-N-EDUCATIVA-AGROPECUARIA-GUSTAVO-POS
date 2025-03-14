<?php
    require '../../modelo/modelo_estudiante.php';
    $ME = new Modelo_Estudiante();
    $consulta = $ME->listar_combo_grado_docente();
    echo json_encode($consulta);
?>