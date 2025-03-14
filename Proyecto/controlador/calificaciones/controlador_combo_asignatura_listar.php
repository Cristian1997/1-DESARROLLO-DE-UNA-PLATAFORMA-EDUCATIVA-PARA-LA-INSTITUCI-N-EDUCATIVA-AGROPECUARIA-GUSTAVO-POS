<?php
require '../../modelo/modelo_calificaciones.php';
$MS = new Modelo_Calificaciones();
$id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
$id_asignatura = htmlspecialchars($_POST['id_asignatura'],ENT_QUOTES,'UTF-8');
$consulta = $MS->listar_combo_asignatura($id,$id_asignatura);
echo json_encode($consulta);
