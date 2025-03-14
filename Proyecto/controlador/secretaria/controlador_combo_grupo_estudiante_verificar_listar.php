<?php
    require '../../modelo/modelo_secretaria.php';
    $MS = new Modelo_Secretaria();
    $id_estudiante = htmlspecialchars($_POST['id_estudiante'],ENT_QUOTES,'UTF-8');

    $consulta = $MS->listar_combo_grupo_estudiante_verificar($id_estudiante);
    echo json_encode($consulta);
