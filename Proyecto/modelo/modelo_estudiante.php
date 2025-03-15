  <?php  
 class Modelo_Estudiante{
  private $conexion;
  function __construct(){
      require_once 'modelo_conexion.php';
      $this->conexion = new conexion();
      $this->conexion->conectar();
  }

      function listar_estudiante(){
        $sql = "call SP_LISTAR_ESTUDIANTES()";
        $arreglo = array();
        if ($consulta = $this->conexion->conexion->query($sql)) {
          while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
            $arreglo["data"][] = $consulta_VU;
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

    function listar_combo_grado_docente(){
      $sql = "call SP_LISTAR_COMBO_GRADO_DOCENTE()";
      $arreglo = array();
      if ($consulta = $this->conexion->conexion->query($sql)) {
        while ($consulta_VU = mysqli_fetch_array($consulta)) {
                        $arreglo[] = $consulta_VU;
        }
        return $arreglo;
        $this->conexion->cerrar();
      }
  }

    function Registrar_Estudiantes($documento,$nombre,$apellido,$fecha,$telefono,$sexo,$email,$grado,$usuario,$contra){
      $sql = "call SP_REGISTRAR_ESTUDIANTES('$documento','$nombre','$apellido','$fecha','$telefono','$sexo','$email','$grado','$usuario','$contra')";
      if ($consulta = $this->conexion->conexion->query($sql)) {
        if ($row = mysqli_fetch_array($consulta)) {
            return $id= trim($row[0]);
        }
        $this->conexion->cerrar();
      }
    }

    function Modificar_Estudiante($iddestudiante,$idusuario,$nombre,$apellido,$documentoactual,$documentonuevo,$telefono,$fecha,$email,$sexo,$grado){
      $sql = "call SP_MODIFICAR_ESTUDIANTES('$iddestudiante','$idusuario','$nombre','$apellido','$documentoactual','$documentonuevo','$telefono','$fecha','$email','$sexo','$grado')";
      if ($consulta = $this->conexion->conexion->query($sql)) {
        if ($row = mysqli_fetch_array($consulta)) {
            return $id= trim($row[0]);
        }
        $this->conexion->cerrar();
      }
    }
}
?>