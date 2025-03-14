<?php
require '../../modelo/modelo_chat.php';
$MC = new Modelo_Chat();
$id_chat_abierto = json_decode($_POST['id_chat_abierto']); // Decodificar la cadena JSON
$respuesta = array(); // Crear una respuesta para cada ID procesado

// Iterar sobre cada ID de chat y modificar su estado
foreach ($id_chat_abierto as $id) {
    $consulta = $MC->modificar_chat_abierto($id);
    $respuesta[] = $consulta; // Agregar la respuesta al array de respuesta
}

echo json_encode($respuesta); // Enviar la respuesta como JSON

?>
