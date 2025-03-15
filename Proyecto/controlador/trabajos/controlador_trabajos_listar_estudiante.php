<?php
    require '../../modelo/modelo_trabajos.php';
    $MT = new Modelo_Trabajos();
    
    $id_usuario = htmlspecialchars($_POST['id_usuario'],ENT_QUOTES,'UTF-8');
    $id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
    $consulta = $MT->listar_Trabajos_entregados_estudiante($id_usuario,$id_grupo);
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
