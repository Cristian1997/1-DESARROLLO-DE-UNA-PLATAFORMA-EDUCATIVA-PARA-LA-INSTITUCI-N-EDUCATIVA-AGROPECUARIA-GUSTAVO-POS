<?php
    require '../../modelo/modelo_cursos.php';
    $MD = new Modelo_Cursos();
    $consulta = $MD->listar_cursos();
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