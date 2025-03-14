<?php
    require '../../modelo/modelo_foro.php';
    $MF = new Modelo_Foro();
$id_foro_cometario = htmlspecialchars($_POST['id_foro_cometario'], ENT_QUOTES, 'UTF-8');
$comentario = htmlspecialchars($_POST['comentario'], ENT_QUOTES, 'UTF-8');
$consulta = $MF->Editar_comentario_foro_respuesta($id_foro_cometario, $comentario);
echo $consulta;
?>
