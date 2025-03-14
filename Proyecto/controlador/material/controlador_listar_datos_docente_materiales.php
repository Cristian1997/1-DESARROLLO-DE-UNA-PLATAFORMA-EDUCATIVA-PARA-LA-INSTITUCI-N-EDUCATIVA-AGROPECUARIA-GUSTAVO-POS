<?php
    require '../../modelo/modelo_materiales.php';
    $MM = new Modelo_Material();
    $id_usuario_es = htmlspecialchars($_POST['id_usuario_es'],ENT_QUOTES,'UTF-8');
    $consulta = $MM->listar_datos_docente_materiales($id_usuario_es);
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