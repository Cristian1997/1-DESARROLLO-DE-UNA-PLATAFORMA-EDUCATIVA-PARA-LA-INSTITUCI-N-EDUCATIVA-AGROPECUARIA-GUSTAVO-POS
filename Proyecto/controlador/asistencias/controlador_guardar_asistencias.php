<?php
require '../../modelo/modelo_asistencias.php';

$id_asistencia = intval($_POST['id_asistencia']);
$id_docente = intval($_POST['id_docente']);
$id_grupo = intval($_POST['id_grupo']);
$asistencia = $_POST['asistencia'];
$dia = $_POST['dia'];

$MD = new Modelo_Asistencias();

$consulta = $MD->Modificar_asistencia($id_asistencia, $dia, $asistencia, $id_grupo);

if ($consulta == 1) {
    // La asistencia se modificó correctamente
    $consulta1 = $MD->Registrar_asistencia_detalle($id_asistencia, $id_docente, $dia, $asistencia);
    if ($consulta1 == 1) {
        // El detalle de la asistencia se registró correctamente
        echo 1;
    } else {
        // Error al registrar el detalle de la asistencia
        echo 0;
    }
} else {
    // Error al modificar la asistencia
    echo 0;
}
?>
