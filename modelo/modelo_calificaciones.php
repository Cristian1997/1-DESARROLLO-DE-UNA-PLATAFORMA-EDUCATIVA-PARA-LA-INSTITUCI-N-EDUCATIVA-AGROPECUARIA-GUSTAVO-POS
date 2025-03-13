
<?php
/* MODELO CONEXION BASE DE DATOS*/	
class Modelo_Calificaciones{
	private $conexion;
	function __construct(){
		require_once 'modelo_conexion.php';
		$this->conexion = new conexion();
		$this->conexion->conectar();
	}

	function listar_calificaciones($id_asignatura,$id_grado,$id_usuario_doc,$id_grupo,$id_docente){
		$sql = "call SP_LISTAR_CALIFICACIONES('$id_asignatura','$id_grado','$id_usuario_doc','$id_grupo','$id_docente')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
	function listar_Notas($id_usuario_es,$id_grupo,$id_docente){
		$sql = "call SP_LISTAR_NOTAS_ESTUDIANTES('$id_usuario_es','$id_grupo','$id_docente')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
				$arreglo["data"][]=$consulta_VU;

			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}

	
	function listar_notas_admin(){
        $sql = "call SP_LISTAR_NOTAS_ADMIN()";
        $arreglo = array();
        if ($consulta = $this->conexion->conexion->query($sql)) {
          while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
            $arreglo["data"][] = $consulta_VU;
           }
          return $arreglo;
        $this->conexion->cerrar();
        }
        
      }


	function listar_combo_grado($id,$id_grupo){
		$sql = "call SP_LISTAR_COMBO_GRADOS('$id','$id_grupo')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
	function listar_combo_estudiante($id_grado,$id_asignatura,$id_docente){
		$sql = "call SP_LISTAR_COMBO_ESTUDIANTE('$id_asignatura','$id_grado','$id_docente')";
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
		$sql = "call SP_LISTAR_COMBO_DOCENTES('$id')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}		
	function listar_combo_estudiante_verifiar($id){
		$sql = "call SP_LISTAR_COMBO_ESTUDIANTE_VERIFITY('$id')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}		

	function listar_combo_docente_verificar($id){
		$sql = "call SP_LISTAR_COMBO_DOCENTE_VERIFITY_CALIFICACIONES('$id')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
	function listar_combo_docentes_verificar($id){
		$sql = "call SP_LISTAR_COMBO_DOCENTE_VERIFITY('$id')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}	
	function listar_combo_asignatura($id,$id_asignatura){
		$sql = "call SP_LISTAR_COMBO_GRUPO('$id','$id_asignatura')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}
	function listar_combo_Materia($id){
		$sql = "call SP_LISTAR_COMBO_MATERIA('$id')";
		$arreglo = array();
		if ($consulta = $this->conexion->conexion->query($sql)) {
			while ($consulta_VU = mysqli_fetch_array($consulta)) {
				$arreglo[] = $consulta_VU;
			}
			return $arreglo;
			$this->conexion->cerrar();
		}
	}


	function Modificar_Calificaciones($id_calificaciones,$nota_1,$nota_2,$nota_3,$nota_4){
		$sql = "call SP_MODIFICAR_CALIFICACIONES('$id_calificaciones','$nota_1','$nota_2','$nota_3' , '$nota_4')";
		if ($consulta = $this->conexion->conexion->query($sql)) {
			return 1;

		}else{
			return 0;
		}

	}




}