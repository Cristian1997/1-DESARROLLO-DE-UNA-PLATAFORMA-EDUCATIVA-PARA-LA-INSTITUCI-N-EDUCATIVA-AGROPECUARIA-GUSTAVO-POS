<?php
    require '../../modelo/modelo_chat.php';
    $MC = new Modelo_Chat();
$id_chat = htmlspecialchars($_POST['id_chat'],ENT_QUOTES,'UTF-8');
$mensaje = htmlspecialchars($_POST['mensaje'],ENT_QUOTES,'UTF-8');
$id_usuario = htmlspecialchars($_POST['id_usuario'],ENT_QUOTES,'UTF-8');
$nombrefoto = htmlspecialchars($_POST['nombrearchivo'],ENT_QUOTES,'UTF-8');
if (empty($nombrefoto)) {
    $ruta = "controlador/chat/archivo/default.png";
} else{
    $ruta = "controlador/chat/archivo/". $nombrefoto;
}
$consulta = $MC->enviar_chat_archivo($id_chat,$mensaje,$id_usuario,$ruta);
echo $consulta;

if ($consulta == 1) {
   

    if (!empty($nombrefoto)) {
        if (move_uploaded_file($_FILES['archivo']["tmp_name"], "archivo/".$nombrefoto));

        
    }
}
?>