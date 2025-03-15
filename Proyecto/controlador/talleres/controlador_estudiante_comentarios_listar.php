<?php
    require '../../modelo/modelo_talleres.php';
    $MU = new Modelo_Talleres();
    
    $id_usuario = htmlspecialchars($_POST['id_usuario'],ENT_QUOTES,'UTF-8');
    $id_docente = htmlspecialchars($_POST['id_docente'],ENT_QUOTES,'UTF-8');
   
    $consulta = $MU->listar_estudiante_comentarios($id_docente,$id_usuario);
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