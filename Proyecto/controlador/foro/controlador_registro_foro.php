<?php
    require '../../modelo/modelo_foro.php';
    $MF = new Modelo_Foro();
$fecha_limite = htmlspecialchars($_POST['fecha_limite'], ENT_QUOTES, 'UTF-8');
$tema_foro = htmlspecialchars($_POST['tema_foro'], ENT_QUOTES, 'UTF-8');
$descripcion_foro = htmlspecialchars($_POST['descripcion_foro'], ENT_QUOTES, 'UTF-8');
$id_grupo = htmlspecialchars($_POST['id_grupo'], ENT_QUOTES, 'UTF-8');
$id_docente = htmlspecialchars($_POST['id_docente'], ENT_QUOTES, 'UTF-8');

$consulta = $MF->Registrar_Foro($id_docente, $id_grupo, $fecha_limite, $tema_foro, $descripcion_foro);

echo $consulta;


?>