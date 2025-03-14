<?php
require '../../modelo/modelo_talleres.php';

$MT = new Modelo_Talleres();
$id_docente = htmlspecialchars($_POST['id_docente'], ENT_QUOTES, 'UTF-8');
$id_usuario_es = htmlspecialchars($_POST['id_usuario_es'], ENT_QUOTES, 'UTF-8');
$asunto = htmlspecialchars($_POST['asunto'], ENT_QUOTES, 'UTF-8');
$comentario = htmlspecialchars($_POST['comentario'], ENT_QUOTES, 'UTF-8');

$consulta = $MT->registrar_comentarios_asunto($id_docente, $id_usuario_es, $asunto, $comentario);

echo $consulta;
?>
