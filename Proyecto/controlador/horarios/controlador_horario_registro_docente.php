<?php
require '../../modelo/modelo_horarios.php';

$MH = new Modelo_Horarios();

$grado = htmlspecialchars($_POST['grado'], ENT_QUOTES, 'UTF-8');
$bloque_1 = htmlspecialchars($_POST['bloque_1'], ENT_QUOTES, 'UTF-8');
$bloque_2 = htmlspecialchars($_POST['bloque_2'], ENT_QUOTES, 'UTF-8');
$bloque_3 = htmlspecialchars($_POST['bloque_3'], ENT_QUOTES, 'UTF-8');
$bloque_4 = htmlspecialchars($_POST['bloque_4'], ENT_QUOTES, 'UTF-8');
$bloque_5 = htmlspecialchars($_POST['bloque_5'], ENT_QUOTES, 'UTF-8');
$bloque_6 = htmlspecialchars($_POST['bloque_6'], ENT_QUOTES, 'UTF-8');

$lunes_1 = htmlspecialchars($_POST['lunes_1'], ENT_QUOTES, 'UTF-8');
$lunes_2 = htmlspecialchars($_POST['lunes_2'], ENT_QUOTES, 'UTF-8');
$lunes_3 = htmlspecialchars($_POST['lunes_3'], ENT_QUOTES, 'UTF-8');
$lunes_4 = htmlspecialchars($_POST['lunes_4'], ENT_QUOTES, 'UTF-8');
$lunes_5 = htmlspecialchars($_POST['lunes_5'], ENT_QUOTES, 'UTF-8');
$lunes_6 = htmlspecialchars($_POST['lunes_6'], ENT_QUOTES, 'UTF-8');

$martes_1 = htmlspecialchars($_POST['martes_1'], ENT_QUOTES, 'UTF-8');
$martes_2 = htmlspecialchars($_POST['martes_2'], ENT_QUOTES, 'UTF-8');
$martes_3 = htmlspecialchars($_POST['martes_3'], ENT_QUOTES, 'UTF-8');
$martes_4 = htmlspecialchars($_POST['martes_4'], ENT_QUOTES, 'UTF-8');
$martes_5 = htmlspecialchars($_POST['martes_5'], ENT_QUOTES, 'UTF-8');
$martes_6 = htmlspecialchars($_POST['martes_6'], ENT_QUOTES, 'UTF-8');

$miercoles_1 = htmlspecialchars($_POST['miercoles_1'], ENT_QUOTES, 'UTF-8');
$miercoles_2 = htmlspecialchars($_POST['miercoles_2'], ENT_QUOTES, 'UTF-8');
$miercoles_3 = htmlspecialchars($_POST['miercoles_3'], ENT_QUOTES, 'UTF-8');
$miercoles_4 = htmlspecialchars($_POST['miercoles_4'], ENT_QUOTES, 'UTF-8');
$miercoles_5 = htmlspecialchars($_POST['miercoles_5'], ENT_QUOTES, 'UTF-8');
$miercoles_6 = htmlspecialchars($_POST['miercoles_6'], ENT_QUOTES, 'UTF-8');

$jueves_1 = htmlspecialchars($_POST['jueves_1'], ENT_QUOTES, 'UTF-8');
$jueves_2 = htmlspecialchars($_POST['jueves_2'], ENT_QUOTES, 'UTF-8');
$jueves_3 = htmlspecialchars($_POST['jueves_3'], ENT_QUOTES, 'UTF-8');
$jueves_4 = htmlspecialchars($_POST['jueves_4'], ENT_QUOTES, 'UTF-8');
$jueves_5 = htmlspecialchars($_POST['jueves_5'], ENT_QUOTES, 'UTF-8');
$jueves_6 = htmlspecialchars($_POST['jueves_6'], ENT_QUOTES, 'UTF-8');

$viernes_1 = htmlspecialchars($_POST['viernes_1'], ENT_QUOTES, 'UTF-8');
$viernes_2 = htmlspecialchars($_POST['viernes_2'], ENT_QUOTES, 'UTF-8');
$viernes_3 = htmlspecialchars($_POST['viernes_3'], ENT_QUOTES, 'UTF-8');
$viernes_4 = htmlspecialchars($_POST['viernes_4'], ENT_QUOTES, 'UTF-8');
$viernes_5 = htmlspecialchars($_POST['viernes_5'], ENT_QUOTES, 'UTF-8');
$viernes_6 = htmlspecialchars($_POST['viernes_6'], ENT_QUOTES, 'UTF-8');

$grado_lunes_1 = htmlspecialchars($_POST['grado_lunes_1'], ENT_QUOTES, 'UTF-8');
$grado_lunes_2 = htmlspecialchars($_POST['grado_lunes_2'], ENT_QUOTES, 'UTF-8');
$grado_lunes_3 = htmlspecialchars($_POST['grado_lunes_3'], ENT_QUOTES, 'UTF-8');
$grado_lunes_4 = htmlspecialchars($_POST['grado_lunes_4'], ENT_QUOTES, 'UTF-8');
$grado_lunes_5 = htmlspecialchars($_POST['grado_lunes_5'], ENT_QUOTES, 'UTF-8');
$grado_lunes_6 = htmlspecialchars($_POST['grado_lunes_6'], ENT_QUOTES, 'UTF-8');

$grado_martes_1 = htmlspecialchars($_POST['grado_martes_1'], ENT_QUOTES, 'UTF-8');
$grado_martes_2 = htmlspecialchars($_POST['grado_martes_2'], ENT_QUOTES, 'UTF-8');
$grado_martes_3 = htmlspecialchars($_POST['grado_martes_3'], ENT_QUOTES, 'UTF-8');
$grado_martes_4 = htmlspecialchars($_POST['grado_martes_4'], ENT_QUOTES, 'UTF-8');
$grado_martes_5 = htmlspecialchars($_POST['grado_martes_5'], ENT_QUOTES, 'UTF-8');
$grado_martes_6 = htmlspecialchars($_POST['grado_martes_6'], ENT_QUOTES, 'UTF-8');

$grado_miercoles_1 = htmlspecialchars($_POST['grado_miercoles_1'], ENT_QUOTES, 'UTF-8');
$grado_miercoles_2 = htmlspecialchars($_POST['grado_miercoles_2'], ENT_QUOTES, 'UTF-8');
$grado_miercoles_3 = htmlspecialchars($_POST['grado_miercoles_3'], ENT_QUOTES, 'UTF-8');
$grado_miercoles_4 = htmlspecialchars($_POST['grado_miercoles_4'], ENT_QUOTES, 'UTF-8');
$grado_miercoles_5 = htmlspecialchars($_POST['grado_miercoles_5'], ENT_QUOTES, 'UTF-8');
$grado_miercoles_6 = htmlspecialchars($_POST['grado_miercoles_6'], ENT_QUOTES, 'UTF-8');

$grado_jueves_1 = htmlspecialchars($_POST['grado_jueves_1'], ENT_QUOTES, 'UTF-8');
$grado_jueves_2 = htmlspecialchars($_POST['grado_jueves_2'], ENT_QUOTES, 'UTF-8');
$grado_jueves_3 = htmlspecialchars($_POST['grado_jueves_3'], ENT_QUOTES, 'UTF-8');
$grado_jueves_4 = htmlspecialchars($_POST['grado_jueves_4'], ENT_QUOTES, 'UTF-8');
$grado_jueves_5 = htmlspecialchars($_POST['grado_jueves_5'], ENT_QUOTES, 'UTF-8');
$grado_jueves_6 = htmlspecialchars($_POST['grado_jueves_6'], ENT_QUOTES, 'UTF-8');

$grado_viernes_1 = htmlspecialchars($_POST['grado_viernes_1'], ENT_QUOTES, 'UTF-8');
$grado_viernes_2 = htmlspecialchars($_POST['grado_viernes_2'], ENT_QUOTES, 'UTF-8');
$grado_viernes_3 = htmlspecialchars($_POST['grado_viernes_3'], ENT_QUOTES, 'UTF-8');
$grado_viernes_4 = htmlspecialchars($_POST['grado_viernes_4'], ENT_QUOTES, 'UTF-8');
$grado_viernes_5 = htmlspecialchars($_POST['grado_viernes_5'], ENT_QUOTES, 'UTF-8');
$grado_viernes_6 = htmlspecialchars($_POST['grado_viernes_6'], ENT_QUOTES, 'UTF-8');

$consulta = $MH->Registrar_Horario_Docente($grado, $bloque_1, $bloque_2, $bloque_3, $bloque_4, $bloque_5, $bloque_6,
    $lunes_1, $lunes_2, $lunes_3, $lunes_4, $lunes_5, $lunes_6,
    $martes_1, $martes_2, $martes_3, $martes_4, $martes_5, $martes_6,
    $miercoles_1, $miercoles_2, $miercoles_3, $miercoles_4, $miercoles_5, $miercoles_6,
    $jueves_1, $jueves_2, $jueves_3, $jueves_4, $jueves_5, $jueves_6,
    $viernes_1, $viernes_2, $viernes_3, $viernes_4, $viernes_5, $viernes_6,
    $grado_lunes_1, $grado_lunes_2, $grado_lunes_3, $grado_lunes_4, $grado_lunes_5, $grado_lunes_6,
    $grado_martes_1, $grado_martes_2, $grado_martes_3, $grado_martes_4, $grado_martes_5, $grado_martes_6,
    $grado_miercoles_1, $grado_miercoles_2, $grado_miercoles_3, $grado_miercoles_4, $grado_miercoles_5, $grado_miercoles_6,
    $grado_jueves_1, $grado_jueves_2, $grado_jueves_3, $grado_jueves_4, $grado_jueves_5, $grado_jueves_6,
    $grado_viernes_1, $grado_viernes_2, $grado_viernes_3, $grado_viernes_4, $grado_viernes_5, $grado_viernes_6
);


if ($consulta == 1) {
    // Nuevo horario registrado correctamente
    echo 1;
} elseif ($consulta == -1) {
    // El id_curso ya existe, manejar este caso
    echo -1;
} else {
    // Error al registrar el horario
    echo 0;
}
?>
