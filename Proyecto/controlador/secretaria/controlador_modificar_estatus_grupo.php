<?php 

require '../../modelo/modelo_secretaria.php';
$MS = new Modelo_Secretaria();
$ID = htmlspecialchars($_POST['ID'],ENT_QUOTES,'UTF-8');
$status = htmlspecialchars($_POST['estatus'],ENT_QUOTES,'UTF-8');
$consulta = $MS->Modificar_Statatus_Grupo($ID,$status);
echo $consulta;
?>