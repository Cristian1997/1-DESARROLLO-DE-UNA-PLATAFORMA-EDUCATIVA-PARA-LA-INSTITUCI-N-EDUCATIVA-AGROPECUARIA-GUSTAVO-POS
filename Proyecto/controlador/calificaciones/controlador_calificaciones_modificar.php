<?php
    require '../../modelo/modelo_calificaciones.php';
    $MD = new Modelo_Calificaciones();

    $id_calificaciones = htmlspecialchars($_POST['id_calificaciones'],ENT_QUOTES,'UTF-8');
    $nota_1 = htmlspecialchars($_POST['nota_1'],ENT_QUOTES,'UTF-8');
    $nota_2 = htmlspecialchars($_POST['nota_2'],ENT_QUOTES,'UTF-8');
    $nota_3 = htmlspecialchars($_POST['nota_3'],ENT_QUOTES,'UTF-8');
    $nota_4 = htmlspecialchars($_POST['nota_4'],ENT_QUOTES,'UTF-8');
   
 
    $consulta = $MD->Modificar_Calificaciones($id_calificaciones,$nota_1,$nota_2,$nota_3,$nota_4);
    echo $consulta;
?>
