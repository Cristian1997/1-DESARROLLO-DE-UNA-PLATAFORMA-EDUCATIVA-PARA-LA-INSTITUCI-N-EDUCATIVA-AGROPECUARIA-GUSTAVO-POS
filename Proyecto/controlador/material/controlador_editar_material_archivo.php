<?php
require '../../modelo/modelo_materiales.php';
$MM = new Modelo_Material();
$archivo_actual = htmlspecialchars($_POST['archivo_actual'], ENT_QUOTES, 'UTF-8');
$titulo_material = htmlspecialchars($_POST['titulo_material'], ENT_QUOTES, 'UTF-8');
$id_material = htmlspecialchars($_POST['id_material'], ENT_QUOTES, 'UTF-8');
$nombrefoto = isset($_POST['nombrearchivo']) ? htmlspecialchars($_POST['nombrearchivo'], ENT_QUOTES, 'UTF-8') : null;

if (empty($nombrefoto)) {
    $ruta = $archivo_actual != "" ? $archivo_actual : "controlador/material/archivo/default.png";
} else {
    $ruta = "controlador/material/archivo/" . $nombrefoto;
}
$consulta =  $MM->editar_material_archivo($titulo_material, $id_material, $ruta);
echo $consulta;

if ($consulta == 1 && !empty($nombrefoto) && isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
    $archivo_tmp = $_FILES['archivo']['tmp_name'];
    $ruta_destino = "archivo/" . $nombrefoto;
    if (move_uploaded_file($archivo_tmp, $ruta_destino)) {
        // Archivo movido correctamente
    } else {
        // Manejar error al mover el archivo
    }
}
?>


