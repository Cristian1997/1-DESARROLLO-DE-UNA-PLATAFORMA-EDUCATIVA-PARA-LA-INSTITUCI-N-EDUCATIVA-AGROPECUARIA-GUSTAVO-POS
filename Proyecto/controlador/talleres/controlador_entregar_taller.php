<?php
require '../../modelo/modelo_talleres.php';

$MT = new Modelo_Talleres();
$id_taller = htmlspecialchars($_POST['id_taller'],ENT_QUOTES,'UTF-8');
$id_estudiante = htmlspecialchars($_POST['id_estudiante'],ENT_QUOTES,'UTF-8');
$nombrefoto = htmlspecialchars($_POST['nombrearchivo'],ENT_QUOTES,'UTF-8');
$nota = htmlspecialchars($_POST['nota'],ENT_QUOTES,'UTF-8');
if (empty($nombrefoto)) {
    $ruta = "controlador/talleres/archivo/default.png";
} else{
    $ruta = "controlador/talleres/archivo/". $nombrefoto;
}
$consulta = $MT->Entregar_taller($id_taller,$id_estudiante,$ruta,$nota);
echo $consulta;

if ($consulta == 1) {
   

    if (!empty($nombrefoto)) {
        if (move_uploaded_file($_FILES['archivo']["tmp_name"], "archivo/".$nombrefoto));

        
    }
}
