  <?php  
  class Modelo_Clases{
    private $conexion;
    function __construct(){
      require_once 'modelo_conexion.php';
      $this->conexion = new conexion();
      $this->conexion->conectar();
    }

    function listar_clases($idusuario,$id_grado,$id_grupo,$id_asignatura){
      $sql ="CALL SP_LISTAR_REGISTRO_CLASES('$idusuario','$id_grado','$id_grupo','$id_asignatura')";
      $arreglo = array();
      if ($consulta = $this->conexion->conexion->query($sql)) {
        while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
          $arreglo["data"][] = $consulta_VU;
        }
        return $arreglo;
        $this->conexion->cerrar();
      }
      
    } 

    function listar_grabaciones_de_clases($id_grupo,$idusuario){
      $sql ="CALL SP_LISTAR_GRABACIONES_CLASES('$id_grupo', '$idusuario')";
      $arreglo = array();
      if ($consulta = $this->conexion->conexion->query($sql)) {
        while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
          $arreglo["data"][] = $consulta_VU;
        }
        return $arreglo;
        $this->conexion->cerrar();
      }
      
    } 
     function listar_videoconferencia_de_clases($id_grupo,$idusuario){
      $sql ="CALL SP_LISTAR_VIDEOCONFERENCIAS('$id_grupo', '$idusuario')";
      $arreglo = array();
      if ($consulta = $this->conexion->conexion->query($sql)) {
        while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
          $arreglo["data"][] = $consulta_VU;
        }
        return $arreglo;
        $this->conexion->cerrar();
      }
      
    }

    function listar_clases_virtuales($idusuario,$id_grupo){
      $sql ="CALL SP_LISTAR_ASIGNACION_CLASES('$idusuario','$id_grupo')";
      $arreglo = array();
      if ($consulta = $this->conexion->conexion->query($sql)) {
        while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
          $arreglo["data"][] = $consulta_VU;
        }
        return $arreglo;
        $this->conexion->cerrar();
      }
      
    }
    function Registrar_Clases_virtuales($fecha,$id_grupo,$id_docente,$link){
      $sql = "call SP_REGISTRAR_ASIGNACION_CLASES('$id_docente','$id_grupo','$link','$fecha')";
      if ($consulta = $this->conexion->conexion->query($sql)) {
         return 1;

      }else{
        return 0;
      }
      
    } 
    function Registrar_Clases($fecha,$id_grupo,$id_docente,$titulo,$descripcion,$ruta){
      $sql = "call SP_REGISTRAR_CLASES('$fecha','$id_grupo','$id_docente','$titulo','$descripcion','$ruta')";
      if ($consulta = $this->conexion->conexion->query($sql)) {
        if ($row = mysqli_fetch_array($consulta)) {
          return $id= trim($row[0]);
        }
        $this->conexion->cerrar();
      }
    }

    function Editar_Clases($id_clases,$id_docente,$titulo,$descripcion,$id_grupo,$ruta){
      $sql = "call SP_MODIFICAR_ClASES('$id_clases','$id_docente' , '$titulo', '$descripcion','$id_grupo','$ruta' )";

      if ($consulta = $this->conexion->conexion->query($sql)) {
        return 1;

      }else{
        return 0;
      }

      } 


     function modificar_estado($id,$estado){
      $sql = "call SP_MODIFICAR_ESTADO('$id','$estado')";

      if ($consulta = $this->conexion->conexion->query($sql)) {
        return 1;

      }else
      {
        return 0;
      }

    }

    function Editar_estado_link(){
      $sql = "call SP_MODIFICAR_ESTADO_LINK()";
      if ($consulta = $this->conexion->conexion->query($sql)) {
        return 1;
        
      }else{
        return 0;
      }
      
      
  
    }


    function Editar_Link($id_link,$linknuevo,$materia,$fecha){
      $sql = "call SP_EDITAR_LINK('$id_link','$linknuevo','$materia','$fecha')";

      if ($consulta = $this->conexion->conexion->query($sql)) {
        return 1;

      }else{
        return 0;
      }


      } 

  }