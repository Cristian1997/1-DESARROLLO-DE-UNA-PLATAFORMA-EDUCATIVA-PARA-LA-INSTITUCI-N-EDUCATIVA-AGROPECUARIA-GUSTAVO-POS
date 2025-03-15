<?php
    require '../../modelo/modelo_talleres.php';
    $MU = new Modelo_Talleres();
    
    $id_usuario = htmlspecialchars($_POST['id_usuario'],ENT_QUOTES,'UTF-8');
    $id_estudiante = htmlspecialchars($_POST['id_estudiante'],ENT_QUOTES,'UTF-8');
   
    $consulta = $MU->listar_docente_comentarios($id_estudiante,$id_usuario);
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