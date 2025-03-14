<?php
    require '../../modelo/modelo_materiales.php';
    $MM = new Modelo_Material();
    $id_materiales = htmlspecialchars($_POST['id_materiales'],ENT_QUOTES,'UTF-8');
    $consulta = $MM->listar_materiales($id_materiales);
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