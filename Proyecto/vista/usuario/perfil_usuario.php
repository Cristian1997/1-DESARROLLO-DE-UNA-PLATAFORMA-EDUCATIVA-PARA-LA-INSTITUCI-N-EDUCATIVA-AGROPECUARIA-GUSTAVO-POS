<?php session_start(); ?>

    <style type="text/css">
        /*=====================================
        reset estilos
        no es necesario que copies esto
        =====================================*/
        
        html {
          -webkit-text-size-adjust: 100%;
          -ms-text-size-adjust: 100%;
          text-size-adjust: 100%;
          line-height: 1.4;
        }
        
        
        * {
          margin: 0;
          padding: 0;
          -webkit-box-sizing: border-box;
          -moz-box-sizing: border-box;
          box-sizing: border-box;
        }
        
        body {
          color: #404040;
          font-family: "Arial", Segoe UI, Tahoma, sans-serifl, Helvetica Neue, Helvetica;
        }
        
        /*=====================================
        estilos de la utilidad
        Copiar esto
        =====================================*/
        .seccion-perfil-usuario .perfil-usuario-body,
        .seccion-perfil-usuario {
          display: flex;
          flex-wrap: wrap;
          flex-direction: column;
          align-items: center;
        }
        
        
        
        .seccion-perfil-usuario .perfil-usuario-portada {
          display: block;
          position: relative;
          width: 90%;
          height: 12rem;
          
          border-radius: 0 0 20px 20px;
            /*
            background-image: url('http://localhost/multimedia/png/user-portada-3.png');
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            */
        }
        
      
        .seccion-perfil-usuario .perfil-usuario-portada .boton-portada i {
          margin-right: 1rem;
        }
        
        .seccion-perfil-usuario .perfil-usuario-avatar {
          display: flex;
          width: 180px;
          height: 180px;
          align-items: center;
          justify-content: center;
          border: 7px solid #FFFFFF;
          background-color: #DFE5F2;
          border-radius: 50%;
          box-shadow: 0 0 12px rgba(0, 0, 0, .2);
          position: absolute;
          margin-top: -50px;
          left: calc(50% - 90px);
          z-index: 1;
        }
        
        .seccion-perfil-usuario .perfil-usuario-avatar img {
          width: 100%;
          position: relative;
          border-radius: 50%;
        }
        
        .seccion-perfil-usuario .perfil-usuario-avatar .boton-avatar {
          position: absolute;
          left: -2px;
          top: -2px;
          border: 0;
          background-color: #fff;
          box-shadow: 0 0 12px rgba(0, 0, 0, .2);
          width: 45px;
          height: 45px;
          border-radius: 50%;
          cursor: pointer;
        }
        .switch {
          background: red;
          border-radius: 100px;
          border: none;
          position: relative;
          cursor: pointer;
          display: flex;
          outline: none; }
          .switch::after {
            content: "";
            display: block;
            width: 30px;
            height: 30px;
            position: absolute;
            background: #F1F1F1;
            top: 0;
            left: 0;
            right: unset;
            border-radius: 100px;
            transition: .3s ease all;
            box-shadow: 0px 0px 2px 2px rgba(0, 0, 0, 0.2); }
            .switch.active {
              background: green;
              color: #000; }
              .switch.active::after {
                right: 0;
                left: unset; }
                .switch span {
                  width: 30px;
                  height: 30px;
                  line-height: 30px;
                  display: block;
                  background: none;
                  color: #fff; }
        
                  .grid {
                    display: grid;
                    grid-gap: 40px 20px;
                    grid-template-columns: 1fr 1fr 1fr;
                    padding: 40px 0; }
                    .grid .card {
                      background: #FEFEFE;
                      padding: 20px;
                      border-radius: 5px;
                      box-shadow: 10px 10px 20px rgba(170, 170, 170, 0.16);
                      display: flex;
                      align-items: flex-end;
                      position: relative;
                      min-height: 195px;
                      margin-top: 50px;
                      transition: .3s ease all; }
                      body.dark .grid .card {
                        background: #222222;
                        box-shadow: 10px 10px 20px rgba(0, 0, 0, 0.16); }
                        .grid .card img {
                          vertical-align: top;
                          border-radius: 7px;
                          position: absolute;
                          top: -50px;
                          width: calc(100% - 40px);
                          max-height: 165px;
                          object-fit: cover; }
                          .grid .card .botones {
                            width: 100%;
                            margin-top: 20px;
                            display: grid;
                            grid-gap: 20px;
                            grid-template-columns: 1fr 1fr; }
                            .grid .card .botones .boton {
                              padding: 10px;
                              color: #fff;
                              width: 100%;
                              display: block;
                              background: #111111;
                              text-align: center;
                              border-radius: 5px;
                              transition: .3s ease all; }
                              .grid .card .botones .boton.primario {
                                background: #3E60E9; }
                                .grid .card .botones .boton.primario:hover {
                                  background: #254BE6; }
                                  .grid .card .botones .boton.secundario {
                                    background: #C8C8C8; }
                                    .grid .card .botones .boton.secundario:hover {
                                      background: #ACABAB; }
    </style>
    <script src="../js/usuario.js?rev=<?php echo time();?>"></script>
    <script src="../js/main.js?rev=<?php echo time(); ?>"></script>
    <!-- Content Wrapper. Contains page content -->
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-lg-12">
                    <h1>PERFIL DE  USUARIO</h1>
                </div>
            </div>
        </div>
        <!-- /.container-fluid -->

        <div class="col-lg-12">

            <input type="hidden" value="<?php echo $_SESSION['S_IDUSUARIO']; ?>" id="id_usuario_perfil">
            <input type="hidden" value="<?php echo $_SESSION['S_USER']; ?>" id="usuario_perfil">

            <div class="card">
                <div class="card-body" id="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <section class="seccion-perfil-usuario">
                                            <div class="perfil-usuario-header">
                                                <div class="perfil-usuario-portada">
                                                    <br>
                                                    <br>
                                                    <div class="perfil-usuario-avatar">
                                                        <img class="" alt="User profile picture" id="img_perfil" style="width: 165px; height: 165px; ">
                                                        <button type="button" class="boton-avatar " data-toggle="modal" data-target="#modal_editar_foto">
                                                            <i class="fa fa-camera"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                    <br>
                                    <br>
                                    <br>
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>&nbsp;&nbsp;<i class="fa fa-user"></i>&nbsp;Usuario</b>
                                            <a class="float-right">
                                                <?php echo $_SESSION['S_USER']; ?>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>&nbsp;&nbsp;<i class="fa fa-credit-card"></i>&nbsp;Nombre</b>&nbsp;
                                            <a class="float-right">
                                                <label id="lbl_nombre"></label>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>&nbsp;&nbsp;<i id="icono_sexo" class="fa"></i>&nbsp;Sexo</b>&nbsp;
                                            <a class="float-right">
                                                <label id="sexo"></label>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>&nbsp;<i class="fa fa-spinner"></i>&nbsp;Rol</b>&nbsp;
                                            <a class="float-right">
                                                <label id="rol"></label>
                                            </a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>&nbsp;  <i class="fa fa-envelope"></i>&nbsp;Correo</b> &nbsp;
                                            <a href="">
                                                <label id="email"></label>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="row">
                                        <div class="col-sm-12 text-center">
                                            <a href="#" class="btn btn-primary btn-block" onclick="Abrir_modal_editar_contra()">
                                                <b><i class="fa fa-edit"></i>&nbsp;Cambiar Contrase&nacute;a</b>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Modal -->

    <div class="modal fade" id="modal_editar_foto" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content ">
                <div class="modal-header ">

                    <h5 class="modal-title text-center" id="exampleModalLabel">Editar foto Del usuario  <label for="" id="lb_user"></label></h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-lg-12">
                            <br>
                            <label for="">Foto</label>
                            <br>
                            <input type="hidden" id="txt_id_usuario_editar_foto">
                            <input type="hidden" id="txt_usuario_editar">
                            <input type="file" id="img_foto_editar" onchange="mostrarVistaPrevia()">
                            <br>
                            <img id="vista_previa" src="#" alt="" style="max-width: 100%; max-height: 200px; display: block; margin: 0 auto;">
                            <p style="text-align: center;">Vista previa de la imagen</p>
                        </div>
                      
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="editar_usuario_foto_perfil()">Editar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_editar_contra" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title" style="text-align: center;"><b>Cambiar Contrase&ntilde;a</b></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                      
                        <div class="col-lg-12">
                            <input type="text" id="txtcontra_bd" hidden>
                            <label for="">Contrase&ntilde;a actual</label>
                            <input type="password" class="form-control" id="txt_con_actual" placeholder="Ingrese contrase&ntilde;a actual">
                            <br>
                        </div>
                      
                        <div class="col-lg-12">
                            <label for="">Contrase&ntilde;a</label>
                            <input type="password" class="form-control" id="txt_con_nuevo" placeholder="Ingrese nueva contrase&ntilde;a">
                            <br>
                        </div>
                      
                        <div class="col-lg-12">
                            <label for="">Repita la Contrase&ntilde;a</label>
                            <input type="password" class="form-control" id="txt_con_repetir" placeholder="Repita contrase&ntilde;a">
                            <br>
                        </div>
                      
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" onclick="Editar_contra()"><i class="fa fa-check"><b>&nbsp;Cambiar Contrase&ntilde;a</b></i></button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                </div>
            </div>
        </div>
    </div>

    <form autocomplete="false" onsubmit="return false" id="modal1">
        <div class="modal fade" id="modal_editar" role="dialog">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title"><b>Modificar Usuario</b></h4>
                    </div>
                    <div class="modal-body">
                      
                        <div class="col-lg-12">
                            <input type="text" id="txtidusuario">
                            <label for="">Usuario</label>
                            <input type="text" class="form-control" id="txt_usu_editar" placeholder="Ingrese usuario" disabled>
                            <br>
                        </div>
                      
                        <div class="col-lg-12">
                            <label for="">Sexo</label>
                            <select class="js-example-basic-single" name="state" id="cbm_sexo_editar" style="width:100%;">
                                <option value="M">MASCULINO</option>
                                <option value="F">FEMENINO</option>
                            </select>
                            <br>
                            <br>
                        </div>

                        <div class="col-lg-12">
                            <label for="">Rol</label>
                            <select class="js-example-basic-single" name="state" id="cbm_rol_editar" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>
                      
                        <div class="col-lg-12">
                            <label for="">Eps</label>
                            <select class="js-example-basic-single" name="state" id="cbm_eps_editar" style="width:100%;">
                            </select>
                            <br>
                            <br>
                        </div>

                        <div class="col-lg-12">
                            <label for="">Email</label>
                            <input type="text" class="form-control" id="txt_email_editar" placeholder="Ingrese Email">
                            <label for="" id="emailval_editar" style="color: red;"></label>
                            <input type="text" id="validar_email_editar" hidden>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" onclick="Modificar_Usuario_Perfil()"><i class="fa fa-check"><b>&nbsp;Modificar</b></i></button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-close"><b>&nbsp;Cerrar</b></i></button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <script>
        document.getElementById('img_foto_editar').addEventListener("change" , () => {
                    var FileName  = document.getElementById('img_foto_editar').value;
                    var idDot = FileName.lastIndexOf(".") + 1;
                    var exfile = FileName.substr(idDot , FileName.length).toLowerCase();
                    if (exfile =="jpg" || exfile == "jpeg" || exfile == "png") {

                    }else{
                      document.getElementById('img_foto_editar').value = "";
                      Swal.fire("Mensaje De Advertencia", "SOLO SE ACEPTA IMAGENES - USTED SUBIO UN ARCHIVO CON EXTENCION "+exfile,"warning");
                    }
                  });  
                  document.getElementById('img_foto').addEventListener("change" , () => {
                    var FileName  = document.getElementById('img_foto').value;
                    var idDot = FileName.lastIndexOf(".") + 1;
                    var exfile = FileName.substr(idDot , FileName.length).toLowerCase();
                    if (exfile =="jpg" || exfile == "jpeg" || exfile == "png") {

                    }else{
                      document.getElementById('img_foto').value = "";
                      Swal.fire("Mensaje De Advertencia", "SOLO SE ACEPTA IMAGENES - USTED SUBIO UN ARCHIVO CON EXTENCION "+exfile,"warning");
                    }
                  });
    </script>

    <script>
        $(document).ready( function () {
                   $('.js-example-basic-single').select2();
                   TraerDatos();
                   TraerDatosUsuario();
                   listar_combo_rol();
                   listar_combo_eps();
                   listar_combo_status();
                 } );
                 function mostrarVistaPrevia() {
  var input = document.getElementById('img_foto_editar');
  var vistaPrevia = document.getElementById('vista_previa');

  var archivo = input.files[0];
  var lector = new FileReader();

  lector.onload = function (e) {
    vistaPrevia.src = e.target.result;
  };

  if (archivo) {
    lector.readAsDataURL(archivo);
  }
}
    </script>
