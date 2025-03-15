<?php
    require '../../modelo/modelo_trabajos.php';
    $MT = new Modelo_Trabajos();
    
$id_taller = htmlspecialchars($_POST['id_taller'],ENT_QUOTES,'UTF-8');
$comentario = htmlspecialchars($_POST['comentario'],ENT_QUOTES,'UTF-8');
$consulta = $MT->registrar_nota($id_taller,$comentario);

echo $consulta;
?>
