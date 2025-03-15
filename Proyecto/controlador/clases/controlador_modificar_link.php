<?php
require '../../modelo/modelo_clases.php';

$MC = new Modelo_Clases();
$id_link = htmlspecialchars($_POST['id_link'],ENT_QUOTES,'UTF-8');
$linknuevo = htmlspecialchars($_POST['linknuevo'],ENT_QUOTES,'UTF-8');
$materia = htmlspecialchars($_POST['materia'],ENT_QUOTES,'UTF-8');
$fecha = htmlspecialchars($_POST['fecha'],ENT_QUOTES,'UTF-8');


$consulta = $MC->Editar_Link($id_link,$linknuevo,$materia,$fecha,);
echo $consulta;
 ?>
