<?php
    require '../../modelo/modelo_foro.php';
    $MF = new Modelo_Foro();
$id_foro = htmlspecialchars($_POST['id_foro'], ENT_QUOTES, 'UTF-8');
$id_grupo = htmlspecialchars($_POST['id_grupo'], ENT_QUOTES, 'UTF-8');
$id_docente = htmlspecialchars($_POST['id_docente'], ENT_QUOTES, 'UTF-8');
$comentario = htmlspecialchars($_POST['comentario'], ENT_QUOTES, 'UTF-8');
$consulta = $MF->Registrar_comentario_foro( $id_foro,$id_grupo, $id_docente, $comentario);

echo $consulta;

?>
