<?php
require '../../modelo/modelo_secretaria.php';

$MS = new Modelo_Secretaria();
$docente = htmlspecialchars($_POST['docente'],ENT_QUOTES,'UTF-8');
$asignatura = htmlspecialchars($_POST['asignatura'],ENT_QUOTES,'UTF-8');
$grupo = htmlspecialchars($_POST['grupo'],ENT_QUOTES,'UTF-8');
$consulta = $MS->Registrar_Grupo($docente,$asignatura,$grupo);
echo $consulta;

