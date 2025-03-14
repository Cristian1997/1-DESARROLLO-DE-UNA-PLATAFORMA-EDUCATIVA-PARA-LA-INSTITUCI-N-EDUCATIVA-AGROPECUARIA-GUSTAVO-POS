<?php
require '../../modelo/modelo_grupos.php';
$MG = new Modelo_Grupos();
$id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
$id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
$consulta = $MG->listar_combo_asignatura($id,$id_grupo);
echo json_encode($consulta);
