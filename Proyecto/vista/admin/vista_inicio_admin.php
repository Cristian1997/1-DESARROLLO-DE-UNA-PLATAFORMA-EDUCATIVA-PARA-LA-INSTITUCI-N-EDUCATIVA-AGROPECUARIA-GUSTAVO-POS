<script type="text/javascript" src="../js/usuario.js?rev=<?php echo time();?>"></script>

<section class="content">

	<div class="row" id="contenidoprincipaladmin">
		<div class="col-md-12">
			<div class="box box-warning box-solid">
				<!-- /.box-header -->
				<div class="box-body">

					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-aqua">
							<div class="inner">
								<h3 id="txtregistro"></h3>
								<p>Usuarios registrados</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a onclick="cargar_contenido('contenido_principal','usuario/vista_usuario_listar.php')" class="small-box-footer">más información <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>

					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-green">
							<div class="inner">
								<h3 id="txtdocente"></h3>
								<p>Docentes registrados</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a onclick="cargar_contenido('contenido_principal','docente/vista_docente_listar.php')" class="small-box-footer">más información <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>

					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-yellow">
							<div class="inner">
								<h3 id="txtestudiante"></h3>
								<p>Estudiantes registrados</p>
							</div>
							<div class="icon">
								<i class="ion ion-person-add"></i>
							</div>
							<a onclick="cargar_contenido('contenido_principal','estudiante/vista_estudiante_listar.php')" class="small-box-footer">más información <i class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>

					<div class="col-lg-3 col-xs-6">
						<div class="small-box bg-red">
							<div class="inner">
								<h3 id="txtcurso"></h3>
								<p>Cursos</p>
							</div>
							<div class="icon">
								<i class="glyphicon glyphicon-blackboard"></i>
							</div>
							<a href="#" class="small-box-footer">más información <i
                                    class="fa fa-arrow-circle-right"></i></a>
						</div>
					</div>
				</div>
				<!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
	</div>


	<script>
		$(document).ready(function() {
		        TraerDatosContador();
		    });
		
		    $('.box').boxWidget({
		        animationSpeed: 500,
		        collapseTrigger: '[data-widge="collapse"]',
		        removeTrigger: '[data-widge="remove"]',
		        collapseIcon: 'fa-minus',
		        expandIcon: 'fa-plus',
		        removeIcon: 'fa-times'
		    })
		
	</script>
