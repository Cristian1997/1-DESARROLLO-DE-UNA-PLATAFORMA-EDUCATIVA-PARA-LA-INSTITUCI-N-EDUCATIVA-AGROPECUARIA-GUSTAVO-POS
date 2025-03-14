<?php
require_once __DIR__ . '/../vendor/autoload.php';

// Establecer la zona horaria a utilizar
date_default_timezone_set('America/Bogota');

// Obtener la fecha actual en formato de 12 horas con "am" o "pm"
$fecha_actual = date('Y-m-d h:i:s A');

// Obtener los datos de POST
$data = json_decode($_POST['data'], true);

$mpdf = new \Mpdf\Mpdf();

// Ruta de la imagen del logo
$logo = __DIR__ . '/logo_instituto.png';

$html = '<div style="position: absolute; top: 20px; left: 20px;">';
$html .= '<img src="' . $logo . '" style="width: 150px; height: auto;">';
$html .= '</div>';

$html .= '<div style="position: absolute; top: 100px; left: 20px; font-size: 10px;">';
$html .= '<h3 style="margin: 0;">Docente: ' . $data[0]['docente'] . '</h3>';
$html .= '<h3 style="margin: 0;">Nombre del Curso: ' . $data[0]['nombre'] . '</h3>';
$html .= '<h3 style="margin: 0;">Aula: ' . $data[0]['aula'] . '</h3>';
$html .= '</div>';

$html .= '<div style="position: absolute; top: 20px; right: 20px; font-size: 10px;">Fecha de Emisión: ' . $fecha_actual . '</div>';

$html .= '<h1 style="text-align: center; font-size: 14px; margin-top: 240px;">Reporte de Notas</h1>';

$html .= '<table border="1" cellspacing="0" cellpadding="5" style="font-size: 12px; margin-top: 100px;">
            <tr>
                <th>Estudiante</th>
                <th>Primera Nota</th>
                <th>Segunda Nota</th>
                <th>Tercera Nota</th>
                <th>Cuarta Nota</th>
                <th>Nota Definitiva</th>
                <th>Estado</th>
            </tr>';

foreach ($data as $row) {
    $estado = ($row['nota_def'] >= 3.0) ? '<span style="color: green;">APROBADO</span>' : '<span style="color: red;">REPROBADO</span>';
    
    $html .= '<tr>';
    $html .= '<td>' . $row['Estudiante'] . '</td>';
    $html .= '<td>' . $row['primera_nota'] . '</td>';
    $html .= '<td>' . $row['segunda_nota'] . '</td>';
    $html .= '<td>' . $row['tercera_nota'] . '</td>';
    $html .= '<td>' . $row['cuarta_nota'] . '</td>';
    $html .= '<td>' . $row['nota_def'] . '</td>';
    $html .= '<td>' . $estado . '</td>';
    $html .= '</tr>';
}

$html .= '</table>';

$mpdf->WriteHTML($html);

// Obtener el contenido del PDF en formato base64
$pdf_content = $mpdf->Output('', 'S');

// Devolver el contenido del PDF en base64
echo base64_encode($pdf_content);
?>
