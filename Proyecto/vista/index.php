<?php
session_start();
if(!isset($_SESSION['S_IDUSUARIO'])){
	header('Location: ../Login/index.php');
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>EducaNet | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../Plantilla/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../Plantilla/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../Plantilla/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../Plantilla/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
   folder instead of downloading all of them to reduce the load. -->
   <link rel="stylesheet" href="../Plantilla/dist/css/skins/_all-skins.min.css">
   <!-- Morris chart -->
   <link rel="stylesheet" href="../Plantilla/bower_components/morris.js/morris.css">
   <!-- jvectormap -->
   <link rel="stylesheet" href="../Plantilla/bower_components/jvectormap/jquery-jvectormap.css">
   <!-- Date Picker -->
   <link rel="stylesheet" href="../Plantilla/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
   <!-- Daterange picker -->
   <link rel="stylesheet" href="../Plantilla/bower_components/bootstrap-daterangepicker/daterangepicker.css">
   <!-- bootstrap wysihtml5 - text editor -->
   <link rel="stylesheet" href="../Plantilla/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

   <link rel="stylesheet" href="../Plantilla/plugins/DataTables/datatables.min.css">
   <link rel="stylesheet" href="../Plantilla/plugins/select2/select2.min.css">
   
   <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
   <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
        @media (max-width: 767px) {
            .dropdown-menu {
                width: 400px !important;
            }
               .menu {
                width: 100% !important;
                margin: auto;
            }
        }
    </style>
</head>
<style>
  .swal2-popup{
    font-size:1.6rem !important;

  }
</style>
<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="index.php" class="logo">
      <span class="logo-mini"><b>E</b>NET</span>
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-lg">
            <img src="escudo.png" alt="EducaNET Logo" class="logo-img">
            <b>Educa</b>NET
        </span>
      </a>
      
      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button--> <input type="hidden" value="<?php echo $_SESSION['S_IDUSUARIO']; ?>" id="txtidusuario">

        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>

        <div class="navbar-custom-menu">

          <ul class="nav navbar-nav">






          
           <?php
           if ($_SESSION['S_ROL'] == '3') {
    // code...
            ?>
            
            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-danger" id="lbl_contador2"></span>
              </a>
              <ul class="dropdown-menu" style="width: 560px;">
                <li class="header" id="lbl_contador3"></li>
                <li>

                  <ul class="menu" id="div_cuerpo1" style="width: 95%; margin: auto;">



                  </ul>
                </li>



                <li class="footer"><a onclick="cargar_contenido('contenido_principal','talleres/vista_talleres_estudiantes_listar.php')" style="cursor: pointer;">Ver Talleres</a></li> 
              </ul>
            </li>
          <?php }  ?>


          <?php
          if ($_SESSION['S_ROL'] == '2') {
    // code...
            ?>
            
            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-danger" id="lbl_contador"></span>
              </a>
              <ul class="dropdown-menu" style="width: 560px;">
                <li class="header" id="lbl_contador1"></li>
                <li>

                  <ul class="menu" id="div_cuerpo" style="width: 95%; margin: auto;">



                  </ul>
                </li>



                <li class="footer"><a onclick="cargar_contenido('contenido_principal','talleres/vista_talleres_docentes_listar.php')" style="cursor: pointer;">Ver Talleres</a></li> 
              </ul>
            </li>
          <?php }  ?>

          <?php
          if ($_SESSION['S_ROL'] == '5') {
    // code...
            ?>
            <li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-warning" id="lbl_contador4"></span>
              </a>
              <ul class="dropdown-menu" style="width: 540px;">
                <li class="header" id="lbl_contador5"></li>
                <li>

                  <ul class="menu" id="div_cuerpo2" style="width: 95%; margin: auto;">



                  </ul>
                </li>


                <li class="footer"><a onclick="cargar_contenido('contenido_principal','talleres/vista_talleres_docentes_comentarios_listar.php')" style="cursor: pointer;">Ver Comentarios</a></li>






              </ul>
            </li>
          <?php }  ?>



          <?php
          if ($_SESSION['S_ROL'] == '5') {
    // code...
            ?>
            <li class="dropdown messages-menu" hidden >
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-warning" id="lbl_contador6"></span>
              </a>
              <ul class="dropdown-menu" style="width: 540px;">
                <li class="header" id="lbl_contador7"></li>
                <li>

                  <ul class="menu" id="div_cuerpo3" style="width: 95%; margin: auto;">



                  </ul>
                </li>


                <li class="footer"><a onclick="cargar_contenido('contenido_principal','talleres/vista_talleres_estudiantes_comentarios_listar.php')" style="cursor: pointer;">Ver Comentarios</a></li>

              </ul>
            </li>
          <?php }  ?>

          <?php
          if ($_SESSION['S_ROL'] == '3') {
    // code...
            ?>
          <li class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-envelope-o"></i>
        <span class="label label-success" id="lbl_contador_mensajes">0</span> 
    </a>
    <ul class="dropdown-menu" style="width: 540px;">
        <li class="header" id="lbl_contador_total_mensajes"></li>
        <li>
            <ul class="menu" id="div_cuerpo_mensajes">
                <!-- Aquí se mostrarán los mensajes -->
            </ul>
        </li>
        <li class="footer">
            <a onclick="cargar_contenido('contenido_principal','chat/vista_chat_estudiantes_listar.php')" style="cursor: pointer;">Ver Chats</a>
        </li>
    </ul>
</li>
<?php }  ?>
          

<?php
          if ($_SESSION['S_ROL'] == '2') {
    // code...
            ?>
          <li class="dropdown messages-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-envelope-o"></i>
        <span class="label label-success" id="lbl_contador_mensajes">0</span> 
    </a>
    <ul class="dropdown-menu" style="width: 540px;">
        <li class="header" id="lbl_contador_total_mensajes"></li>
        <li>
            <ul class="menu" id="div_cuerpo_mensajes">
                <!-- Aquí se mostrarán los mensajes -->
            </ul>
        </li>
        <li class="footer">
            <a onclick="cargar_contenido('contenido_principal','chat/vista_chat_estudiantes_listar.php')" style="cursor: pointer;">Ver Chats</a>
        </li>
    </ul>
</li>
<?php }  ?>
          

<?php
          if ($_SESSION['S_ROL'] == '3') {
    // code...
            ?>
<li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class=" fa fa-bullhorn"></i>
                <span class="label label-warning" id="lbl_contador_foro_n"></span>
              </a>
              <ul class="dropdown-menu" style="width: 560px;">
                <li class="header" id="lbl_contador_foro"></li>
                <li>
                  <ul class="menu" id="div_cuerpo_foro" style="width: 95%; margin: auto;">
                  </ul>
                </li>
                <li class="footer"><a onclick="cargar_contenido('contenido_principal','foro/vista_foro_estudiante.php')" style="cursor: pointer;">Ver Foros</a></li> 
              </ul>
            </li>

            <?php }  ?>


            <?php
          if ($_SESSION['S_ROL'] == '2') {
    // code...
            ?>
<li class="dropdown messages-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class=" fa fa-bullhorn"></i>
                <span class="label label-warning" id="lbl_contador_foro_n_doc"></span>
              </a>
              <ul class="dropdown-menu" style="width: 560px;">
                <li class="header" id="lbl_contador_foro_doc"></li>
                <li>
                  <ul class="menu" id="div_cuerpo_foro_doc" style="width: 95%; margin: auto;">
                  </ul>
                </li>
                <li class="footer"><a onclick="cargar_contenido('contenido_principal','foro/vista_foro_docente.php')" style="cursor: pointer;">Ver Foros</a></li> 
              </ul>
            </li>

            <?php }  ?>


          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img id="img_nav" class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo $_SESSION['S_USER']; ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img id="img_subnav" class="img-circle" alt="User Image">

                <p>
                  <?php echo $_SESSION['S_USER']; ?> 
                </p>
                <p id="nombre_p">
                  
                </p>
              </li>
              <!-- Menu Body -->

              <!-- Menu Footer-->
              <li class="user-footer" style="background-color: #93908F; padding: 10px;">
  <div class="pull-left">
                  <a href="#" onclick="cargar_contenido('contenido_principal','usuario/perfil_usuario.php')" class="btn btn-default btn-flat"><i class="fa fa-user"></i>&nbsp; Mi Perfil</a>
                </div>
                <div class="pull-right">
                  <a href="../controlador/usuario/controlador_cerrar_session.php" class="btn btn-default btn-flat"><i class="fa fa-close"></i>&nbsp;Salir</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>


      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img id="img_lateral" class="img-circle" alt="User Image" >
        </div>
        <div class="pull-left info">
          <p><?php echo $_SESSION['S_USER']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> <?php if ($_SESSION['S_ROL']=="1") {
            echo "ADMINISTRADOR";
          } elseif ($_SESSION['S_ROL']=="2") {
            echo "DOCENTE";
          }elseif ($_SESSION['S_ROL']=="3") {
            echo "ESTUDIANTE";
          }elseif ($_SESSION['S_ROL']=="4") {
            echo "SECRETARIA";
          }?></a>
        </div>

      </div>
   

      <?php
      if ($_SESSION['S_ROL'] == '1') {
    // code...
        ?>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree" >
          <li class="header">MENU DE NAVEGACION</li>
          <li class="active treeview" >

            <li class="treeview" style="cursor: pointer;">
              <a onclick="cargar_contenido('contenido_principal','admin/vista_inicio_admin.php')">
                <i class="fa fa-home" ></i> <span >Inicio</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
            </li>

            <li class="treeview" style="cursor: pointer;">
              <a onclick="cargar_contenido('contenido_principal','usuario/vista_usuario_listar.php')">
                <i class="fa fa-users"></i> <span>Usuarios</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
            </li>

            <li class="treeview" style="cursor: pointer;">
             <a onclick="cargar_contenido('contenido_principal','docente/vista_docente_listar.php')">
              <i class="fa fa-user"></i> <span>Docentes</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
          </li>


          <li class="treeview" style="cursor: pointer;">
           <a onclick="cargar_contenido('contenido_principal','estudiante/vista_estudiante_listar.php')">
            <i class="fa fa-user"></i> <span>Estudiantes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        </li>

        <li class="treeview" style="cursor: pointer;">

          <a onclick="cargar_contenido('contenido_principal','cursos/vista_curso_listar.php')">
            <i class="fa fa-book"></i> <span>Cursos</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
 
          <li class="treeview" style="cursor: pointer;">

          <a onclick="cargar_contenido('contenido_principal','notas/vista_notas_admin_listar.php')">
            <i class="fa fa-pencil-square-o"></i> <span>Calificaciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
            </span>
          </a>
      
          <li class="treeview" style="cursor: pointer;">
            <a onclick="cargar_contenido('contenido_principal','horarios/remplazar/horarios_admin.php')">
              <i class="fa fa-table"></i> <span>Tablero de horarios</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <li class="treeview" style="cursor: pointer;">
            <a onclick="cargar_contenido('contenido_principal','horarios/vista_horarios.php')">
              <i class="fa fa-table"></i> <span>Horarios específicos</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            </li>
          
          </li>
        </li>
      </ul>
      <?php
    }
    ?>

    <?php
    if ($_SESSION['S_ROL'] == '2') {
    // code...
      ?>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU DE NAVEGACION</li>
        <li class="active treeview">  

        
        <li class="treeview" style="cursor: pointer;">
            <a onclick="cargar_contenido('contenido_principal','grupos/vista_grupo_listar.php')">
              <i class="fa fa-users"></i> 
              <span>Mis grupos</span>
              <span class="pull-right-container">

                <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
              </a>
            </span>
          </a>

        </li>
        <li class="treeview" style="cursor: pointer;">


          <a onclick="cargar_contenido('contenido_principal','notas/vista_notas_docente_listar.php')">
            <i class="fa fa-pencil-square-o"></i> <span>Calificaciones</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
            </span>
          </a>




               <!--
            <ul class="treeview-menu" style="display: block; cursor: pointer;">
              <li  id="mate"><a onclick="cargar_contenido('contenido_principal','talleres/vista_portafolios_listar.php')"><i class="fa fa-calculator"></i> Matematica</a></li>
              <li  id="español"><a href="pages/UI/icons.html" id="li" HI><i class="fa fa-circle-o"></i> Español</a></li>
              <li id="Sociales"><a href="pages/UI/buttons.html"><i class="fa fa-globe"></i> Sociales</a></li>
              <li id="Ingles"><a href="pages/UI/sliders.html"><i class="fa fa-language"></i> Ingles</a></li>
              <li id="Informatica"><a href="pages/UI/timeline.html"><i class="fa fa-desktop"></i> Informatica</a></li>
              <li id="artistica"><a href="pages/UI/modals.html"><i class="fa fa-paint-brush"></i> Artistica</a></li>
              <li id="religion"><a href="pages/UI/modals.html"><i class="fa fa-flask"></i> Religion</a></li>
              <li id="natu"><a href="pages/UI/modals.html"><i class="fa fa-flask"></i> Naturales</a></li>
              <li id="edu_fisica"><a href="pages/UI/modals.html"><i class="fa fa-soccer-ball-o"></i> Educacion Fisica</a></li> 
              <li id="filosofia"><a href="pages/UI/modals.html"><i class="fa fa-soccer-ball-o"></i> Filosofia</a></li>
              <li id="quimica"><a href="pages/UI/modals.html"><i class="fa fa-soccer-ball-o"></i> Quimica</a></li>
              <li id="algebra"><a href="pages/UI/modals.html"><i class="fa fa-soccer-ball-o"></i> Algebra</a></li>
              <li id="trigo"><a href="pages/UI/modals.html"><i class="fa fa-soccer-ball-o"></i> Trigonometría</a></li>

            </ul>

          -->

        </li>

        <li class="treeview" style="cursor: pointer;">
          <a onclick="cargar_contenido('contenido_principal','asistencias/vista_asistencias_listar.php')">
            <i class="fa fa-check-square-o"></i> <span>Asistencia</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
            </span>
          </a>
        </li>

        <li class="treeview"style="cursor: pointer;">
          <a onclick="cargar_contenido('contenido_principal','talleres/vista_talleres_docentes_listar.php')">
            <i class="fa fa-book"></i> <span>Talleres</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
            </span>
          </a>
        </li>  
        <li class="treeview" style="cursor: pointer;">
          <a onclick="cargar_contenido('contenido_principal','trabajos/vista_talleres_docentes_trabajos_listar.php')">
            <i class="fa  fa-folder-o"></i> <span>Trabajos entregados</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
            </span>
          </a>
        </li>
        <li class="treeview" style="cursor: pointer;">
          <a onclick="cargar_contenido('contenido_principal','material/vista_material_docente_listar.php')">
            <i class="fa fa-folder-open-o"></i> <span>Material de apoyo</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
            </span>
          </a>
        </li>
        <li class="treeview" style="cursor: pointer;">
          <a onclick="cargar_contenido('contenido_principal','foro/vista_foro_docente.php')">
            <i class="fa  fa-comments"></i> <span>Foros de participación</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
            </span>
          </a>
        </li>
        <li class="treeview" style="cursor: pointer;">

     

        <li class="treeview" style="cursor: pointer;">

<a onclick="cargar_contenido('contenido_principal','chat/vista_chat_docentes_listar.php')">
 <i class="fa fa-commenting-o"></i>
 <span>Chat</span>
 <span class="pull-right-container">
   <i class="fa fa-angle-left pull-right"></i>
 </span>
</a>

</li>

        <li class="treeview" style="cursor: pointer;">
          <a onclick="cargar_contenido('contenido_principal','registro_clases/vista_registro_clases_docentes_listar.php')">
            <i class="fa fa-film"></i> <span>Registro de clases</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
            </span>
          </a>
        </li>
        <li class="treeview" style="cursor: pointer;">
          <a onclick="cargar_contenido('contenido_principal','registro_clases/vista_registro_clases_virtuales_docentes_listar.php')">
          <i class="fa fa-desktop"></i> <span>Videoconferencias</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>

        <li class="treeview" style="cursor: pointer;">
        <a onclick="cargar_contenido('contenido_principal','horarios/horarios_docente.php')">
              <i class="fa fa-table"></i> <span>Horarios</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
              </span>
            </a>
      </li>
    </li>

  </ul>
  <?php
}
?>



<?php
if ($_SESSION['S_ROL'] == '3') {
    // code...
  ?>
  <!-- /.search form -->
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu" data-widget="tree">
    <li class="header">MENU DE NAVEGACION</li>
    <li class="active treeview">

      
        <li class="treeview" style="cursor: pointer;">
            <a onclick="cargar_contenido('contenido_principal','grupos/vista_grupo_listar_estudiante.php')">
              <i class="fa fa-users"></i> 
              <span>Mis grupos</span>
              <span class="pull-right-container">

                <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
              </a>
            </span>
          </a>

        </li>

    <li class="treeview" style="cursor: pointer;">

       <a onclick="cargar_contenido('contenido_principal','talleres/vista_talleres_estudiantes_listar.php')">
        <i class="fa fa-book"></i>
        <span>Talleres</span>
        <span class="pull-right-container">
          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>

    </li> 
    <li class="treeview" style="cursor: pointer;">
          <a onclick="cargar_contenido('contenido_principal','trabajos/vista_talleres_estudiantes_trabajos_listar.php')">
            <i class="fa  fa-folder-o"></i> <span>Mis trabajos entregados</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
            </span>
          </a>
        </li>

    <li class="treeview" style="cursor: pointer;">
    <a onclick="cargar_contenido('contenido_principal','material/vista_material_estudiantes_listar.php')">
 <i class="fa fa-folder-open-o"></i>
 <span>Material de apoyo</span>
 <span class="pull-right-container">
   <i class="fa fa-angle-left pull-right"></i>
 </span>
</a>
</li>

<li class="treeview" style="cursor: pointer;">

<a onclick="cargar_contenido('contenido_principal','chat/vista_chat_estudiantes_listar.php')">
 <i class="fa fa-commenting-o"></i>
 <span>Chat</span>
 <span class="pull-right-container">
   <i class="fa fa-angle-left pull-right"></i>
 </span>
</a>

</li>

    <li class="treeview" style="cursor: pointer;">
          <a onclick="cargar_contenido('contenido_principal','foro/vista_foro_estudiante.php')">
            <i class="fa  fa-comments"></i> <span>Foros de participación</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
            </span>
          </a>
        </li>
 

  <li class="treeview" style="cursor: pointer;">
    <a onclick="cargar_contenido('contenido_principal','notas/vista_notas_estudiantes_listar.php')">
      <i class="fa fa-pencil-square-o"></i> <span>Calificaciones</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
  </li>

  <li class="treeview" style="cursor: pointer;">
   <a onclick="cargar_contenido('contenido_principal','registro_clases/vista_registro_clases_estudiantes_listar.php')">
    <i class="fa fa-film"></i> <span>Grabaciones de clases</span>
    <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right"></i>
    </span>
  </a>
</li>
<li class="treeview" style="cursor: pointer;">
 <a onclick="cargar_contenido('contenido_principal','videoconferencias/vista_videoconferencia_clases_estudiantes_listar.php')">
  <i class="fa fa-desktop"></i> <span>Videoconferencias</span>
  <span class="pull-right-container">
    <i class="fa fa-angle-left pull-right"></i>
  </span>
</a>

<li class="treeview" style="cursor: pointer;">
        <a onclick="cargar_contenido('contenido_principal','horarios/horarios_estudiante.php')">
              <i class="fa fa-table"></i> <span>Horarios</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
              </span>
            </a>
</li>
</ul>
<?php
}
?>

<?php
if ($_SESSION['S_ROL'] == '4') {
    // code...
  ?>
  <!-- /.search form -->
  <!-- sidebar menu: : style can be found in sidebar.less -->
  <ul class="sidebar-menu" data-widget="tree">
    <li class="header">MENU DE NAVEGACION</li>
  
    <li class="treeview" style="cursor: pointer;">
      <a onclick="cargar_contenido('contenido_principal','secretaria/vista_secretaria_listar.php')">
        <i class="fa fa-book"></i> <span>Grupos</span>
        <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
        </span>
      </a>

      <li class="treeview" style="cursor: pointer;">

 
    <a onclick="cargar_contenido('contenido_principal','secretaria/vista_asignar_estudiantes.php')">
      <i class="fa fa-book"></i> <span>Asignar Estudiantes</span>
      <span class="pull-right-container">
      <i class="fa fa-angle-left pull-right" style="cursor: pointer;"></i>
      </span>
    </a>

  </li>

</ul>
<?php
}
?>


</section>
<!-- /.sidebar -->
</aside>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->

  <!-- Main content -->
  <section class="content">
    <input type="tetx" id="txtidprincipal" value="<?php echo $_SESSION['S_IDUSUARIO'] ?>"hidden>
    <input type="tetx" id="usuarioprincipal" value="<?php echo $_SESSION['S_USER'] ?>"hidden>
    <div class="row" id="contenido_principal">
      <div class="col-md-12">
        <div class="box box-warning box-solid">

          <div class="box-header with-border">
            <h3 class="box-title">Bienvenid@ a EucaNet</h3>

            <div class="box-tools pull-right">
              <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
              </button>
            </div>
            <!-- /.box-tools -->
          </div>
          <!-- /.box-header -->
          <div class="box-body">
          <?php
           if ($_SESSION['S_ROL'] == '2') {
    // code...
            ?>


    <div style="float: left; width: 48%; text-align: center;">
        <img src="msg.png" alt="Imagen de recordatorio 1" style="width: 60px; height: 60px; margin-right: 20px;">
        <p>
            Recuerda mantenerte al día con tus estudiantes. Revisa tus notificaciones para saber si un estudiante te envió un mensaje y responde a sus inquietudes.
        </p>
    </div>

    <div style="float: right; width: 48%; text-align: center;">
        <img src="taller.png" alt="Imagen de recordatorio 2" style="width: 60px; height: 60px; margin-left: 20px;">
      
        <p>
            Recuerda revisar tus talleres publicados. Verifica si hay preguntas o comentarios de los estudiantes y proporciona la asistencia necesaria.
        </p>
    </div>
<br><br><br><br><br><br>
<style>
    /* Estilos del calendario y los porcentajes */
    .current-day {
      background-color: #4dd194;
      font-weight: bold;
    }

    .progress {
      margin-bottom: 10px;
    }
  </style>

  <!-- Contenido de la página -->

  <!-- Contenedor del calendario -->
  
<div class="box box-solid bg-green-gradient">
  <div class="box-header ui-sortable-handle" style="cursor: move;">
    <i class="fa fa-calendar"></i>
    <h3 class="box-title">Calendario</h3>
    <div class="pull-right box-tools">
      <div class="btn-group"></div>
      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body no-padding">
    <div id="calendar" style="width: 100%">
      <div class="datepicker datepicker-inline">
        <div class="datepicker-days" style="">
          <table class="table-condensed">
            <thead>
              <tr>
                <th colspan="7" class="datepicker-title" style="display: none;"></th>
              </tr>
              <tr>
                <th class="prev"></th>
                <th colspan="5" class="datepicker-switch">Marzo 2024</th>
                <th class="next"></th>
              </tr>
              <tr>
                <th class="dow">Domingo</th>
                <th class="dow">Lunes</th>
                <th class="dow">Martes</th>
                <th class="dow">Miércoles</th>
                <th class="dow">Jueves</th>
                <th class="dow">Viernes</th>
                <th class="dow">Sábado</th>
              </tr>
            </thead>
            <tbody id="calendar-body">
              <!-- Contenido del calendario se generará aquí -->
            </tbody>
            <tfoot>
              <tr>
                <th colspan="7" class="today" style="display: none;">Hoy</th>
              </tr>
              <tr>
                <th colspan="7" class="clear" style="display: none;">Limpiar</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- Otras partes del calendario (meses, años, décadas, siglos) -->
      </div>
    </div>
  </div>


<div class="box-footer text-black">
  <div class="row">
    <div class="col-sm-6">
      <div class="clearfix">
        <span class="pull-left">Periodo 1</span>
        <small id="periodo1" class="pull-right"></small>
      </div>
      <div class="progress xs">
        <div id="barra1" class="progress-bar progress-bar-green" style="width: 0%;"></div>
      </div>
      <div class="clearfix">
        <span class="pull-left">Periodo 2</span>
        <small id="periodo2" class="pull-right"></small>
      </div>
      <div class="progress xs">
        <div id="barra2" class="progress-bar progress-bar-green" style="width: 0%;"></div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="clearfix">
        <span class="pull-left">Periodo 3</span>
        <small id="periodo3" class="pull-right"></small>
      </div>
      <div class="progress xs">
        <div id="barra3" class="progress-bar progress-bar-green" style="width: 0%;"></div>
      </div>
      <div class="clearfix">
        <span class="pull-left">Periodo 4</span>
        <small id="periodo4" class="pull-right"></small>
      </div>
      <div class="progress xs">
        <div id="barra4" class="progress-bar progress-bar-green" style="width: 0%;"></div>
      </div>
    </div>
  </div>
</div>
</div>
        
          <?php }  ?>



          <?php
           if ($_SESSION['S_ROL'] == '3') {
    // code...
            ?>


    <div style="float: left; width: 48%; text-align: center;">
        <img src="msg.png" alt="Imagen de recordatorio 1" style="width: 60px; height: 60px; margin-right: 20px;">
        <p>
        Recuerda mantenerse al día. Revisen sus notificaciones para saber si su maestro les envió un mensaje y respondan a sus inquietudes.
        </p>
    </div>

    <div style="float: right; width: 48%; text-align: center;">
        <img src="taller.png" alt="Imagen de recordatorio 2" style="width: 60px; height: 60px; margin-left: 20px;">
      
        <p>
        Recuerda revisar los talleres publicados. Verifiquen si tienen preguntas o comentarios y soliciten la asistencia necesaria.
        </p>
    </div>
    <br><br><br><br><br><br>
    <style>
    /* Estilos del calendario y los porcentajes */
    .current-day {
      background-color: #4dd194;
      font-weight: bold;
    }

    .progress {
      margin-bottom: 10px;
    }
  </style>

  <!-- Contenido de la página -->

  <!-- Contenedor del calendario -->
  
<div class="box box-solid bg-green-gradient">
  <div class="box-header ui-sortable-handle" style="cursor: move;">
    <i class="fa fa-calendar"></i>
    <h3 class="box-title">Calendario</h3>
    <div class="pull-right box-tools">
      <div class="btn-group"></div>
      <button type="button" class="btn btn-success btn-sm" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
    </div>
  </div>
  <div class="box-body no-padding">
    <div id="calendar" style="width: 100%">
      <div class="datepicker datepicker-inline">
        <div class="datepicker-days" style="">
          <table class="table-condensed">
            <thead>
              <tr>
                <th colspan="7" class="datepicker-title" style="display: none;"></th>
              </tr>
              <tr>
                <th class="prev"></th>
                <th colspan="5" class="datepicker-switch">Marzo 2024</th>
                <th class="next"></th>
              </tr>
              <tr>
                <th class="dow">Domingo</th>
                <th class="dow">Lunes</th>
                <th class="dow">Martes</th>
                <th class="dow">Miércoles</th>
                <th class="dow">Jueves</th>
                <th class="dow">Viernes</th>
                <th class="dow">Sábado</th>
              </tr>
            </thead>
            <tbody id="calendar-body">
              <!-- Contenido del calendario se generará aquí -->
            </tbody>
            <tfoot>
              <tr>
                <th colspan="7" class="today" style="display: none;">Hoy</th>
              </tr>
              <tr>
                <th colspan="7" class="clear" style="display: none;">Limpiar</th>
              </tr>
            </tfoot>
          </table>
        </div>
        <!-- Otras partes del calendario (meses, años, décadas, siglos) -->
      </div>
    </div>
  </div>


<div class="box-footer text-black">
  <div class="row">
    <div class="col-sm-6">
      <div class="clearfix">
        <span class="pull-left">Periodo 1</span>
        <small id="periodo1" class="pull-right"></small>
      </div>
      <div class="progress xs">
        <div id="barra1" class="progress-bar progress-bar-green" style="width: 0%;"></div>
      </div>
      <div class="clearfix">
        <span class="pull-left">Periodo 2</span>
        <small id="periodo2" class="pull-right"></small>
      </div>
      <div class="progress xs">
        <div id="barra2" class="progress-bar progress-bar-green" style="width: 0%;"></div>
      </div>
    </div>
    <div class="col-sm-6">
      <div class="clearfix">
        <span class="pull-left">Periodo 3</span>
        <small id="periodo3" class="pull-right"></small>
      </div>
      <div class="progress xs">
        <div id="barra3" class="progress-bar progress-bar-green" style="width: 0%;"></div>
      </div>
      <div class="clearfix">
        <span class="pull-left">Periodo 4</span>
        <small id="periodo4" class="pull-right"></small>
      </div>
      <div class="progress xs">
        <div id="barra4" class="progress-bar progress-bar-green" style="width: 0%;"></div>
      </div>
    </div>
  </div>
</div>
</div>
        
          <?php }  ?>

          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Versión</b> 1.0.0
    </div>
    <strong>Copyright &copy; Cristian E <a href="">EducaNet</a>.</strong> Todos Los Derechos Reservados.
  </footer>

  <!-- Control Sidebar - Opciones de diseño-->
  <aside class="control-sidebar control-sidebar-dark" style="display: none;">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li>
      </i>
    </a>
  </li>
</ul>
<!-- Tab panes -->
<div class="tab-content">

  <h4 class="control-sidebar-heading">Opciones de diseño</h4>
  <div class="form-group">
  </div>
  <ul class="list-unstyled clearfix">
    <li style="float:left; width: 33.33333%; padding: 5px;">
      <a href="javascript:void(0)" data-skin="skin-blue" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
        <div>
          <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span>
          <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
        </div>
        <div>
          <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
          <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
        </div>
      </a>
      <p class="text-center no-margin">Azul-Negro</p>
    </li>
    <li style="float:left; width: 33.33333%; padding: 5px;">
      <a href="javascript:void(0)" data-skin="skin-black" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
        <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
          <span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span>
          <span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span>
        </div>
        <div>
          <span style="display:block; width: 20%; float: left; height: 20px; background: #222"></span>
          <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
        </div>
      </a>
      <p class="text-center no-margin">Blanco-Negro</p>
    </li>
    <li style="float:left; width: 33.33333%; padding: 5px;">
      <a href="javascript:void(0)" data-skin="skin-purple" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
        <div>
          <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
          <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
        </div>
        <div>
          <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
          <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
        </div>
      </a>
      <p class="text-center no-margin">Morado-Negro</p>
    </li>
    <li style="float:left; width: 33.33333%; padding: 5px;">
      <a href="javascript:void(0)" data-skin="skin-green" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
        <div>
          <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
          <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
        </div>
        <div>
          <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
          <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
        </div>
      </a>
      <p class="text-center no-margin">Verde-Negro</p>
    </li>
    <li style="float:left; width: 33.33333%; padding: 5px;">
      <a href="javascript:void(0)" data-skin="skin-red" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
        <div>
          <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
          <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
        </div>
        <div>
          <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
          <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
        </div>
      </a>
      <p class="text-center no-margin">Rojo-Negro</p>
    </li><li style="float:left; width: 33.33333%; padding: 5px;">
      <a href="javascript:void(0)" data-skin="skin-yellow" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
        <div>
          <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
          <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
        </div>
        <div>
          <span style="display:block; width: 20%; float: left; height: 20px; background: #222d32"></span>
          <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
        </div></a><p class="text-center no-margin">Amarillo-Negro</p>
      </li>
      <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:void(0)" data-skin="skin-blue-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
          <div>
            <span style="display:block; width: 20%; float: left; height: 7px; background: #367fa9"></span>
            <span class="bg-light-blue" style="display:block; width: 80%; float: left; height: 7px;"></span>
          </div>
          <div>
            <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
            <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
          </div>
        </a>
        <p class="text-center no-margin" style="font-size: 12px">Azul-Blanco</p>
      </li>
      <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:void(0)" data-skin="skin-black-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
          <div style="box-shadow: 0 0 2px rgba(0,0,0,0.1)" class="clearfix">
            <span style="display:block; width: 20%; float: left; height: 7px; background: #fefefe"></span>
            <span style="display:block; width: 80%; float: left; height: 7px; background: #fefefe"></span>
          </div>
          <div>
            <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
            <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
          </div>
        </a>
        <p class="text-center no-margin" style="font-size: 12px">Blanco-Blanco</p>
      </li>
      <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:void(0)" data-skin="skin-purple-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
          <div>
            <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-purple-active"></span>
            <span class="bg-purple" style="display:block; width: 80%; float: left; height: 7px;"></span>
          </div>
          <div>
            <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
            <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
          </div>
        </a>
        <p class="text-center no-margin" style="font-size: 12px">Morado-Blanco</p>
      </li>
      <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:void(0)" data-skin="skin-green-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
          <div>
            <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-green-active"></span>
            <span class="bg-green" style="display:block; width: 80%; float: left; height: 7px;"></span>
          </div>
          <div>
            <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
            <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
          </div>
        </a>
        <p class="text-center no-margin" style="font-size: 12px">Verde Blanco</p>
      </li>
      <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:void(0)" data-skin="skin-red-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
          <div>
            <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-red-active"></span>
            <span class="bg-red" style="display:block; width: 80%; float: left; height: 7px;"></span>
          </div>
          <div>
            <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
            <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
          </div>
        </a>
        <p class="text-center no-margin" style="font-size: 12px">Rojo-Blanco</p>
      </li>
      <li style="float:left; width: 33.33333%; padding: 5px;">
        <a href="javascript:void(0)" data-skin="skin-yellow-light" style="display: block; box-shadow: 0 0 3px rgba(0,0,0,0.4)" class="clearfix full-opacity-hover">
          <div>
            <span style="display:block; width: 20%; float: left; height: 7px;" class="bg-yellow-active"></span>
            <span class="bg-yellow" style="display:block; width: 80%; float: left; height: 7px;"></span>
          </div>
          <div>
            <span style="display:block; width: 20%; float: left; height: 20px; background: #f9fafc"></span>
            <span style="display:block; width: 80%; float: left; height: 20px; background: #f4f5f7"></span>
          </div>
        </a>
        <p class="text-center no-margin" style="font-size: 12px">Amarillo-Blanco</p>
      </li>
    </ul>
  </div>
</div>
<!-- /.tab-pane -->

</div>
</aside>
<!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
   immediately after the control sidebar -->
   <div class="control-sidebar-bg"></div>
 </div>
 <!-- ./wrapper -->
 <div class="modal fade" id="modal_editar_contra" role="dialog">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><b>Modificar Contraseña</b></h4>
      </div>
      <div class="modal-body">
        <div class="col-lg-12">
          <input type="text" id="txtcontra_bd" hidden>
          <label for="txtcontraactual_editar">Contraseña Actual</label>
          <input type="password" class="form-control" id="txtcontraactual_editar" placeholder="Contraseña Actual"><br>
        </div>
        <div class="col-lg-12">
          <label for="txtcontranu_editar">Nueva Contraseña</label>
          <input type="password" class="form-control" id="txtcontranu_editar" placeholder="Nueva Contraseña"><br>
        </div>
        <div class="col-lg-12">
          <label for="txtcontrare_editar">Repetir Contraseña</label>
          <input type="password" class="form-control" id="txtcontrare_editar" placeholder="Repetir Contraseña"><br>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-primary" onclick="Editar_Contra()"><i class="fa fa-check">&nbsp;<b>Modificar</b></i></button>
        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close">&nbsp;<b>Cerrar</b></i></button>
      </div>
    </div>
  </div>
</div>

<!-- jQuery 3 -->
<script src="../Plantilla/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="../Plantilla/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
	var idioma_espanol = {
   select: {
     rows: "%d fila seleccionada"
   },
   "sProcessing":     "Procesando...",
   "sLengthMenu":     "Mostrar _MENU_ registros",
   "sZeroRecords":    "No se encontraron resultados",
   "sEmptyTable":     "Ning&uacute;n dato disponible en esta tabla",
   "sInfo":           "Registros del (_START_ al _END_) total de _TOTAL_ registros",
   "sInfoEmpty":      "Registros del (0 al 0) total de 0 registros",
   "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
   "sInfoPostFix":    "",
   "sSearch":         "Buscar:",
   "sUrl":            "",
   "sInfoThousands":  ",",
   "sLoadingRecords": "<b>No se encontraron datos</b>",
   "oPaginate": {
     "sFirst":    "Primero",
     "sLast":     "Último",
     "sNext":     "Siguiente",
     "sPrevious": "Anterior"
   },
   "oAria": {
     "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
     "sSortDescending": ": Activar para ordenar la columna de manera descendente"
   }
 }
 

 function cargar_contenido(contenedor,contenido){
  $("#"+contenedor).load(contenido);
}
$.widget.bridge('uibutton', $.ui.button);

function soloNumeros(e){
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==8){
    return true;
  }
      // Patron de entrada, en este caso solo acepta numeros
  patron =/[0-9]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}
function soloLetras(e){
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key).toLowerCase();
  letras = "áéíóúabcdefghijklmnñopqrstuvwxyz";
  especiales = "8-37-39-46";
  tecla_especial = false
  for(var i in especiales){
    if(key == especiales[i]){
      tecla_especial = true;
      break;
    }
  }
  if(letras.indexOf(tecla)==-1 && !tecla_especial){
    return false;
  }
}
</script>
<!-- Bootstrap 3.3.7 -->
<script src="../Plantilla/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="../Plantilla/bower_components/raphael/raphael.min.js"></script>
<!-- Sparkline -->
<script src="../Plantilla/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="../Plantilla/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="../Plantilla/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="../Plantilla/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="../Plantilla/bower_components/moment/min/moment.min.js"></script>
<script src="../Plantilla/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="../Plantilla/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../Plantilla/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../Plantilla/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../Plantilla/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../Plantilla/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!-- AdminLTE for demo purposes -->
<script src="../Plantilla/dist/js/demo.js?rev=<?php echo time();?>"></script>
<script src="../Plantilla/plugins/DataTables/datatables.min.js?rev=<?php echo time();?>"></script>
<script src="../Plantilla/plugins/select2/select2.min.js?rev=<?php echo time();?>"></script>
<script src="../Plantilla/plugins/sweetalert2/sweetalert2.js?rev=<?php echo time();?>"></script>
<script src="../js/usuario.js?rev=<?php echo time();?>"></script>
<script src="../js/docente.js?rev=<?php echo time();?>"></script>
<script src="../js/estudiante.js?rev=<?php echo time();?>"></script>
<script src="../js/calificaciones.js?rev=<?php echo time();?>"></script>
<script src="../js/calendario.js?rev=<?php echo time();?>"></script>
<script src="../js/talleres.js?rev=<?php echo time();?>"></script>
<script src="../js/foro.js?rev=<?php echo time();?>"></script>
<script src="../js/grupos.js?rev=<?php echo time();?>"></script>
<script src="../js/grupos_estudiante.js?rev=<?php echo time();?>"></script>
<script src="../js/registro_clases.js?rev=<?php echo time();?>"></script>
<script src="../js/registro_clases.js?rev=<?php echo time();?>"></script>
<script src="../js/notificaciones.js?rev=<?php echo time();?>"></script>


<script>
  



</script>
</body>
</html> 

