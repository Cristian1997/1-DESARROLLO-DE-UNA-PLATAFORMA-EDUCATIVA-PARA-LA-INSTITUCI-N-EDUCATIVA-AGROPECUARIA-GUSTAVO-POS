<?php
require '../../modelo/modelo_asistencias.php';
$MD = new Modelo_Asistencias();

$id_asistencias = intval($_POST['id_asistencias']);
$id_docente = intval($_POST['id_docente']);
$id_grupo = intval($_POST['id_grupo']);
$dia = $_POST['dia'];
$asistencia = $_POST['asistencia'];
    
$consulta = $MD->Modificar_asistencias($id_asistencias, $dia, $asistencia, $id_grupo);  

if ($consulta) {
    $consulta1 = $MD->Registrar_asistencias($id_asistencias, $id_docente, $dia, $asistencia);  
}
  
echo $consulta;
?>
