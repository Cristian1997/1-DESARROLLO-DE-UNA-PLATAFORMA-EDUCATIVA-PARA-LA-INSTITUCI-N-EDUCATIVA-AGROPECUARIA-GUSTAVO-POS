<?php
require '../../modelo/modelo_horarios.php';
$MH = new Modelo_Horarios();
    $consulta = $MH->listar_combo_cursos();
    echo json_encode($consulta);
?>