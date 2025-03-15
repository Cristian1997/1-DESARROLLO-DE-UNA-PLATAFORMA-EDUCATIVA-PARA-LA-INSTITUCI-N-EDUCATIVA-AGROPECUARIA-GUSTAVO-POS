<?php
require '../../modelo/modelo_secretaria.php';
$MS             = new Modelo_Secretaria();
$id_calificaciones = htmlspecialchars($_POST['id_calificaciones'], ENT_QUOTES, 'UTF-8');
$id_docente = htmlspecialchars($_POST['id_docente'], ENT_QUOTES, 'UTF-8');
$id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');

    $consulta = $MS->Registrar_Estudiantes($id_calificaciones,$id_docente,$id_grupo);

echo $consulta;
?>