<?php 
require '../../modelo/modelo_estudiante.php';
$ME = new Modelo_Estudiante();

$documento = htmlspecialchars($_POST['documento'],ENT_QUOTES,"UTF-8");
$nombre = htmlspecialchars($_POST['nombre'],ENT_QUOTES,"UTF-8");
$apellido = htmlspecialchars($_POST['apellido'],ENT_QUOTES,"UTF-8");
$fecha = htmlspecialchars($_POST['fecha'],ENT_QUOTES,"UTF-8");
$telefono = htmlspecialchars($_POST['telefono'],ENT_QUOTES,"UTF-8");
$sexo= htmlspecialchars($_POST['sexo'],ENT_QUOTES,"UTF-8");
$email = htmlspecialchars($_POST['email'],ENT_QUOTES,"UTF-8");
$grado = htmlspecialchars($_POST['grado'],ENT_QUOTES,"UTF-8");
$usuario = htmlspecialchars($_POST['usu'],ENT_QUOTES,"UTF-8");
$contra = password_hash($_POST['contra'],PASSWORD_DEFAULT,['cost'=>10]);
$consulta = $ME->Registrar_Estudiantes($documento,$nombre,$apellido,$fecha,$telefono,$sexo,$email,$grado,$usuario,$contra);
echo $consulta; 

