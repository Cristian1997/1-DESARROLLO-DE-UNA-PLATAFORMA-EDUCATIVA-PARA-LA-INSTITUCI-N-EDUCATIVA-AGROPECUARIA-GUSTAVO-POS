<?php
    require '../../modelo/modelo_docente.php';
    $MD = new Modelo_Docente();
    $nombre = htmlspecialchars($_POST['nombre'],ENT_QUOTES,'UTF-8');
    $apellido = htmlspecialchars($_POST['apellido'],ENT_QUOTES,'UTF-8');
    $documento = htmlspecialchars($_POST['documento'],ENT_QUOTES,'UTF-8');
    $telefono = htmlspecialchars($_POST['telefono'],ENT_QUOTES,'UTF-8');
    $fecha = htmlspecialchars($_POST['fecha'],ENT_QUOTES,'UTF-8');
    $usu = htmlspecialchars($_POST['usu'],ENT_QUOTES,'UTF-8');
    $contra = password_hash($_POST['contra'],PASSWORD_DEFAULT,['cost'=>10]);
    $email = htmlspecialchars($_POST['email'],ENT_QUOTES,'UTF-8');
    $sexo = htmlspecialchars($_POST['sexo'],ENT_QUOTES,'UTF-8');
    $consulta = $MD->Registrar_Docente($nombre,$apellido,$documento,$telefono,$fecha,$usu,$contra,$email,$sexo);
    echo $consulta;
