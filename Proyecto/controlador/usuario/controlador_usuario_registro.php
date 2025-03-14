<?php
    require '../../modelo/modelo_usuario.php';

    $MU = new Modelo_Usuario();
    $usuario = htmlspecialchars($_POST['u'],ENT_QUOTES,'UTF-8');
    $contra = password_hash($_POST['c'],PASSWORD_DEFAULT,['cost'=>10]);
    $sexo = htmlspecialchars($_POST['s'],ENT_QUOTES,'UTF-8');
    $rol = htmlspecialchars($_POST['r'],ENT_QUOTES,'UTF-8');
    $email = htmlspecialchars($_POST['e'],ENT_QUOTES,'UTF-8');
    $nombrefoto = htmlspecialchars($_POST['nombrefoto'],ENT_QUOTES,'UTF-8');
if (empty($nombrefoto)) {
    $ruta = "controlador/usuario/foto/default.png";
} else{
    $ruta = "controlador/usuario/foto/". $nombrefoto;
}


$consulta = $MU->Registrar_Usuario($usuario,$contra,$sexo,$rol,$email,$ruta);
echo $consulta;
if ($consulta == 1) {
    if (!empty($nombrefoto)) {
        if (move_uploaded_file($_FILES['foto']["tmp_name"], "foto/".$nombrefoto));

        
    }
}
 