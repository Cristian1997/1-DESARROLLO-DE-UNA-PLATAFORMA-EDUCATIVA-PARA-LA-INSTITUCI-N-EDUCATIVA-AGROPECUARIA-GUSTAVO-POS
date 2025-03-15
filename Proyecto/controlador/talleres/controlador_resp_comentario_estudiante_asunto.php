<?php  

require '../../modelo/modelo_talleres.php';

$MT = new Modelo_Talleres();
$id_comentario = htmlspecialchars($_POST['id_comentario'],ENT_QUOTES,'UTF-8');
$respuesta = htmlspecialchars($_POST['respuesta'],ENT_QUOTES,'UTF-8');
 
$consulta = $MT->registrar_respuesta_estudiante_asunto($id_comentario,$respuesta);


echo $consulta;
?>