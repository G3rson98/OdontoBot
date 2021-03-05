<!-- Main content -->
<section class="content">
	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Editar Odontologo</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">
			<?php 
				$ci = isset($_GET["id"])? $_GET["id"] : "null";



				
				$odontologo = Odontologo::getOdontologoByCI($ci);
				// echo '<pre>'; print_r($odontologo); echo '</pre>';
			 ?>
			<form class="form-horizontal" method="POST" action="index.php?action=editodontologo">

				<!-- CAMPO CI -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="ci">CI: </label>

					<div class="col-sm-10">

						<input value="<?php echo $odontologo['ci_odont']; ?>" type="text" class="form-control" name="ci" id="ci" readonly>

					</div>

				<!-- CAMPO NOMBRE -->

				</div>

				<div class="form-group">

					<label class="control-label col-sm-2" for="nombre">Nombre: </label>

					<div class="col-sm-10">

						<input  value="<?php echo $odontologo['nombre_per']; ?>"type="text" class="form-control" name="nombre" id="nombre" maxlength="30" required>

					</div>

				</div>

				<!-- CAMPO APELLIDO PATERNO -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="apellidoPaterno">Apellido Paterno: </label>
					<div class="col-sm-10"> 

						<input  value="<?php echo $odontologo['paterno']; ?>"type="text" class="form-control" name="apellidoPaterno" id="apellidoPaterno" maxlength="20" required>

					</div>

				</div>

				<!-- CAMPO APELLIDO MATERNO -->
				<div class="form-group">
					 
					<label class="control-label col-sm-2" for="apellidoMaterno">Apellido Materno:</label>

					<div class="col-sm-10">

						<input  value="<?php echo $odontologo['materno']; ?>" type="text" class="form-control" name="apellidoMaterno"id="apellidoMaterno" maxlength="20">
					</div>

				</div>

		

				<!-- CAMPO SEXO -->
				<div class="form-group ">

					<label class="control-label col-sm-2" for="sexo">Género: </label>

					<div class="col-sm-offset-1 col-sm-3"> 

						<label class="control-label radio-inline">

						<?php if($odontologo['sexo'] == "M" ){ ?>

							<input value="<?php echo $odontologo['sexo']; ?>" type="radio" name="sexo" checked>
						<?php }else{ ?>
							<input value="M" type="radio" name="sexo" >
						<?php } ?>

						M</label>

					</div>
					<div class="col-sm-3"> 
						<label class="control-label radio-inline">
							<?php if($odontologo['sexo'] == "F" ){ ?>

							<input value="<?php echo $odontologo['sexo']; ?>" type="radio" name="sexo" checked>
						<?php }else{ ?>
							<input value="M" type="radio" name="sexo" >
						<?php } ?> F
						</label>
					</div>
					<div class="col-sm-3"> 
						<label class="control-label radio-inline">
							<?php if($odontologo['sexo'] == "O" ){ ?>

							<input value="<?php echo $odontologo['sexo']; ?>" type="radio" name="sexo" checked>
						<?php }else{ ?>
							<input value="O" type="radio" name="sexo" >
						<?php } ?>
							Otros
						</label>
					</div>

				</div>
				
				
				<div class="form-group">
					<!-- CAMPO CELULAR -->
					<label class="control-label col-sm-2" for="pwd">Celular: </label>

					<div class="col-sm-4"> 

						<input  value="<?php echo $odontologo['celular']; ?>"type="text" class="form-control" name="celular" id="celular" maxlength="11">

					</div>

					<!-- CAMPO TELEFONO -->
					<label class="control-label col-sm-2" for="telefono">Telefono:</label>

					<div class="col-sm-4">

						<input  value="<?php echo $odontologo['telefono']; ?>" type="text" class="form-control" name="telefono" id="telefono" maxlength="11">

					</div>

				</div>

				<!-- CAMPO Fecha Nacimiento -->
				<div class="form-group">
					 
					<label class="control-label col-sm-2" for="fechaNacimiento">Fecha Naciento: </label>

					<div class="col-sm-10">

						<input  value="<?php echo $odontologo['fecha_nac']; ?>" type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" required>
					</div>

				</div>

				<!-- CAMPO DIRECCION -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="direccion">Direccion: </label>

					<div class="col-sm-10"> 

						<input  value="<?php echo $odontologo['direccion']; ?>" type="text" class="form-control" name="direccion" id="direccion" maxlength="50" >

					</div>

				</div>

				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

						<button type="submit" class="btn btn-primary btn-md">Guardar Cambios</button>
						<a href="index.php?view=odontologo" type="button" class="btn btn-default btn-md">Cancelar</a>
					</div>
				</div>

			</form>
		</div>
		<!-- /.box-body -->
		
	</div>
	<!-- /.box -->

</section>
<!-- Caja-box-->