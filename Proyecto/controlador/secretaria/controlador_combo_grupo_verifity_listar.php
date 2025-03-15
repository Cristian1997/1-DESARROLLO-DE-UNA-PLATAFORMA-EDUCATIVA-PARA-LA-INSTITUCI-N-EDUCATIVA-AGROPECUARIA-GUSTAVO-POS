<?php
    require '../../modelo/modelo_secretaria.php';
    $MS = new Modelo_Secretaria();
    $id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
 
    $consulta = $MS->listar_combo_grupo_verifity($id_grupo);
    echo json_encode($consulta);
    ?>