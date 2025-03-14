<?php
require '../../modelo/modelo_talleres.php';

$MT = new Modelo_Talleres();
$id_taller = htmlspecialchars($_POST['id_taller'],ENT_QUOTES,'UTF-8');
$id_docente = htmlspecialchars($_POST['id_docente'],ENT_QUOTES,'UTF-8');
$id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
$titulo = htmlspecialchars($_POST['titulo'],ENT_QUOTES,'UTF-8');
$descripcion = htmlspecialchars($_POST['descripcion'],ENT_QUOTES,'UTF-8');
$ruta = htmlspecialchars($_POST['url'],ENT_QUOTES,'UTF-8');

$consulta = $MT->Editar_taller($id_taller,$id_docente,$titulo,$descripcion,$id_grupo,$ruta);
echo $consulta;
