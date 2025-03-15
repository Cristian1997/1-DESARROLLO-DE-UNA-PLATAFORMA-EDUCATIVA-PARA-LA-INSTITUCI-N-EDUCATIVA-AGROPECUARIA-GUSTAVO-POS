<?php
    require '../../modelo/modelo_secretaria.php';
    $MU = new Modelo_Secretaria();
    $consulta = $MU->listar_grupos();
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