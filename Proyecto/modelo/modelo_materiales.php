<?php
/* MODELO CONEXION BASE DE DATOS*/	
class Modelo_Material{
	private $conexion;
	function __construct(){
		require_once 'modelo_conexion.php';
		$this->conexion = new conexion();
		$this->conexion->conectar();
	}

	function listar_carpeta_materiales($id_usuario_es){
		$sql = "call SP_LISTAR_CARPETAS_MATERIALES('$id_usuario_es')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	function listar_datos_docente_materiales($id_usuario_es){
		$sql = "call SP_LISTAR_DATOS_DOCENTE_MATERIALES('$id_usuario_es')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	function listar_materiales($id_materiales){
		$sql = "call SP_LISTAR_MATERIALES('$id_materiales')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	public function registrar_nueva_carpeta_materiales($id_usuario, $titulo_carpeta) {
		$sql = "call SP_NUEVA_CARPETA_MATERIAL('$id_usuario', '$titulo_carpeta')";
		
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			$resultado = $consulta->fetch_assoc(); 
			return $resultado['result']; 
		} else {
			return 0; 
		}
	}

	public function editar_carpeta_materiales($id_usuario, $titulo_carpeta, $id_carpeta){
		$sql = "call SP_EDITAR_CARPETA_MATERIAL('$id_usuario', '$titulo_carpeta', '$id_carpeta')";
		

		if ($consulta = $this->conexion->conexion->query($sql)) {
			$resultado = $consulta->fetch_assoc(); 
			return $resultado['result']; 
		} else {
			return 0; 
		}
	}

	function nuevo_material_archivo($titulo_material,$id_material,$ruta){
		$sql = "call SP_RESGISTRAR_MATERIAL_ARCHIVO('$titulo_material','$id_material','$ruta')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
		
	} 	

	function editar_material_archivo($titulo_material,$id_material,$ruta){
		$sql = "call SP_EDITAR_MATERIAL_ARCHIVO('$titulo_material','$id_material','$ruta')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
		
	} 	

	function eliminar_material($id_material){
		$sql = "call SP_ELIMINAR_MATERIAL_ARCHIVO($id_material)";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
		
	} 	


	function Editar_estado_material(){
		$sql = "call SP_MODIFICAR_ESTADO_MATERIAL()";
		if ($consulta = $this->conexion->conexion->query($sql)) {
		  return 1;
		  
		}else{
		  return 0;
		}
	  }

//-----------------------NO PERTENECE------------------

	function listar_chat_integrantes_estudiantes($id_usuario_es){
		$sql = "call SP_LISTAR_CHAT_INTEGRANTES_ESTUDIANTES('$id_usuario_es')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	function listar_chat_integrantes_docentes($id_usuario_es){
		$sql = "call SP_LISTAR_CHAT_INTEGRANTES_DOCENTES('$id_usuario_es')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	function listar_chat_directo($id_chat){
		$sql = "call SP_LISTAR_CHAT_DIRECTO('$id_chat')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	function registrar_respuesta_chat($id_chat, $id_usuario, $comentario){
		$sql = "call SP_REGISTRAR_RESPUESTA_CHAT('$id_chat', '$id_usuario', '$comentario')";
		
		// Ejecutar la consulta SQL
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1; // Retorna 1 para indicar éxito
		} else {
			return 0; // Retorna 0 para indicar fallo
		}
	}
	
	public function registrar_nuevo_chat($id_usuario, $id_chat_nuevo) {
		$sql = "CALL SP_REGISTRAR_NUEVO_CHAT('$id_usuario', '$id_chat_nuevo')";
		
		// Ejecutar la consulta SQL
		if ($consulta = $this->conexion->conexion->query($sql)) {
			$resultado = $consulta->fetch_assoc(); // Obtener el resultado de la consulta
			return $resultado['result']; // Retorna el resultado del procedimiento almacenado
		} else {
			return 0; // Retorna 0 para indicar fallo
		}
	}

	public function modificar_chat_visto($id_chat_visto) {
		$sql = "CALL SP_MODIFICAR_CHAT_VISTO('$id_chat_visto')";
		
		// Ejecutar la consulta SQL
		if ($consulta = $this->conexion->conexion->query($sql)) {
			$resultado = $consulta->fetch_assoc(); // Obtener el resultado de la consulta
			return $resultado['result']; // Retorna el resultado del procedimiento almacenado
		} else {
			return 0; // Retorna 0 para indicar fallo
		}
	}

	public function modificar_chat_abierto($id_chat_abierto) {
		$sql = "CALL SP_MODIFICAR_CHAT_ABIERTO( '$id_chat_abierto')";
		
		// Ejecutar la consulta SQL
		if ($consulta = $this->conexion->conexion->query($sql)) {
			$resultado = $consulta->fetch_assoc(); // Obtener el resultado de la consulta
			return $resultado['result']; // Retorna el resultado del procedimiento almacenado
		} else {
			return 0; // Retorna 0 para indicar fallo
		}
	}

	function listar_chat_notificaciones($id_usuario_es){
		$sql = "call SP_LISTAR_CHAT_NOTIFICACIONES('$id_usuario_es')";
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
?>