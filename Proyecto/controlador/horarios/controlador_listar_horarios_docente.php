<?php
require '../../modelo/modelo_horarios.php';
$MH = new Modelo_Horarios();
    $consulta = $MH->listar_horarios_docente();
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