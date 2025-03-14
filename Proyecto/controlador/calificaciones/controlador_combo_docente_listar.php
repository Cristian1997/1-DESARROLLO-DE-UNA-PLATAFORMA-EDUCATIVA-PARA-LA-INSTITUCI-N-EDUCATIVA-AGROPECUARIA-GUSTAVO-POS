<?php
require '../../modelo/modelo_calificaciones.php';
$MS = new Modelo_Calificaciones();
$id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
$consulta = $MS->listar_combo_docente($id);
echo json_encode($consulta);
