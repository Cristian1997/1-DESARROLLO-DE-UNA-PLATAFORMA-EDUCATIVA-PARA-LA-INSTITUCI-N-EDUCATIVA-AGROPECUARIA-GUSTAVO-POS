<?php
    require '../../modelo/modelo_asistencias.php';
    $MU = new Modelo_Asistencias();
    
    $id_ES= htmlspecialchars($_POST['id_ES'],ENT_QUOTES,'UTF-8');
    $id_curso = htmlspecialchars($_POST['id_curso'],ENT_QUOTES,'UTF-8');
    $consulta = $MU->listar_deatelles_asistencias_ES($id_ES,$id_curso);

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
