<?php
    require '../../modelo/modelo_foro.php';
    $MF = new Modelo_Foro();
    
    $id_usuario_doc = htmlspecialchars($_POST['id_usuario_doc'],ENT_QUOTES,'UTF-8');
    $id_asignatura = htmlspecialchars($_POST['id_asignatura'],ENT_QUOTES,'UTF-8');
    $id_grado = htmlspecialchars($_POST['id_grado'],ENT_QUOTES,'UTF-8');
    $consulta = $MF->listar_foro($id_asignatura,$id_grado,$id_usuario_doc);
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