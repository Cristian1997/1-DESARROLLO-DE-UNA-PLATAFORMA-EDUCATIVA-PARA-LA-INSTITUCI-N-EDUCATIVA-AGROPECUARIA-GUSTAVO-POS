
<?php
require '../../modelo/modelo_foro.php';
$MF = new Modelo_Foro();
$id_comentario_us = htmlspecialchars($_POST["id_comentario_us"], ENT_QUOTES, 'UTF-8');
$consulta = $MF->Eliminarcomentario_respuesta($id_comentario_us);
echo $consulta;
?>

