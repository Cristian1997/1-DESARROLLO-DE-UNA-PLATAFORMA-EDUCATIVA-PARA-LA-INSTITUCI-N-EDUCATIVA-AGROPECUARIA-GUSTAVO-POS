<?php
    require '../../modelo/modelo_estudiante.php';
    $Me = new Modelo_Estudiante();
    $iddestudiante = htmlspecialchars($_POST['iddestudiante'],ENT_QUOTES,'UTF-8');
    $nombre = htmlspecialchars($_POST['nombre'],ENT_QUOTES,'UTF-8');
    $apellido = htmlspecialchars($_POST['apellido'],ENT_QUOTES,'UTF-8');
    $documentoactual = htmlspecialchars($_POST['documentoactual'],ENT_QUOTES,'UTF-8');
    $documentonuevo = htmlspecialchars($_POST['documentonuevo'],ENT_QUOTES,'UTF-8');
    $telefono = htmlspecialchars($_POST['telefono'],ENT_QUOTES,'UTF-8');
    $fecha = htmlspecialchars($_POST['fecha'],ENT_QUOTES,'UTF-8');
    $idusuario = htmlspecialchars($_POST['idusuario'],ENT_QUOTES,'UTF-8');
    $email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
    $sexo = htmlspecialchars($_POST['sexo'],ENT_QUOTES,'UTF-8');
    $grado = htmlspecialchars($_POST['grado'],ENT_QUOTES,'UTF-8');
    $consulta = $Me->Modificar_Estudiante($iddestudiante,$idusuario,$nombre,$apellido,$documentoactual,$documentonuevo,$telefono,$fecha,$email,$sexo,$grado);
    echo $consulta;
?>