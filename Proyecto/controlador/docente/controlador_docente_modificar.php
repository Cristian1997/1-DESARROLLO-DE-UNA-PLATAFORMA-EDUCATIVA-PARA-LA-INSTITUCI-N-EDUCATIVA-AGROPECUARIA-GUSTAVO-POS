<?php
    require '../../modelo/modelo_docente.php';
    $MD = new Modelo_Docente();
    $iddocente = htmlspecialchars($_POST['iddocente'],ENT_QUOTES,'UTF-8');
    $nombre = htmlspecialchars($_POST['nombre'],ENT_QUOTES,'UTF-8');
    $apellido = htmlspecialchars($_POST['apellido'],ENT_QUOTES,'UTF-8');
    $documentoactual = htmlspecialchars($_POST['documentoactual'],ENT_QUOTES,'UTF-8');
    $documentonuevo = htmlspecialchars($_POST['documentonuevo'],ENT_QUOTES,'UTF-8');
    $telefono = htmlspecialchars($_POST['telefono'],ENT_QUOTES,'UTF-8');
    $fecha = htmlspecialchars($_POST['fecha'],ENT_QUOTES,'UTF-8');
    $idusuario = htmlspecialchars($_POST['idusuario'],ENT_QUOTES,'UTF-8');
    $email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
    $sexo = htmlspecialchars($_POST['sexo'],ENT_QUOTES,'UTF-8');
    $consulta = $MD->Modificar_Docente($iddocente,$idusuario,$nombre,$apellido,$documentoactual,$documentonuevo,$telefono,$fecha,$email,$sexo);
    echo $consulta;
?>