<?php
/* MODELO CONEXION BASE DE DATOS*/	
class Modelo_Trabajos{
	private $conexion;
	function __construct(){
		require_once 'modelo_conexion.php';
		$this->conexion = new conexion();
		$this->conexion->conectar();
	}

	function listar_Trabajos_entregados($id_grupo,$id_taller,$id_usuario){
		$sql = "call SP_LISTAR_TALLERES_ENTREGADOS('$id_grupo','$id_taller','$id_usuario')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}

	function listar_Trabajos_entregados_estudiante($id_usuario,$id_grupo){
		$sql = "call SP_LISTAR_TALLERES_ENTREGADOS_ESTUDIANTE('$id_usuario','$id_grupo')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}

	function registrar_nota($id_taller,$comentario){
		$sql = "call SP_REGISTRAR_NOTA('$id_taller', '$comentario')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
	}

	function listar_combo_talleres_verificar($id,$id_grupo){
		$sql = "call SP_LISTAR_COMBO_TALLER_VERIFITY('$id', '$id_grupo')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}
}
?>