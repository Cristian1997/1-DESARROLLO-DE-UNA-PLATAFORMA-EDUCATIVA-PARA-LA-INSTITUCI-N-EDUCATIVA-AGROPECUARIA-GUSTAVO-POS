<?php
    require '../../modelo/modelo_secretaria.php';
    $MS = new Modelo_Secretaria();
    $id_docente = htmlspecialchars($_POST['id_docente'],ENT_QUOTES,'UTF-8');
    $id_curso = htmlspecialchars($_POST['id_curso'],ENT_QUOTES,'UTF-8');
    $id_aula = htmlspecialchars($_POST['id_aula'],ENT_QUOTES,'UTF-8');

    $consulta = $MS->listar_combo_grupo_estudiante($id_docente,$id_curso,$id_aula);
    echo json_encode($consulta);
    ?>