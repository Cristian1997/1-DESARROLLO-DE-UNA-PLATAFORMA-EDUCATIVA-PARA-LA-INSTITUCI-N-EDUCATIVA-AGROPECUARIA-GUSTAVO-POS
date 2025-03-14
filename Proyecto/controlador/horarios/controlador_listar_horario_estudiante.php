<?php
require '../../modelo/modelo_horarios.php';
$MH = new Modelo_Horarios();
$id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
$consulta = $MH->listar_horario_estudiante($id);
echo json_encode($consulta);

?>