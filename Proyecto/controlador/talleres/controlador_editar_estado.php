<?php
require '../../modelo/modelo_talleres.php';

$MT = new Modelo_Talleres();
 
$consulta = $MT->Editar_estado();
echo $consulta;

?>