<?php
    require '../../modelo/modelo_materiales.php';
    $MM = new Modelo_Material();
$titulo_material = htmlspecialchars($_POST['titulo_material'],ENT_QUOTES,'UTF-8');
$id_material = htmlspecialchars($_POST['id_material'],ENT_QUOTES,'UTF-8');
$nombrefoto = htmlspecialchars($_POST['nombrearchivo'],ENT_QUOTES,'UTF-8');
if (empty($nombrefoto)) {
    $ruta = "controlador/material/archivo/default.png";
} else{
    $ruta = "controlador/material/archivo/". $nombrefoto;
}
$consulta =  $MM ->nuevo_material_archivo($titulo_material,$id_material,$ruta);
echo $consulta;

if ($consulta == 1) {
   

    if (!empty($nombrefoto)) {
        if (move_uploaded_file($_FILES['archivo']["tmp_name"], "archivo/".$nombrefoto));

        
    }
}
?>