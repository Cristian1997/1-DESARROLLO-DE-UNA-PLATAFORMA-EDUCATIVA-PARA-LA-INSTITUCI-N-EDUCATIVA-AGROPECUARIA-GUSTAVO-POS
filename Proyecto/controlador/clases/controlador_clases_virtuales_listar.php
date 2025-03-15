<?php 
 require '../../modelo/modelo_clases.php';
 $MC = new Modelo_Clases();
 $idusuario = htmlspecialchars($_POST['id_usuario'],ENT_QUOTES,'UTF-8');
 $id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
 $consulta = $MC->listar_clases_virtuales($idusuario,$id_grupo);
 if ($consulta) {
 	echo json_encode($consulta);
 }else{
 	echo '{
		    "sEcho": 1,
		    "iTotalRecords": "0",
		    "iTotalDisplayRecords": "0",
		    "aaData": []
		}';
 }