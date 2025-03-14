
<?php
/* MODELO CONEXION BASE DE DATOS*/	
class Modelo_Grupos{
	private $conexion;
	function __construct(){
		require_once 'modelo_conexion.php';
		$this->conexion = new conexion();
		$this->conexion->conectar();
	}

	function listar_grupos($id_asignatura,$id_grado,$id_usuario_doc){
		$sql = "call SP_LISTAR_GRUPO('$id_asignatura','$id_grado','$id_usuario_doc')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}

	
	function listar_combo_asignatura($id,$id_grupo){
		$sql = "call SP_LISTAR_COMBO_GRUPO('$id','$id_grupo')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}

	function listar_grupos_estudiante($id_asignatura,$id_grado){
		$sql = "call SP_LISTAR_GRUPO_ESTUDIANTES2('$id_asignatura','$id_grado')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}


}