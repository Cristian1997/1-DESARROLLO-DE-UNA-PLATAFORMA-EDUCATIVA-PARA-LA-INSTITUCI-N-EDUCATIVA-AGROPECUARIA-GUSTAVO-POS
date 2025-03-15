<?php 

require '../../modelo/modelo_usuario.php';
$MU = new Modelo_Usuario();

$id_usuario = htmlspecialchars($_POST['ID'],ENT_QUOTES,'UTF-8');
$nombrefoto = htmlspecialchars($_POST['nombrefoto'],ENT_QUOTES,'UTF-8');

if (empty($nombrefoto)) {
	$ruta = "controlador/usuario/foto/default.png";
} else{
	$ruta = "controlador/usuario/foto/". $nombrefoto;
}


$consulta = $MU->Editar_usuario_foto($id_usuario,$ruta);
echo $consulta;
if ($consulta == 1) {
	if (!empty($nombrefoto)) {
		if (move_uploaded_file($_FILES['foto']["tmp_name"], "foto/".$nombrefoto));
				
		
	}
}
?>
