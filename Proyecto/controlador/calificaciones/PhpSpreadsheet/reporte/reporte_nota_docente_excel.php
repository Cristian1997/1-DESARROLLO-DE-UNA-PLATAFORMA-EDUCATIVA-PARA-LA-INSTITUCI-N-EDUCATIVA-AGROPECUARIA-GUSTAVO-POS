<?php
require_once __DIR__ . '/../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;

// Obtener los datos de POST
$data = json_decode($_POST['data'], true);

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Establecer los estilos para las celdas
$headerStyle = [
    'font' => [
        'bold' => true,
        'size' => 12,
    ],
    'alignment' => [
        'horizontal' => Alignment::HORIZONTAL_CENTER,
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
    'fill' => [
        'fillType' => Fill::FILL_SOLID,
        'startColor' => [
            'argb' => 'FFA0A0A0',
        ],
    ],
];

$dataStyle = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
        ],
    ],
    'alignment' => [
        'vertical' => Alignment::VERTICAL_CENTER,
    ],
];

// Agregar información adicional
$sheet->setCellValue('A1', 'Docente: ' . $data[0]['docente']);
$sheet->setCellValue('A2', 'Nombre del Curso: ' . $data[0]['nombre']);
$sheet->setCellValue('A3', 'Aula: ' . $data[0]['aula']);
$sheet->mergeCells('A1:G1');
$sheet->mergeCells('A2:G2');
$sheet->mergeCells('A3:G3');

// Aplicar estilo a las celdas de información adicional
$sheet->getStyle('A1:G1')->applyFromArray($headerStyle);
$sheet->getStyle('A2:G2')->applyFromArray($headerStyle);
$sheet->getStyle('A3:G3')->applyFromArray($headerStyle);

// Establecer encabezados de columna
$sheet->setCellValue('A5', 'Estudiante');
$sheet->setCellValue('B5', 'Primera Nota');
$sheet->setCellValue('C5', 'Segunda Nota');
$sheet->setCellValue('D5', 'Tercera Nota');
$sheet->setCellValue('E5', 'Cuarta Nota');
$sheet->setCellValue('F5', 'Nota Definitiva');
$sheet->setCellValue('G5', 'Estado');

// Aplicar estilo a los encabezados
$sheet->getStyle('A5:G5')->applyFromArray($headerStyle);

// Ajustar el ancho de las columnas
$sheet->getColumnDimension('A')->setWidth(25);
$sheet->getColumnDimension('B')->setWidth(15);
$sheet->getColumnDimension('C')->setWidth(15);
$sheet->getColumnDimension('D')->setWidth(15);
$sheet->getColumnDimension('E')->setWidth(15);
$sheet->getColumnDimension('F')->setWidth(15);
$sheet->getColumnDimension('G')->setWidth(15);

$rowIndex = 6;
foreach ($data as $row) {
    $estado = ($row['nota_def'] >= 3.0) ? 'APROBADO' : 'REPROBADO';

    $sheet->setCellValue('A' . $rowIndex, $row['Estudiante']);
    $sheet->setCellValue('B' . $rowIndex, $row['primera_nota']);
    $sheet->setCellValue('C' . $rowIndex, $row['segunda_nota']);
    $sheet->setCellValue('D' . $rowIndex, $row['tercera_nota']);
    $sheet->setCellValue('E' . $rowIndex, $row['cuarta_nota']);
    $sheet->setCellValue('F' . $rowIndex, $row['nota_def']);
    $sheet->setCellValue('G' . $rowIndex, $estado);

    $sheet->getStyle('A' . $rowIndex . ':G' . $rowIndex)->applyFromArray($dataStyle);
    $rowIndex++;
}

$writer = new Xlsx($spreadsheet);
$filename = 'reporte_notas.xlsx';

// Enviar el archivo Excel como respuesta
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Cache-Control: max-age=0');

$writer->save('php://output');
?>