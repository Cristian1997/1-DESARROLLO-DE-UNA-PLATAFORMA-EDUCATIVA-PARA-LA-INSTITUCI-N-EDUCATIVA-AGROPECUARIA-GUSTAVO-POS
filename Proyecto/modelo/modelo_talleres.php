
<?php
/* MODELO CONEXION BASE DE DATOS*/	
class Modelo_Talleres{
	private $conexion;
	function __construct(){
		require_once 'modelo_conexion.php';
		$this->conexion = new conexion();
		$this->conexion->conectar();
	}

	function listar_talleres($id_asignatura,$id_grado,$id_usuario_doc){
		$sql = "call SP_LISTAR_TALLERES('$id_asignatura','$id_grado','$id_usuario_doc')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
	function listar_talleres_estudiantes($id_grupo,$id_usuario_doc,$id_usuario_es){
		$sql = "call SP_LISTAR_TALLERES_ESTUDIANTES('$id_grupo','$id_usuario_doc','$id_usuario_es')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	


	public function listar_comentarios_estudiantes($id_grupo,$id_usuario_doc,$id_usuario_es){
		$sql = "call SP_LISTAR_ESTUDIANTE_COMENTARIOS('$id_grupo','$id_usuario_doc','$id_usuario_es')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
	public function listar_comentarios_docentes($id_grupo,$id_usuario_doc,$id_usuario_es){
		$sql = "call SP_LISTAR_RESPUESTAS_COMENTARIOS_ESTUDIANTES('$id_grupo','$id_usuario_doc','$id_usuario_es')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	
	function listar_combo_grupo($id){
		$sql = "call SP_LISTAR_COMBO_MIS_GRUPOS('$id')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	function listar_combo_docente($id){
		$sql = "call SP_LISTAR_COMBO_DOCENTES_COMENTARIOS('$id')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
	
	function TraerNotificaciones($id){
		$sql = "call SP_TRAER_NOTIFICACIONES('$id')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}		

	function TraerNotificacionestalleres($id_usuario){
		$sql = "call SP_TRAER_NOTIFICACIONES_ESTUDIANTES('$id_usuario')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	function listar_estudiante_comentarios($id_docente,$id_usuario){
		$sql = "call SP_LISTAR_COMENTARIOS_ESTUDIANTES('$id_docente','$id_usuario')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}		

	function listar_docente_comentarios($id_estudiante,$id_usuario){
		$sql = "call SP_LISTAR_DOCENTES_COMENTARIOS('$id_estudiante','$id_usuario')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
	
	function listar_comentarios_estudiantes_asunto($id_usuario_es){
		$sql = "call SP_LISTAR_ASUNTOS_ESTUDIANTE('$id_usuario_es')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	function listar_comentarios_docente_asunto($id_usuario_es){
		$sql = "call SP_LISTAR_ASUNTOS_DOCENTE('$id_usuario_es')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
	
	
	
	function TraerDatos_fechas_talleres(){
		$sql = "call SP_LISTAR_FECHA_TALLERES()";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}



	
	function Registrar_taller($id_docente,$titulo,$descripcion,$id_grupo,$fecha,$ruta){
		$sql = "call SP_RESGISTRAR_NUEVO_TALLER('$id_docente' , '$titulo', '$descripcion', '$fecha', '$id_grupo','$ruta' )";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
		
	} 	
	function Entregar_taller($id_taller,$id_estudiante,$ruta,$nota){
		$sql = "call SP_RESGISTRAR_ENTREGAR_TALLER('$id_taller','$id_estudiante','$ruta','$nota')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
		
	} 	


	function registrar_respuesta($id_comentario,$respuesta){
		$sql = "call SP_EDITAR_RESPUESTA('$id_comentario' , '$respuesta')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
		
	} 	


	function registrar_respuesta_estudiante($id_comentario,$respuesta){
		$sql = "call SP_EDITAR_RESPUESTA_ES('$id_comentario' , '$respuesta')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
		
	} 	

	function registrar_respuesta_docente($id_comentario,$respuesta){
		$sql = "call SP_EDITAR_RESPUESTA_DOCENTE('$id_comentario' , '$respuesta')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
		
	} 	
	
	
	function registrar_respuesta_estudiante_asunto($id_comentario,$respuesta){
		$sql = "call SP_EDITAR_RESPUESTA_ES_ASUNTO('$id_comentario' , '$respuesta')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
		
	} 	




	function Notificaciones($id_comentario,$id_docente,$id_grupo){
		$sql = "call SP_REGISTRAR_RESPUESTA('$id_comentario' , '$id_docente','$id_grupo')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
		
	} 
	function Editar_taller($id_taller,$id_docente,$titulo,$descripcion,$id_grupo,$ruta){
		$sql = "call SP_MODIFICAR_TALLER('$id_taller','$id_docente' , '$titulo', '$descripcion','$id_grupo','$ruta' )";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
		
		

	}
	function registrar_comentarios($id_taller,$id_usuario_es,$comentario){
		$sql = "call SP_REGISTRAR_COMENTARIO('$id_taller' , '$id_usuario_es', '$comentario')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
	}
	function registrar_comentarios_asunto($id_docente, $id_usuario_es, $asunto, $comentario) {
		$sql = "CALL SP_REGISTRAR_COMENTARIO_ASUNTO('$id_docente', '$id_usuario_es', '$asunto', '$comentario')";
		
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
		} else {
			return 0;
		}
	}
	
	function Editar_estado(){
		$sql = "call SP_MODIFICAR_ESTADO_TALLER()";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
		
		

	}

	function Editar_Fechas($id_taller,$date){
		$sql = "call SP_MODIFICAR_ESTADO_FECHAS('$id_taller','$date')";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;
			
		}else{
			return 0;
		}
		
		

	}
	
	
}