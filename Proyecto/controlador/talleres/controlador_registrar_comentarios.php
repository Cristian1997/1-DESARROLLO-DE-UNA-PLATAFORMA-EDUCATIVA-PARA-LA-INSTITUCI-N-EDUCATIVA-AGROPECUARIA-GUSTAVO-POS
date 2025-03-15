<?php  

require '../../modelo/modelo_talleres.php';

$MT = new Modelo_Talleres();
$id_taller = htmlspecialchars($_POST['id_taller'],ENT_QUOTES,'UTF-8');
$id_usuario_es = htmlspecialchars($_POST['id_usuario_es'],ENT_QUOTES,'UTF-8');
$comentario = htmlspecialchars($_POST['comentario'],ENT_QUOTES,'UTF-8');
$consulta = $MT->registrar_comentarios($id_taller,$id_usuario_es,$comentario);

echo $consulta;
?>