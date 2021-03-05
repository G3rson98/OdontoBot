<!-- Main content -->
<section class="content">
	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Agregar Paciente</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">

			<form class="form-horizontal" method="post" action="index.php?action=addpaciente">

				<!-- CAMPO CI -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="email">CI: </label>

					<div class="col-sm-7">

						<input type="text" class="form-control"name="ci_pac" id="ci_pac" placeholder="ingrese ci" maxlength="20" required>

					</div>

				</div>

				<!-- CAMPO NOMBRE -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="email">Nombre: </label>

					<div class="col-sm-7">

						<input type="text" class="form-control"name="nombre_pac" id="nombre_pac" placeholder="ingrese nombre" maxlength="30" required>

					</div>

				</div>
				
				<!-- CAMPO APELLIDO PATERNO -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="pwd">Apellido Paterno: </label>
					<div class="col-sm-7"> 

						<input type="text" class="form-control" name="paterno" id="paterno" placeholder="ingresar apellido paterno" maxlength="20" required>

					</div>

				</div>

				<!-- CAMPO APELLIDO MATERNO -->
				<div class="form-group">
					 
					<label class="control-label col-sm-2" for="apellidoMaterno">Apellido Materno:</label>

					<div class="col-sm-7">

						<input type="text" class="form-control" name="materno" id="materno" placeholder="ingrese apellido materno" maxlength="20" required>
					</div>

				</div>

		

				<!-- CAMPO SEXO -->
				<div class="form-group ">

					<label class="control-label col-sm-2" for="sexo">Sexo: </label>

					<div class="col-sm-offset-1 col-sm-2"> 

						<label class="control-label radio-inline">

							<input type="radio" name="sexo" id="sexo" value="M">

						M</label>

					</div>
					<div class="col-sm-2"> 
						<label class="control-label radio-inline">
							<input type="radio" name="sexo" id="sexo" value="F">F
						</label>
					</div>
					<div class="col-sm-2"> 
						<label class="control-label radio-inline">
							<input type="radio" name="sexo" id="sexo" value="O">Otros
						</label>
					</div>

				</div>
				
				
				<div class="form-group">
					<!-- CAMPO CELULAR -->
					<label class="control-label col-sm-2" for="celular">Celular: </label>

					<div class="col-sm-3"> 

						<input type="text" class="form-control" name="celular" id="celular" placeholder="ingrese celular" maxlength="11">

					</div>

					<!-- CAMPO TELEFONO -->
					<label class="control-label col-sm-1" for="telefono">Telefono:</label>

					<div class="col-sm-3">

						<input type="text" class="form-control" name ="telefono" id="telefono" placeholder="ingrese telefono" maxlength="11">

					</div>

				</div>

				<!-- CAMPO Fecha Nacimiento -->
				<div class="form-group">
					 
					<label class="control-label col-sm-2" for="fecha_nac">Fecha Naciento: </label>

					<div class="col-sm-2">

						<input type="date" class="form-control" name="fecha_nac" id="fecha_nac" required>
					</div>

				</div>

				<!-- CAMPO DIRECCION -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="direccion">Direccion: </label>

					<div class="col-sm-7"> 

						<input type="text" class="form-control" name="direccion" id="direccion" placeholder="ingrese direccion" maxlength="50">

					</div>

				</div>

				<!-- CAMPO LUGAR DE NACIMIENTO -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="lugar_nac">Lugar Nacimiento: </label>

					<div class="col-sm-7"> 

						<input type="text" class="form-control" name ="lugar_nac" id="lugar_nac" placeholder="ingrese lugar de nacimiento" maxlength="40" required>

					</div>

				</div>

				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

						<button type="submit" class="btn btn-primary btn-md">Agregar paciente</button>
						<a href="index.php?view=paciente" type="button" class="btn btn-default btn-md">Cancelar</a>
					</div>
				</div>

			</form>
		</div>
		<!-- /.box-body -->
		
	</div>
	<!-- /.box -->

</section>
<!-- Caja-box-->