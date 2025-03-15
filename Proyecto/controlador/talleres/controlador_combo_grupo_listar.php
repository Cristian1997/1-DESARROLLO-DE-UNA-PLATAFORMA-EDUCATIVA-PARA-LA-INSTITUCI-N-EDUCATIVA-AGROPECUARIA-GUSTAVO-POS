<?php
    require '../../modelo/modelo_talleres.php';
    $MS = new Modelo_Talleres();
    $id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
    $consulta = $MS->listar_combo_grupo($id);
    echo json_encode($consulta);
    ?>