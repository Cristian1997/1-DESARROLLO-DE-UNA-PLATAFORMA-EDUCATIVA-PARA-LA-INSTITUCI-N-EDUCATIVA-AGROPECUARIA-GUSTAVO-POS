<?php
    require '../../modelo/modelo_asistencias.php';
    $MD = new Modelo_Asistencias();
    $dia = htmlspecialchars($_POST['dia'],ENT_QUOTES,'UTF-8');
    $asistencia = htmlspecialchars($_POST['asistencia'],ENT_QUOTES,'UTF-8');
 
    $consulta = $MD->Asistencias_Modificar($dia,$asistencia);  

      
    echo $consulta ;
  
   
