<?php
    require '../../modelo/modelo_foro.php';
    $MF = new Modelo_Foro();
 
$consulta = $MF->Editar_estado_foro();
echo $consulta;

?>