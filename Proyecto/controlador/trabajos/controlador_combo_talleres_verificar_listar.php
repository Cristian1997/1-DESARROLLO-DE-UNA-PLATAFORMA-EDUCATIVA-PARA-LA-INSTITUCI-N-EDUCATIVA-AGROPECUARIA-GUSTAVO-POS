<?php
require '../../modelo/modelo_trabajos.php';
$MS = new Modelo_Trabajos();
$id = htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8');
$id_grupo = htmlspecialchars($_POST['id_grupo'],ENT_QUOTES,'UTF-8');
$consulta = $MS->listar_combo_talleres_verificar($id,$id_grupo);
echo json_encode($consulta);
