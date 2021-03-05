<!-- Main content -->
<section class="content">
	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Editar Especialidad</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">
			<?php 
				$id = isset($_GET["id"])? $_GET["id"] : "null";

				$especialidad = Especialidad::getEspecialidadByID($id);
				 // echo '<pre>'; print_r($especialidad); echo '</pre>';
				 ?>

			<form class="form-horizontal" method="POST" action="index.php?action=editespecialidad">

				<!-- CAMPO NOMBRE -->
				<div class="form-group">
			
					<label class="control-label col-sm-2" for="ci">Nombre Especialidad:  </label>

					<div class="col-sm-10">

						<input value="<?php echo $especialidad['nombre_esp']; ?>" type="text" class="form-control" name="nombre_espe" id="nombre_espe" maxlength="30" required >
						<input value="<?php echo $especialidad['id_esp']; ?>" type="hidden" class="form-control" name="id_esp" id="id_esp" >

					</div>

				<!-- CAMPO NOMBRE -->

				</div>

				
				
				<!--=============================================
				=            Section comment block            =
				=============================================-->
					

				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

						<button type="submit" class="btn btn-primary btn-md">Guardar Cambios</button>
						<a href="index.php?view=producto" type="button" class="btn btn-default btn-md">Cancelar</a>
					</div>
				</div>

			</form>
		</div>
		<!-- /.box-body -->
		
	</div>
	<!-- /.box -->

</section>
<!-- Caja-box-->