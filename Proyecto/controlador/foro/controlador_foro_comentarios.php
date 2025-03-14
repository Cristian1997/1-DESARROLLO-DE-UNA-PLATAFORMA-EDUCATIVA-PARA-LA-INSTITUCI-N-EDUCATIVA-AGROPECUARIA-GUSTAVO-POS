<?php
    require '../../modelo/modelo_foro.php';
    $MF = new Modelo_Foro();
    $id_foro = htmlspecialchars($_POST['id_foro'],ENT_QUOTES,'UTF-8');
    $id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
    $consulta = $MF->Listar_comentarios_foro($id_grupo, $id_foro);
    echo json_encode($consulta);
    ?>