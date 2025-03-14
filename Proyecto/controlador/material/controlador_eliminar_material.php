<?php
require '../../modelo/modelo_materiales.php';
$MM = new Modelo_Material();
$id_material = htmlspecialchars($_POST['id_material'], ENT_QUOTES, 'UTF-8');
$archivo_actual = htmlspecialchars($_POST['archivo_actual'], ENT_QUOTES, 'UTF-8');

// Eliminar el material de la base de datos
$consulta = $MM->eliminar_material($id_material);
$response = intval($consulta); // Convertir el resultado a entero antes de imprimirlo

// Si la eliminación en la base de datos fue exitosa, proceder a eliminar el archivo del sistema de archivos
if ($consulta == 1 && !empty($archivo_actual)) {
    $ruta_archivo = "archivo/" . $archivo_actual;
    
    if (file_exists($ruta_archivo)) {
        if (unlink($ruta_archivo)) {
            // Si se eliminó correctamente, devolver solo el código de respuesta
            $response = 1;
        } else {
            // Si hubo un problema al eliminar el archivo, devolver un código de error
            $response = 0;
        }
    } else {
        // Si el archivo no existe, devolver un código de error
        $response = 0;
    }
}

echo $response; // Devolver solo el código de respuesta
?>

