<!-- Main content -->
<section class="content">
	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Editar Paciente</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">
			<?php 
				$ci = isset($_GET["id"])? $_GET["id"] : "null";

				$paciente = Paciente::getPacienteByCI($ci);
			 ?>

			 <form class="form-horizontal" method="post" 
			action="index.php?action=editpaciente"  >  

				<!-- CAMPO CI -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="email">CI: </label>

					<div class="col-sm-7">

						<input value="<?php echo $paciente['ci']; ?>" type="text" class="form-control"name="ci_pac" id="ci_pac" readonly>

					</div>

				</div>

				<!-- CAMPO NOMBRE -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="email">Nombre: </label>

					<div class="col-sm-7">

						<input value="<?php echo $paciente['nombre_per']; ?>" type="text" class="form-control" name="nombre_pac" id="nombre_pac" maxlegth="30" required>

					</div>

				</div>
				
				<!-- CAMPO APELLIDO PATERNO -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="pwd">Apellido Paterno: </label>
					<div class="col-sm-7"> 

						<input value="<?php echo $paciente['paterno'];?>" type="text" class="form-control" name="paterno" id="paterno" maxlegth="20" required>

					</div>

				</div>

				<!-- CAMPO APELLIDO MATERNO -->
				<div class="form-group">
					 
					<label class="control-label col-sm-2" for="apellidoMaterno">Apellido Materno:</label>

					<div class="col-sm-7">

						<input value="<?php echo $paciente['materno']; ?>" type="text" class="form-control" name="materno" id="materno" maxlegth="20">
					</div>

				</div>

				
				


				<!-- CAMPO SEXO -->
				<div class="form-group ">

					<label class="control-label col-sm-2" for="sexo">Sexo: </label>

					<div class="col-sm-2"> 

						<label class="control-label radio-inline">
							<?php if($paciente['sexo'] == "M" ){ ?>

							<input value="<?php echo $paciente['sexo']; ?>" type="radio" name="sexo" checked>
						<?php }else{ ?>
							<input value="M" type="radio" name="sexo" >
						<?php } ?>
						M</label>

					</div>
					<div class="col-sm-2"> 
						<label class="control-label radio-inline">
							<?php if($paciente['sexo'] == "F" ){ ?>

							<input value="<?php echo $paciente['sexo']; ?>" type="radio" name="sexo" checked>
						<?php }else{ ?>
							<input value="M" type="radio" name="sexo" >
						<?php } ?>
						F</label>
					</div>
					<div class="col-sm-2"> 
						<label class="control-label radio-inline">
							<?php if($paciente['sexo'] == "O" ){ ?>

							<input value="<?php echo $paciente['sexo']; ?>" type="radio" name="sexo" checked>
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

					<div class="col-sm-3"> 

						<input value="<?php echo $paciente['celular']; ?>" type="text" class="form-control" id="celular" name="celular" maxlegth="11" >

					</div>

					<!-- CAMPO TELEFONO -->
					<label class="control-label col-sm-1" for="email">Telefono:</label>

					<div class="col-sm-3">

						<input value="<?php echo $paciente['telefono']; ?>" type="text" class="form-control" id="telefono" name="telefono" maxlegth="11">

					</div>

				</div>
				
				
				
				<!-- CAMPO Fecha Nacimiento -->
				<div class="form-group">
					 
					<label class="control-label col-sm-2" for="fecha_nac">Fecha Naciento: </label>

					<div class="col-sm-2">

						<input value="<?php echo $paciente['fecha_nac']; ?>" type="date" class="form-control" name="fecha_nac" id="fecha_nac">
					</div>

				</div>
				
				<!-- CAMPO DIRECCION -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="direccion">Direccion: </label>

					<div class="col-sm-7"> 

						<input value="<?php echo $paciente['direccion']; ?>" type="text" class="form-control" id="direccion" name="direccion" maxlegth="50">

					</div>

				</div>

				<!-- CAMPO LUGAR DE NACIMIENTO -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="pwd">Lugar Nacimiento: </label>

					<div class="col-sm-7"> 

						<input value="<?php echo $paciente['lugar_nac']; ?>" type="text" class="form-control" id="lugar_nac" name="lugar_nac" maxlegth="40">

					</div>

				</div>

				<!-- BOTONES DE ACCIONES -->
				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

						<button type="submit" class="btn btn-primary btn-md">Editar paciente</button>
						<a href="index.php?view=paciente" type="button" class="btn btn-default btn-md">Cancelar</a>
					</div>
				</div>

			</form>
		</div>
		<!-- /.box-body -->
	</div>
	<!-- /.box -->

</section>
<!-- Caja-box