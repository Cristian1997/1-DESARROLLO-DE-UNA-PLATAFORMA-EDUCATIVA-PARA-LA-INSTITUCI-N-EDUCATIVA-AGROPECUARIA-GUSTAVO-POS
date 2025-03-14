<?php
    require '../../modelo/modelo_usuario.php';

    $MU = new Modelo_Usuario();
    $idusuario = htmlspecialchars($_POST['idusuario'],ENT_QUOTES,'UTF-8');
    $contradb = htmlspecialchars($_POST['contradb'],ENT_QUOTES,'UTF-8');
    $contraescrita = htmlspecialchars($_POST['contraactual'],ENT_QUOTES,'UTF-8');
    $contranu = password_hash($_POST['contranueva'],PASSWORD_DEFAULT,['cost'=>10]);
    if(password_verify($contraescrita,$contradb)){
        $consulta = $MU->Modificar_Contra_Usuario($idusuario,$contranu);
        echo $consulta;
    }else{
        echo 2;
    }

    
?>