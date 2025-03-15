<?php
require '../../modelo/modelo_clases.php';
$MC = new Modelo_Clases();
$id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
$estado = htmlspecialchars($_POST['estado'],ENT_QUOTES,'UTF-8');
$consulta = $MC->modificar_estado($id,$estado);
echo $consulta;
?>