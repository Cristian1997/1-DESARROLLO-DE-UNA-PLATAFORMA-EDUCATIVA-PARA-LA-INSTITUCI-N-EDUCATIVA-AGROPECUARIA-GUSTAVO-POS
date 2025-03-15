  <?php  
 class Modelo_Cursos{
  private $conexion;
  function __construct(){
      require_once 'modelo_conexion.php';
      $this->conexion = new conexion();
      $this->conexion->conectar();
  }

      function listar_cursos(){
        $sql = "call SP_LISTAR_CURSOS()";
        $arreglo = array();
        if ($consulta = $this->conexion->conexion->query($sql)) {
          while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
            $arreglo["data"][] = $consulta_VU;
           }
          return $arreglo;
        $this->conexion->cerrar();
        }
      }
  
    function Registrar_Asignatura($nombre){
      $sql = "call SP_REGISTRAR_ASIGNATURAS('$nombre')";
      if ($consulta = $this->conexion->conexion->query($sql)) {
        if ($row = mysqli_fetch_array($consulta)) {
            return $id= trim($row[0]);
        }
        $this->conexion->cerrar();
      }
    }

    function Modificar_Asignatura($idasignatura,$nombre){
      $sql = "call SP_MODIFICAR_ASIGNATURA('$idasignatura','$nombre')";
      if ($consulta = $this->conexion->conexion->query($sql)) {
       return 1;
        
      }else{
        return 0;
      }
     
    }

       function Modificar_Estatus_Asgnatura($ID,$estatus){
      $sql = "call SP_MODIFICAR_STATUS_ASIGNATURA('$ID','$estatus')";
      if ($consulta = $this->conexion->conexion->query($sql)) {
       return 1;
        
      }else{
        return 0;
      }
    }
}
?>