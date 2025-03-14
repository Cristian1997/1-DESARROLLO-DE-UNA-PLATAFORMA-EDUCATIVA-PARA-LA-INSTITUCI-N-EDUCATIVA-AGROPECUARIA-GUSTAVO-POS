<?php
    require '../../modelo/modelo_docente.php';
    $MD = new Modelo_Docente();
    $consulta = $MD->listar_docente();
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