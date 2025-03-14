<?php
    require '../../modelo/modelo_foro.php';
    $MF = new Modelo_Foro();
$id_foro = htmlspecialchars($_POST['id_foro'], ENT_QUOTES, 'UTF-8');
$id_docente = htmlspecialchars($_POST['id_docente'], ENT_QUOTES, 'UTF-8');
$id_principal = htmlspecialchars($_POST['id_principal'], ENT_QUOTES, 'UTF-8');
$comentario = htmlspecialchars($_POST['comentario'], ENT_QUOTES, 'UTF-8');
$id_responde_a = htmlspecialchars($_POST['id_responde_a'], ENT_QUOTES, 'UTF-8');
$consulta = $MF->registrar_comentario_foro_respuesta($id_foro, $id_docente, $id_principal, $comentario, $id_responde_a);
echo $consulta;

?>

