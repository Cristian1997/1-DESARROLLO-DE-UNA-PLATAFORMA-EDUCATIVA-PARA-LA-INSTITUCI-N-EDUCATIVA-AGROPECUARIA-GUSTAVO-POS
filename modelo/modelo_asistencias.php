
<?php
/* MODELO CONEXION BASE DE DATOS*/	
class Modelo_Asistencias{
	private $conexion;
	function __construct(){
		require_once 'modelo_conexion.php';
		$this->conexion = new conexion();
		$this->conexion->conectar();
	}

	function listar_asistencias($id_asignatura,$id_grado,$id_usuario_doc,$id_grupo){
		$sql = "call SP_LISTAR_ASISTENCIAS('$id_asignatura','$id_grado','$id_usuario_doc','$id_grupo')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}

	function listar_deatelles_asistencias($id_asignatura,$id_grado,$id_usuario_doc,$id_estudiantes){
		$sql = "call SP_LISTAR_DETALLES_ASISTENCIAS('$id_asignatura','$id_grado','$id_usuario_doc' , '$id_estudiantes')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}

	function listar_deatelles_asistencias_ES($id_ES,$id_curso){
		$sql = "call SP_LISTAR_DETALLES_ASISTENCIAS_ESTUDIANTE('$id_ES','$id_curso')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}

	function listar_combo_grado($id){
		$sql = "call SP_LISTAR_COMBO_GRADOS('$id')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
	function listar_combo_asignatura($id){
		$sql = "call SP_LISTAR_COMBO_GRUPOS('$id')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}
	function TraerDatos_fechas_Asistencias(){
		$sql = "call SP_LISTAR_FECHA_ASISTENCIAS()";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}


	
	function Modificar_asistencia($id_asistencia, $dia, $asistencia, $id_grupo){
		$sql = "CALL SP_MODIFICAR_ASISTENCIAS('$id_asistencia','$dia','$asistencia','$id_grupo')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1; // Éxito
		} else {
			return 0; // Error
		}
	} 
	
	function Registrar_asistencia_detalle($id_asistencia, $id_docente, $dia, $asistencia)
	{
		$sql = "CALL SP_REGISTRAR_ASISTENCIAS('$id_asistencia', '$id_docente', '$dia', '$asistencia')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1; // Éxito
		} else {
			return 0; // Error
		}
	}
	

		function Asistencias_Modificar($dia,$asistencia){
		$sql = "call SP_ACTUIALIZAR_ASISTENCIAS( '$dia','$asistencia')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}

	}  
	
	function TraerDatos_Asistencias_Generales($id_usuario_doc ,   $id_asignatura ,    $id_grado ){
		$sql = "call SP_CONTADOR_ASISTENCIAS_GENERALES('$id_asignatura' , '$id_grado' , '$id_usuario_doc')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[]= $consulta_VU;
			} 
			return $arreglo;
			$this->conexion->cerrar();
		}
	}
	function TraerDatos_Asistencias_Espefificas($id_ES,$id_grupo){
		$sql = "call SP_CONTADOR_ASISTENCIAS_ESPECIFICAS('$id_ES','$id_grupo')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[]= $consulta_VU;
			} 
			return $arreglo;
			$this->conexion->cerrar();
		}
	}
	function listar_combo_estudiantes($id_usuario_doc,$id_asignatura,$id_grado){
		$sql = "call SP_LISTAR_COMBO_ESTUDIANTES('$id_asignatura' , '$id_grado' , '$id_usuario_doc')";
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