<?php
/* MODELO CONEXION BASE DE DATOS*/	
class Modelo_Foro{
	private $conexion;
	function __construct(){
		require_once 'modelo_conexion.php';
		$this->conexion = new conexion();
		$this->conexion->conectar();
	}

	function listar_foro($id_asignatura,$id_grado,$id_usuario_doc){
		$sql = "call SP_LISTAR_FORO('$id_asignatura','$id_grado','$id_usuario_doc')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	function Listar_comentarios_foro($id_grupo, $id_foro){
		$sql = "call SP_LISTAR_FORO_COMENTARIOS('$id_grupo','$id_foro')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	function Listar_comentarios_foro_respuestas($id_foro, $id_principal) {
		$sql = "CALL SP_LISTAR_FORO_COMENTARIOS_RESPUESTAS('$id_foro', '$id_principal')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}
	
	public function eliminarComentario($id_comentario_us) {
        $sql = "CALL SP_ELIMINAR_COMENTARIO_FORO($id_comentario_us)";
        if ($consulta = $this->conexion->conexion->query($sql)) {
            return 1; // Éxito
        } else {
            return 0; // Error
        }
    }

	public function Eliminarcomentario_respuesta($id_comentario_us) {
        $sql = "CALL SP_ELIMINAR_COMENTARIO_FORO_RESPUESTA($id_comentario_us)";
        if ($consulta = $this->conexion->conexion->query($sql)) {
            return 1; // Éxito
        } else {
            return 0; // Error
        }
	}

	function Registrar_Foro($id_docente, $id_grupo, $fecha_limite, $tema_foro, $descripcion_foro){
		$sql = "call SP_REGISTRAR_FORO('$id_docente','$id_grupo','$fecha_limite','$tema_foro','$descripcion_foro')";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
		} else {
			return 0;
		}
	}

	public function Registrar_comentario_foro($id_foro, $id_grupo, $id_docente, $comentario) {
		$sql = "CALL SP_REGISTRAR_COMENTARIO_FORO('$id_foro', '$id_grupo','$id_docente','$comentario')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function registrar_comentario_foro_respuesta($id_foro, $id_docente, $id_principal, $comentario, $id_responde_a){
		$sql = "CALL SP_REGISTRAR_COMENTARIO_FORO_RESPUESTA('$id_foro','$id_docente','$id_principal','$comentario','$id_responde_a')";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
		} else {
			// Manejo de errores
			echo "Error al ejecutar el procedimiento almacenado: " . $this->conexion->conexion->error;
			return 0;
		}
	}
	
	function Editar_Foro($id_docente, $id_grupo, $id_foro, $tema_foro, $descripcion_foro){
		$sql = "call SP_EDITAR_FORO('$id_docente','$id_grupo','$id_foro','$tema_foro','$descripcion_foro')";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
		} else {
			return 0;
		}
	}

	function Editar_estado_foro(){
		$sql = "call SP_MODIFICAR_ESTADO_FORO()";
		if ($consulta = $this->conexion->conexion->query($sql)) {
		  return 1;
		  
		}else{
		  return 0;
		}
	  }

	  function Editar_Fechas($id_foros,$date){
		$sql = "call SP_MODIFICAR_ESTADO_FECHAS_FORO('$id_foros','$date')";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
	}

	function Editar_comentario_foro($id_foro_cometario, $comentario){
		$sql = "call SP_MODIFICAR_COMENTARIO_FORO('$id_foro_cometario','$comentario')";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
	}

	function Editar_comentario_foro_respuesta($id_foro_cometario, $comentario){
		$sql = "call SP_MODIFICAR_COMENTARIO_FORO_RESPUESTA('$id_foro_cometario','$comentario')";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
	}
	
	function TraerNotificacionesforoes($id_usuario){
		$sql = "call SP_TRAER_NOTIFICACIONES_FORO_ESTUDIANTES('$id_usuario')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
		
	function TraerNotificacionesforodoc($id_usuario){
		$sql = "call SP_TRAER_NOTIFICACIONES_FORO_DOCENTES('$id_usuario')";
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