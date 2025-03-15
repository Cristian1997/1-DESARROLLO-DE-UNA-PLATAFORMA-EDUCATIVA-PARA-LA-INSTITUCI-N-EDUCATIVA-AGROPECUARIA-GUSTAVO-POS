  <?php  
 class Modelo_Horarios{
  private $conexion;
  function __construct(){
      require_once 'modelo_conexion.php';
      $this->conexion = new conexion();
      $this->conexion->conectar();
  }

      function listar_horarios(){
        $sql = "call SP_LISTAR_HORARIOS";
        $arreglo = array();
        if ($consulta = $this->conexion->conexion->query($sql)) {
          while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
            $arreglo["data"][] = $consulta_VU;
           }
          return $arreglo;
        $this->conexion->cerrar();
        }
        
      }

      function listar_horarios_docente(){
        $sql = "call SP_LISTAR_HORARIOS_DOCENTE";
        $arreglo = array();
        if ($consulta = $this->conexion->conexion->query($sql)) {
          while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
            $arreglo["data"][] = $consulta_VU;
           }
          return $arreglo;
        $this->conexion->cerrar();
        }
        
      }
    
      function listar_horario_estudiante($id){
        $sql = "call SP_LISTAR_HORARIO_ESTUDIANTE('$id')";
        $arreglo = array();
        if ($consulta = $this->conexion->conexion->query($sql)) {
          while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
            $arreglo["data"][] = $consulta_VU;
           }
          return $arreglo;
        $this->conexion->cerrar();
        }
      }

      function  listar_horario_docente($id){
        $sql = "call SP_LISTAR_HORARIO_DOCENTE('$id')";
        $arreglo = array();
        if ($consulta = $this->conexion->conexion->query($sql)) {
          while ($consulta_VU = mysqli_fetch_assoc($consulta)) {
            $arreglo["data"][] = $consulta_VU;
           }
          return $arreglo;
        $this->conexion->cerrar();
        }
        
      }
    
      function listar_combo_cursos(){
        $sql = "call SP_LISTAR_COMBO_CURSOS()";
        $arreglo = array();
        if ($consulta = $this->conexion->conexion->query($sql)) {
          while ($consulta_VU = mysqli_fetch_array($consulta)) {
                          $arreglo[] = $consulta_VU;
          }
          return $arreglo;
          $this->conexion->cerrar();
        }
    }

    function listar_combo_cursos_docentes(){
      $sql = "call SP_LISTAR_COMBO_CURSOS_DOCENTES";
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
      $sql = "call SP_COMBO_DOCENTES_HORARIOS()";
      $arreglo = array();
      if ($consulta = $this->conexion->conexion->query($sql)) {
        while ($consulta_VU = mysqli_fetch_array($consulta)) {
                        $arreglo[] = $consulta_VU;
        }
        return $arreglo;
        $this->conexion->cerrar();
      }
  }

    public function Registrar_Horario(
      $grado,
      $bloque_1, $bloque_2, $bloque_3, $bloque_4, $bloque_5, $bloque_6,
      $lunes_1, $lunes_2, $lunes_3, $lunes_4, $lunes_5, $lunes_6,
      $martes_1, $martes_2, $martes_3, $martes_4, $martes_5, $martes_6,
      $miercoles_1, $miercoles_2, $miercoles_3, $miercoles_4, $miercoles_5, $miercoles_6,
      $jueves_1, $jueves_2, $jueves_3, $jueves_4, $jueves_5, $jueves_6,
      $viernes_1, $viernes_2, $viernes_3, $viernes_4, $viernes_5, $viernes_6
  ) {
      $sql = "call SP_REGISTRAR_HORARIO(
          '$grado',
          '$bloque_1', '$bloque_2', '$bloque_3', '$bloque_4', '$bloque_5', '$bloque_6',
          '$lunes_1', '$lunes_2', '$lunes_3', '$lunes_4', '$lunes_5', '$lunes_6',
          '$martes_1', '$martes_2', '$martes_3', '$martes_4', '$martes_5', '$martes_6',
          '$miercoles_1', '$miercoles_2', '$miercoles_3', '$miercoles_4', '$miercoles_5', '$miercoles_6',
          '$jueves_1', '$jueves_2', '$jueves_3', '$jueves_4', '$jueves_5', '$jueves_6',
          '$viernes_1', '$viernes_2', '$viernes_3', '$viernes_4', '$viernes_5', '$viernes_6'
      )";

      if ($consulta = $this->conexion->conexion->query($sql)) {
          if ($row = mysqli_fetch_array($consulta)) {
              return $id = trim($row[0]);
          }
          $this->conexion->cerrar();
      }
  }

  public function Registrar_Horario_Docente(
    $grado,
    $bloque_1, $bloque_2, $bloque_3, $bloque_4, $bloque_5, $bloque_6,
    $lunes_1, $lunes_2, $lunes_3, $lunes_4, $lunes_5, $lunes_6,
    $martes_1, $martes_2, $martes_3, $martes_4, $martes_5, $martes_6,
    $miercoles_1, $miercoles_2, $miercoles_3, $miercoles_4, $miercoles_5, $miercoles_6,
    $jueves_1, $jueves_2, $jueves_3, $jueves_4, $jueves_5, $jueves_6,
    $viernes_1, $viernes_2, $viernes_3, $viernes_4, $viernes_5, $viernes_6,
    $grado_lunes_1, $grado_lunes_2, $grado_lunes_3, $grado_lunes_4, $grado_lunes_5, $grado_lunes_6,
    $grado_martes_1, $grado_martes_2, $grado_martes_3, $grado_martes_4, $grado_martes_5, $grado_martes_6,
    $grado_miercoles_1, $grado_miercoles_2, $grado_miercoles_3, $grado_miercoles_4, $grado_miercoles_5, $grado_miercoles_6,
    $grado_jueves_1, $grado_jueves_2, $grado_jueves_3, $grado_jueves_4, $grado_jueves_5, $grado_jueves_6,
    $grado_viernes_1, $grado_viernes_2, $grado_viernes_3, $grado_viernes_4, $grado_viernes_5, $grado_viernes_6
) {
    $sql = "call SP_REGISTRAR_HORARIO_DOCENTE(
        '$grado',
        '$bloque_1', '$bloque_2', '$bloque_3', '$bloque_4', '$bloque_5', '$bloque_6',
        '$lunes_1', '$lunes_2', '$lunes_3', '$lunes_4', '$lunes_5', '$lunes_6',
        '$martes_1', '$martes_2', '$martes_3', '$martes_4', '$martes_5', '$martes_6',
        '$miercoles_1', '$miercoles_2', '$miercoles_3', '$miercoles_4', '$miercoles_5', '$miercoles_6',
        '$jueves_1', '$jueves_2', '$jueves_3', '$jueves_4', '$jueves_5', '$jueves_6',
        '$viernes_1', '$viernes_2', '$viernes_3', '$viernes_4', '$viernes_5', '$viernes_6',
        '$grado_lunes_1', '$grado_lunes_2', '$grado_lunes_3', '$grado_lunes_4', '$grado_lunes_5', '$grado_lunes_6',
        '$grado_martes_1', '$grado_martes_2', '$grado_martes_3', '$grado_martes_4', '$grado_martes_5', '$grado_martes_6',
        '$grado_miercoles_1', '$grado_miercoles_2', '$grado_miercoles_3', '$grado_miercoles_4', '$grado_miercoles_5', '$grado_miercoles_6',
        '$grado_jueves_1', '$grado_jueves_2', '$grado_jueves_3', '$grado_jueves_4', '$grado_jueves_5', '$grado_jueves_6',
        '$grado_viernes_1', '$grado_viernes_2', '$grado_viernes_3', '$grado_viernes_4', '$grado_viernes_5', '$grado_viernes_6'
    )";

    if ($consulta = $this->conexion->conexion->query($sql)) {
        if ($row = mysqli_fetch_array($consulta)) {
            return $id = trim($row[0]);
        }
        $this->conexion->cerrar();
    }
}

  public function Editar_Horario(
    $id_horario,
    $bloque_1, $bloque_2, $bloque_3, $bloque_4, $bloque_5, $bloque_6,
    $lunes_1, $lunes_2, $lunes_3, $lunes_4, $lunes_5, $lunes_6,
    $martes_1, $martes_2, $martes_3, $martes_4, $martes_5, $martes_6,
    $miercoles_1, $miercoles_2, $miercoles_3, $miercoles_4, $miercoles_5, $miercoles_6,
    $jueves_1, $jueves_2, $jueves_3, $jueves_4, $jueves_5, $jueves_6,
    $viernes_1, $viernes_2, $viernes_3, $viernes_4, $viernes_5, $viernes_6
) {
    $sql = "call SP_EDITAR_HORARIO(
        '$id_horario',
        '$bloque_1', '$bloque_2', '$bloque_3', '$bloque_4', '$bloque_5', '$bloque_6',
        '$lunes_1', '$lunes_2', '$lunes_3', '$lunes_4', '$lunes_5', '$lunes_6',
        '$martes_1', '$martes_2', '$martes_3', '$martes_4', '$martes_5', '$martes_6',
        '$miercoles_1', '$miercoles_2', '$miercoles_3', '$miercoles_4', '$miercoles_5', '$miercoles_6',
        '$jueves_1', '$jueves_2', '$jueves_3', '$jueves_4', '$jueves_5', '$jueves_6',
        '$viernes_1', '$viernes_2', '$viernes_3', '$viernes_4', '$viernes_5', '$viernes_6'
    )";

    if ($consulta = $this->conexion->conexion->query($sql)) {
      return 1;
       
     }else{
       return 0;
     }
    
   }

   public function Editar_Horario_Docente(
    $id_horario_docente,
    $bloque_1, $bloque_2, $bloque_3, $bloque_4, $bloque_5, $bloque_6,
    $lunes_1, $lunes_2, $lunes_3, $lunes_4, $lunes_5, $lunes_6,
    $martes_1, $martes_2, $martes_3, $martes_4, $martes_5, $martes_6,
    $miercoles_1, $miercoles_2, $miercoles_3, $miercoles_4, $miercoles_5, $miercoles_6,
    $jueves_1, $jueves_2, $jueves_3, $jueves_4, $jueves_5, $jueves_6,
    $viernes_1, $viernes_2, $viernes_3, $viernes_4, $viernes_5, $viernes_6,
    $grado_lunes_1, $grado_lunes_2, $grado_lunes_3, $grado_lunes_4, $grado_lunes_5, $grado_lunes_6,
    $grado_martes_1, $grado_martes_2, $grado_martes_3, $grado_martes_4, $grado_martes_5, $grado_martes_6,
    $grado_miercoles_1, $grado_miercoles_2, $grado_miercoles_3, $grado_miercoles_4, $grado_miercoles_5, $grado_miercoles_6,
    $grado_jueves_1, $grado_jueves_2, $grado_jueves_3, $grado_jueves_4, $grado_jueves_5, $grado_jueves_6,
    $grado_viernes_1, $grado_viernes_2, $grado_viernes_3, $grado_viernes_4, $grado_viernes_5, $grado_viernes_6
) {
    $sql = "call SP_EDITAR_HORARIO_DOCENTE(
        '$id_horario_docente',
        '$bloque_1', '$bloque_2', '$bloque_3', '$bloque_4', '$bloque_5', '$bloque_6',
        '$lunes_1', '$lunes_2', '$lunes_3', '$lunes_4', '$lunes_5', '$lunes_6',
        '$martes_1', '$martes_2', '$martes_3', '$martes_4', '$martes_5', '$martes_6',
        '$miercoles_1', '$miercoles_2', '$miercoles_3', '$miercoles_4', '$miercoles_5', '$miercoles_6',
        '$jueves_1', '$jueves_2', '$jueves_3', '$jueves_4', '$jueves_5', '$jueves_6',
        '$viernes_1', '$viernes_2', '$viernes_3', '$viernes_4', '$viernes_5', '$viernes_6',
        '$grado_lunes_1', '$grado_lunes_2', '$grado_lunes_3', '$grado_lunes_4', '$grado_lunes_5', '$grado_lunes_6',
        '$grado_martes_1', '$grado_martes_2', '$grado_martes_3', '$grado_martes_4', '$grado_martes_5', '$grado_martes_6',
        '$grado_miercoles_1', '$grado_miercoles_2', '$grado_miercoles_3', '$grado_miercoles_4', '$grado_miercoles_5', '$grado_miercoles_6',
        '$grado_jueves_1', '$grado_jueves_2', '$grado_jueves_3', '$grado_jueves_4', '$grado_jueves_5', '$grado_jueves_6',
        '$grado_viernes_1', '$grado_viernes_2', '$grado_viernes_3', '$grado_viernes_4', '$grado_viernes_5', '$grado_viernes_6'
    )";

    if ($consulta = $this->conexion->conexion->query($sql)) {
        return 1;
    } else {
        return 0;
    }
}

}

?>