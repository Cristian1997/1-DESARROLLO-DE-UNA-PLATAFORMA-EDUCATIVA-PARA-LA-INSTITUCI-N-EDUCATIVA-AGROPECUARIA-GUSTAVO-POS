
<?php
/* MODELO CONEXION BASE DE DATOS*/	
    class Modelo_Usuario{
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
        function listar_usuario(){
            $sql = "call SP_LISTAR_USUARIO()";
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
        function listar_combo_rol(){
            $sql = "call SP_LISTAR_COMBO_ROL()";
			$arreglo = array();
			if ($consulta = $this->conexion->conexion->query($sql)) {
				while ($consulta_VU = mysqli_fetch_array($consulta)) {
                        $arreglo[] = $consulta_VU;
				}
				return $arreglo;
				$this->conexion->cerrar();
			}
		}
/* MODELO LISTAR ROL-LLAMADA LISTAR ROLES*/	

/* MODELO MODIFICAR ESTATUS USUARIOS-LLAMADA MODIFICAR ESTATUS USUARIOS*/		
		function Modificar_Estatus_Usuario($idusuario,$estatus){
            $sql = "call SP_MODIFICAR_ESTATUS_USUARIO('$idusuario','$estatus')";
			if ($consulta = $this->conexion->conexion->query($sql)) {
				return 1;
				
			}else{
				return 0;
			}
        }
/* MODELO MODIFICAR ESTATUS USUARIOS-LLAMADA MODIFICAR ESTATUS USUARIOS*/

/* MODELO MODIFICAR CONTRA USUARIO-LLAMADA MODIFICAR CONTRA USUARIO*/		
function Modificar_Contra_Usuario($idusuario,$contranu){
	$sql = "call SP_MODIFICAR_CONTRA_USUARIO('$idusuario','$contranu')";
	if ($consulta = $this->conexion->conexion->query($sql)) {
		return 1;
		
	}else{
		return 0;
	}
}

/* MODELO MODIFICAR CONTRA USUARIO-LLAMADA MODIFICAR CONTRA USUARIO*/		


/* MODELO MODIFICAR USUARIOS-LLAMADA MODIFICAR USUARIOS*/		
function Modificar_Datos_Usuario($idusuario,$sexo,$rol,$email){
	$sql = "call SP_MODIFICAR_DATOS_USUARIO('$idusuario','$sexo','$rol','$email')";
	if ($consulta = $this->conexion->conexion->query($sql)) {
		return 1;
		
	}else{
		return 0;
	}
}
function Editar_usuario_foto($id_usuario,$ruta){
	$sql = "call SP_MODIFICAR_USUARIO_FOTO('$id_usuario','$ruta')";
	if ($consulta = $this->conexion->conexion->query($sql)) {
		return 1;
		
	}else{
		return 0;
	}
}

/* MODELO MODIFICAR ESTATUS USUARIOS-LLAMADA MODIFICAR ESTATUS USUARIOS*/

/* MODELO REGISTRAR USUARIOS-LLAMADA REGISTRAR USUARIOS*/
        function Registrar_Usuario($usuario,$contra,$sexo,$rol,$email,$ruta){
            $sql = "call SP_REGISTRAR_USUARIO('$usuario','$contra','$sexo','$rol','$email','$ruta')";
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


function Modificar_Intento_Usuario($usuario){
	$sql = "call SP_INTENTO_USUARIO('$usuario')";
	if ($consulta = $this->conexion->conexion->query($sql)) {
		if ($row = mysqli_fetch_array($consulta)) {
				return $id= trim($row[0]);
		}
		$this->conexion->cerrar();
	}
}


}

