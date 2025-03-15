<?php
    require '../../modelo/modelo_clases.php';
    $MC = new Modelo_Clases();
    $id_clases = htmlspecialchars($_POST['c'],ENT_QUOTES,'UTF-8');
    $id_grupo = htmlspecialchars($_POST['g'],ENT_QUOTES,'UTF-8');
    $id_docente = htmlspecialchars($_POST['p'],ENT_QUOTES,'UTF-8');
    $titulo = htmlspecialchars($_POST['t'],ENT_QUOTES,'UTF-8');
    $descripcion = htmlspecialchars($_POST['d'],ENT_QUOTES,'UTF-8');
    $nombrevideo = htmlspecialchars($_POST['nombrevideo'],ENT_QUOTES,'UTF-8');
if (empty($nombrevideo)) {
    $ruta = "controlador/clases/videos/default.png";
} else{
    $ruta = "controlador/clases/videos/". $nombrevideo;
}


$consulta = $MC->Editar_Clases($id_clases,$id_docente,$titulo,$descripcion,$id_grupo,$ruta);
echo $consulta;
if ($consulta == 1) {
    if (!empty($nombrevideo)) {
        if (move_uploaded_file($_FILES['video']["tmp_name"], "videos/".$nombrevideo));

        
    }
}
?>