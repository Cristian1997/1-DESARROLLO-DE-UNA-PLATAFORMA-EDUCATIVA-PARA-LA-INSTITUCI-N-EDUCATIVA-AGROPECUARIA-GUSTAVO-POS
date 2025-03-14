<?php
require '../../modelo/modelo_clases.php';

$MC = new Modelo_Clases();
 
$consulta = $MC->Editar_estado_link();
echo $consulta;

