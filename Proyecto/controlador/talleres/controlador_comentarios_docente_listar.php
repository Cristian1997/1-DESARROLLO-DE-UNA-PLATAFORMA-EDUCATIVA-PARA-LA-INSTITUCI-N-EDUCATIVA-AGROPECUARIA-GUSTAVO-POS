<?php
    require '../../modelo/modelo_talleres.php';
    $MU = new Modelo_Talleres();
    
    $id_usuario_doc = htmlspecialchars($_POST['id_usuario_doc'],ENT_QUOTES,'UTF-8');
    $id_usuario_es = htmlspecialchars($_POST['id_usuario_es'],ENT_QUOTES,'UTF-8');
    $id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
    $consulta = $MU->listar_comentarios_docentes($id_grupo,$id_usuario_doc,$id_usuario_es);
    if($consulta){
        echo json_encode($consulta);
    }else{
        echo '{
            "sEcho": 1,
            "iTotalRecords": "0",
            "iTotalDisplayRecords": "0",
            "aaData": []
        }';
    }
    ?>