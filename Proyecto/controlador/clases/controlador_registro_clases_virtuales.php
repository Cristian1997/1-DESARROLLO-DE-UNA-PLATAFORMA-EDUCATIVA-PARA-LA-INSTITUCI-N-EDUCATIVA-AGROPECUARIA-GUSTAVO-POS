<?php
require '../../modelo/modelo_clases.php';
$MC = new Modelo_Clases();
$fecha = htmlspecialchars($_POST['fecha_registro'],ENT_QUOTES,'UTF-8');
$id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
$id_docente = htmlspecialchars($_POST['id_docente'],ENT_QUOTES,'UTF-8');
$link = htmlspecialchars($_POST['link'],ENT_QUOTES,'UTF-8');
$consulta = $MC->Registrar_Clases_virtuales($fecha,$id_grupo,$id_docente,$link);
echo $consulta;


