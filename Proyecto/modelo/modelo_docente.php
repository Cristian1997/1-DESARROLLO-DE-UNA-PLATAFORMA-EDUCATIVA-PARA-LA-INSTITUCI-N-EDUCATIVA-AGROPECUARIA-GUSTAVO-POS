  <?php  
 class Modelo_Docente{
  private $conexion;
  function __construct(){
      require_once 'modelo_conexion.php';
      $this->conexion = new conexion();
      $this->conexion->conectar();
  }

      function listar_docente(){
        $sql = "call SP_LISTAR_DOCENTES()";
        $arreglo = array();
        if ($consulta = $this->conexion->conexion->query($sql)) {
          while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
            $arreglo["data"][] = $consulta_VU;
           }
          return $arreglo;
        $this->conexion->cerrar();
        }
        
      }

 

  
    function Registrar_Docente($nombre,$apellido,$documento,$telefono,$fecha,$usu,$contra,$email,$sexo){
      $sql = "call SP_REGISTRAR_DOCENTE('$nombre','$apellido','$documento','$telefono','$fecha','$usu','$contra','$email','$sexo')";
      if ($consulta = $this->conexion->conexion->query($sql)) {
        if ($row = mysqli_fetch_array($consulta)) {
            return $id= trim($row[0]);
        }
        $this->conexion->cerrar();
      }
    }

    function Modificar_Docente($iddocente,$idusuario,$nombre,$apellido,$documentoactual,$documentonuevo,$telefono,$fecha,$email,$sexo){
      $sql = "call SP_MODIFICAR_DOCENTE('$iddocente','$idusuario','$nombre','$apellido','$documentoactual','$documentonuevo','$telefono','$fecha','$email','$sexo')";
      if ($consulta = $this->conexion->conexion->query($sql)) {
        if ($row = mysqli_fetch_array($consulta)) {
            return $id= trim($row[0]);
        }
        $this->conexion->cerrar();
      }
    }

function TraerDatos($usuario){
  $sql = "call SP_TRAER_DATOS_DOCENTE('$usuario')";
  $arreglo = array();
  if ($consulta = $this->conexion->conexion->query($sql)) {
    while ($consulta_VU = mysqli_fetch_array($consulta)) {
          $arreglo[]= $consulta_VU;
    } 
    return $arreglo;
    $this->conexion->cerrar();
  }
}
}

  