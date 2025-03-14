<?php
    require '../../modelo/modelo_materiales.php';
    $MM = new Modelo_Material();
    
    $id_usuario = htmlspecialchars($_POST['id_usuario'], ENT_QUOTES, 'UTF-8');
    $titulo_carpeta = htmlspecialchars($_POST['titulo_carpeta'], ENT_QUOTES, 'UTF-8');
 
    $consulta = $MM->registrar_nueva_carpeta_materiales($id_usuario, $titulo_carpeta);
    echo intval($consulta); // Convertir el resultado a entero antes de imprimirlo
?>
