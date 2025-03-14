<?php
require '../../modelo/modelo_foro.php';
$MF = new Modelo_Foro();

$id_foro = htmlspecialchars($_POST['id_foro'], ENT_QUOTES, 'UTF-8');
$id_principal = htmlspecialchars($_POST['id_principal'], ENT_QUOTES, 'UTF-8');

$consulta = $MF->Listar_comentarios_foro_respuestas($id_foro, $id_principal);
echo json_encode($consulta);
?>