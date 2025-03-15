<?php  

require '../../modelo/modelo_talleres.php';

$MT = new Modelo_Talleres();
$id_comentario = htmlspecialchars($_POST['id_comentario'],ENT_QUOTES,'UTF-8');
$id_docente = htmlspecialchars($_POST['id_docente'],ENT_QUOTES,'UTF-8');
$id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
$respuesta = htmlspecialchars($_POST['respuesta'],ENT_QUOTES,'UTF-8');
 
$consulta = $MT->registrar_respuesta($id_comentario,$respuesta);
if ($consulta == 1) {
	$consulta2 = $MT->Notificaciones($id_comentario,$id_docente,$id_grupo);
}

echo $consulta;
?>