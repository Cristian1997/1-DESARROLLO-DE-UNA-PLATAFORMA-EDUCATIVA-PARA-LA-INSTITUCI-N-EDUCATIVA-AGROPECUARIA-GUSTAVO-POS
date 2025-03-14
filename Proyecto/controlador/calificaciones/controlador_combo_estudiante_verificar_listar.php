<?php
require '../../modelo/modelo_calificaciones.php';
$MS = new Modelo_Calificaciones();
$id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
$consulta = $MS->listar_combo_estudiante_verifiar($id);
echo json_encode($consulta);
