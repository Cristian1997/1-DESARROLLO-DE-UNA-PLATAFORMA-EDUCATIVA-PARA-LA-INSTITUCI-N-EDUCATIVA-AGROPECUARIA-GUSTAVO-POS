<?php
require '../../modelo/modelo_secretaria.php';

$MS = new Modelo_Secretaria();
$id_detalles_curso = htmlspecialchars($_POST['id_detalles_curso'],ENT_QUOTES,'UTF-8');
$id_docente = htmlspecialchars($_POST['id_docente'],ENT_QUOTES,'UTF-8');
$id_asignatura = htmlspecialchars($_POST['id_asignatura'],ENT_QUOTES,'UTF-8');
$id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
$consulta = $MS->Modificar_Grupo($id_detalles_curso,$id_docente,$id_asignatura,$id_grupo);
echo $consulta;
?>