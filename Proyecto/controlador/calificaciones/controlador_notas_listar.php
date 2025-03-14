<?php
    require '../../modelo/modelo_calificaciones.php';
    $MU = new Modelo_Calificaciones();
    
    $id_usuario_es = htmlspecialchars($_POST['id_usuario_es'],ENT_QUOTES,'UTF-8');
    $id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
    $id_docente = htmlspecialchars($_POST['id_docente'],ENT_QUOTES,'UTF-8');
    $consulta = $MU->listar_Notas($id_usuario_es,$id_grupo,$id_docente);
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

