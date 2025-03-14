<?php
require '../../modelo/modelo_calificaciones.php';
$MC             = new Modelo_Calificaciones();
$id_estudiante = htmlspecialchars($_POST['id_estudiante'], ENT_QUOTES, 'UTF-8');
$id_docente = htmlspecialchars($_POST['id_docente'], ENT_QUOTES, 'UTF-8');
$arreglo        = explode(",", $id_estudiante); //se paro los datos
for ($i = 0; $i < count($arreglo); $i++) {
    $consulta = $MC->Registrar_Estudiantes($arreglo[$i],$id_docente);
}

echo $consulta;
