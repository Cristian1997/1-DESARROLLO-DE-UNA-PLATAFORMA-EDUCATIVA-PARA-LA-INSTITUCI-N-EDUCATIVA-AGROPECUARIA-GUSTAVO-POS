
<?php
/* MODELO CONEXION BASE DE DATOS*/	
class Modelo_Secretaria{
	private $conexion;
	function __construct(){
		require_once 'modelo_conexion.php';
		$this->conexion = new conexion();
		$this->conexion->conectar();
	}
	/* MODELO CONEXION BASE DE DATOS*/		

	/* MODELO VERIFICAR USUARIOS-LLAMADA VERIFICAR USUARIOS*/
	function VerificarUsuario($usuario,$contra){
		$sql = "call SP_VERIFICAR_USUARIO('$usuario')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				if(password_verify($contra, $consulta_VU["usu_contrasena"]))
				{
					$arreglo[] = $consulta_VU;
				}
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}
	/* MODELO VERIFICAR USUARIOS-LLAMADA VERIFICAR USUARIOS*/

	/* MODELO TRAERDATOS USUARIOS-LLAMADA TRAERDATOS USUARIOS*/
	function TraerDatos($usuario){
		$sql = "call SP_VERIFICAR_USUARIO('$usuario')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[]= $consulta_VU;
			} 
			return $arreglo;
			$this->conexion->cerrar();
		}
	}
	/* MODELO TRAERDATOS USUARIOS-LLAMADA TRAERDATOS USUARIOS*/

	/* MODELO TRAERDATOS CONTADOR-LLAMADA TRAERDATOS CONTADOR*/
	function TraerDatosContador(){
		$sql = "call SP_CONTADOR()";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo[]= $consulta_VU;
			} 
			return $arreglo;
			$this->conexion->cerrar();
		}
	}
	/* MODELO TRAERDATOS CONTADOR-LLAMADA TRAERDATOS CONTADOR*/

	/* MODELO LISTAR USUARIOS-LLAMADA LISTAR USUARIOS*/
	function listar_grupos(){
		$sql = "call SP_LISTAR_DETALLES_CURSOS()";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
	// FALATA ESTE PROCEDIMIENTO
	function listar_grupo($id_grupo,$id_docente){
		$sql = "call SP_LISTAR_ASIGNACION_ESTUDIANTES('$id_grupo','$id_docente')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}
	/* MODELO LISTAR USUARIOS-LLAMADA LISTAR USUARIOS*/

	/* MODELO LISTAR ROL-LLAMADA LISTAR ROLES*/		
	function listar_combo_docente(){
		$sql = "call SP_LISTAR_COMBO_DOCENTE()";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
	function listar_combo_docentes(){
		$sql = "call SP_LISTAR_COMBO_DOCENTE()";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}
	function listar_combo_grado(){
		$sql = "call SP_LISTAR_COMBO_GRADO()";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
		function listar_combo_asignatura(){
		$sql = "call SP_LISTAR_COMBO_ASIGNATURAS()";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	function listar_combo_grupo($id_docente){
		$sql = "call SP_LISTAR_COMBO_GRUPOS('$id_docente')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}
// FALATA ESTE PROCEDIMIENTO
	function listar_combo_grupo_estudiante($id_docente,$id_curso,$id_aula){
		$sql = "call SP_COMBO_ESTUDIANTE_LISTAR('$id_docente', '$id_curso','$id_aula')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
// FALATA ESTE PROCEDIMIENTO
	function listar_combo_grupo_verifity($id_grupo){
		$sql = "call SP_LISTAR_GRUPO_VERIFICAR('$id_grupo')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
	function listar_combo_estudiante_verifity($id_estudiante){
		$sql = "call SP_LISTAR_COMBO_ESTUDIANTE_VERIFITY('$id_estudiante')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

		function listar_combo_calificaciones_estudiante($id_estudiante){
		$sql = "call SP_LISTAR_COMBO_CALIFICACIONES('$id_estudiante')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	

	function listar_combo_grupos(){
		$sql = "call SP_COMBO_GRUPO_LISTAR()";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	


		function Registrar_Grupo($id_docente,$id_asignatura,$id_grupo){
		$sql = "call SP_REGISTRAR_GRUPO('$id_docente','$id_asignatura','$id_grupo')";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			if ($row = mysqli_fetch_array($consulta)) {
				return $id= trim($row[0]);
			}
			$this->conexion->cerrar();
		}
	}


	function Modificar_Grupo($id_detalles_curso,$id_docente,$id_asignatura,$id_grupo){
		$sql = "call SP_MODIFICAR_GRUPOS('$id_detalles_curso','$id_docente','$id_asignatura','$id_grupo')";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			if ($row = mysqli_fetch_array($consulta)) {
				return $id= trim($row[0]);
			}
			$this->conexion->cerrar();
		}
	}
	/* MODELO REGISTRAR USUARIOS-LLAMADA REGISTRAR USUARIOS*/

	/* MODELO REGISTRAR USUARIOS-LLAMADA REGISTRAR USUARIOS*/
	function Restablecer_Contra($email,$contra){
		$sql = "call SP_RESTABLECER_CONTRA('$email','$contra')";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			if ($row = mysqli_fetch_array($consulta)) {
				return $id= trim($row[0]);
			}
			$this->conexion->cerrar();
		}
	}



		function Registrar_Estudiantes($id_calificaciones,$id_docente,$id_grupo){
		$sql = "call SP_REGISTRAR_ESTUDIANTES_GRUPOS('$id_calificaciones','$id_docente','$id_grupo')";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			if ($row = mysqli_fetch_array($consulta)) {
				return $id= trim($row[0]);
			}
			$this->conexion->cerrar();
		}
	}

	
}

