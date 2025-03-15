<?php
    require '../../modelo/modelo_secretaria.php';
    $MS = new Modelo_Secretaria();
    $id_docente = htmlspecialchars($_POST['id_docente'],ENT_QUOTES,'UTF-8');
    $consulta = $MS->listar_combo_grupo($id_docente);
    echo json_encode($consulta);
    ?>