<?php
require '../../modelo/modelo_talleres.php';

$MT = new Modelo_Talleres();
$id_taller = htmlspecialchars($_POST['id_taller'],ENT_QUOTES,'UTF-8');
$date = htmlspecialchars($_POST['fecha'],ENT_QUOTES,'UTF-8');
$consulta = $MT->Editar_Fechas($id_taller,$date);
echo $consulta;

