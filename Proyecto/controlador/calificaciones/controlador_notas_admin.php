<?php
require '../../modelo/modelo_calificaciones.php';
$MU = new Modelo_Calificaciones();
    $consulta = $MU->listar_notas_admin();
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