<?php
require '../../modelo/modelo_materiales.php';
$MM = new Modelo_Material();
$consulta = $MM->Editar_estado_material();
echo $consulta;
?>