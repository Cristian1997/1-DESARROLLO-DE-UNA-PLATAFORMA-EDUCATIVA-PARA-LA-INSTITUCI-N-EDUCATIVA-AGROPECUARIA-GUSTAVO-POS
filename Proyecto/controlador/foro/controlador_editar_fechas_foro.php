<?php
    require '../../modelo/modelo_foro.php';
    $MF = new Modelo_Foro();
$id_foros = htmlspecialchars($_POST['id_foros'],ENT_QUOTES,'UTF-8');
$date = htmlspecialchars($_POST['fecha'],ENT_QUOTES,'UTF-8');
$consulta = $MF->Editar_Fechas($id_foros,$date);
echo $consulta;

?>