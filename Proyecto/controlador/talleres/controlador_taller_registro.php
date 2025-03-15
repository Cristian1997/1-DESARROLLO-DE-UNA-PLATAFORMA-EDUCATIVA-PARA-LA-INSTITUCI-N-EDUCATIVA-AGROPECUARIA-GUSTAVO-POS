<?php
require '../../modelo/modelo_talleres.php';

$MT = new Modelo_Talleres();
$id_docente = htmlspecialchars($_POST['id_docente'],ENT_QUOTES,'UTF-8');
$id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
$titulo = htmlspecialchars($_POST['titulo'],ENT_QUOTES,'UTF-8');
$fecha = htmlspecialchars($_POST['fechas'],ENT_QUOTES,'UTF-8');
$descripcion = htmlspecialchars($_POST['descripcion'],ENT_QUOTES,'UTF-8');
$nombrefoto = htmlspecialchars($_POST['nombrefoto'],ENT_QUOTES,'UTF-8');
if (empty($nombrefoto)) {
    $ruta = "controlador/talleres/archivo/default.png";
} else{
    $ruta = "controlador/talleres/archivo/". $nombrefoto;
}
$consulta = $MT->Registrar_taller($id_docente,$titulo,$descripcion,$id_grupo,$fecha,$ruta);
echo $consulta;

if ($consulta == 1) {
     

    if (!empty($nombrefoto)) {
        if (move_uploaded_file($_FILES['archivo']["tmp_name"], "archivo/".$nombrefoto));

        
    }
}
?>