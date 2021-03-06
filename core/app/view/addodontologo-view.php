<!-- Main content -->
<section class="content">
	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Agregar Odontologo</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">

			<form class="form-horizontal" method="POST" action="index.php?action=addodontologo">

				<!-- CAMPO CI -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="ci">CI: </label>

					<div class="col-sm-7">

						<input type="text" class="form-control" name="ci" id="ci" placeholder="Ingrese CI" maxlength="20"required>

					</div>

				<!-- CAMPO NOMBRE -->

				</div>

				<div class="form-group">

					<label class="control-label col-sm-2" for="nombre">Nombre: </label>

					<div class="col-sm-7">

						<input type="text" class="form-control" name="nombre" id="nombre" placeholder="Ingrese Nombre" maxlength="30" required>

					</div>

				</div>

				<!-- CAMPO APELLIDO PATERNO -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="apellidoPaterno">Apellido Paterno: </label>
					<div class="col-sm-7"> 

						<input type="text" class="form-control" name="apellidoPaterno" id="apellidoPaterno" placeholder="Ingresar apellido paterno" maxlength="20" required>

					</div>

				</div>

				<!-- CAMPO APELLIDO MATERNO -->
				<div class="form-group">
					 
					<label class="control-label col-sm-2" for="apellidoMaterno">Apellido Materno:</label>

					<div class="col-sm-7">

						<input type="text" class="form-control" name="apellidoMaterno"id="apellidoMaterno" placeholder="Ingrese apellido materno" maxlength="20" required>
					</div>

				</div>

		

				<!-- CAMPO SEXO -->
				<div class="form-group ">

					<label class="control-label col-sm-2" for="sexo">Género: </label>

					<div class="col-sm-offset-1 col-sm-1"> 

						<label class="control-label radio-inline">

							<input type="radio" name="sexo" value="M">

						M</label>

					</div>
					<div class="col-sm-1"> 
						<label class="control-label radio-inline">
							<input type="radio" name="sexo" value="F">F
						</label>
					</div>
					<div class="col-sm-1"> 
						<label class="control-label radio-inline">
							<input type="radio" name="sexo" value="O" >Otros
						</label>
					</div>

				</div>
				
				
				<div class="form-group">
					<!-- CAMPO CELULAR -->
					<label class="control-label col-sm-2" for="pwd">Celular: </label>

					<div class="col-sm-3"> 

						<input type="text" class="form-control" name="celular" id="celular" placeholder="ingrese celular" maxlength="11" >

					</div>

					<!-- CAMPO TELEFONO -->
					<label class="control-label col-sm-1" for="telefono">Telefono:</label>

					<div class="col-sm-3">

						<input type="text" class="form-control" name="telefono" id="telefono" placeholder="ingrese telefono" maxlength="11">

					</div>

				</div>

				<!-- CAMPO Fecha Nacimiento -->
				<div class="form-group">
					 
					<label class="control-label col-sm-2" for="fechaNacimiento">Fecha Naciento: </label>

					<div class="col-sm-2">

						<input type="date" class="form-control" name="fechaNacimiento" id="fechaNacimiento" required>
					</div>

				</div>

				<!-- CAMPO DIRECCION -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="direccion">Direccion: </label>

					<div class="col-sm-7"> 

						<input type="text" class="form-control" name="direccion" id="direccion" placeholder="Ingrese direccion" maxlength="50">

					</div>

				</div>

		
           
				<!-- CAMPO Nombre de usuario -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="nombreUsuario">Nombre de usuario: </label>
					<div class="col-sm-7"> 

						<input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" placeholder="ingresar nombre de usuario" maxlength="30" required>

					</div>

				</div>

				<!-- CAMPO PASSWORD -->
				<div class="form-group">
					 
					<label class="control-label col-sm-2" for="password">Password</label>

					<div class="col-sm-7">

						<input type="password" class="form-control" name="password" id="password" placeholder="ingrese password" maxlength="32" required>

					</div>

				</div>

				<!-- SELECCION ROL -->
				<div class="form-group">
              
	                <label class="control-label col-sm-2" for="nombre_rol">Roles: </label>
	                <div class="col-sm-7"> 

	                <select id="selectUsuario"  class="form-control selectEmpleado" name="nombre_rol" required>
	                
	                  <option value="">Selecionar Rol</option>
                  
					  <option value="1" name='nombre_rol' > Administrador</option>
					  <option value="2" name='nombre_rol' > Odontologo</option>
						
	                    </select>
	                </div>
	                
            	</div>
				
				<!--=============================================
				=            Section PERMISOS DEL SISTEMA           =
				=============================================-->
				<div class="form-group">

              		<label class="control-label col-sm-2" for="">Permiso: </label>

		                <div class="col-xs-3">

		                    <div class="checkbox">

		                        <label> <input value="1" id="" name="permisos[]"  type="checkbox">ADM Personal</label>

		                   </div>

		                    <div class="checkbox">

		                          <label> <input value="2" id="" name="permisos[]" type="checkbox">ADM Reservas</label>

		                   </div>

		                  <div class="checkbox">

		                          <label> <input value="3" id="" name="permisos[]" type="checkbox">ADM Consultas</label>

		                   </div>

		                </div>

		              <div class="col-xs-3">

			                <div class="checkbox">

			                    <label> <input value="4" id="" name="permisos[]" type="checkbox"> ADM INVENTARIO </label>

			                </div>

			                <div class="checkbox">

			                        <label> <input value="6" id="" name="permisos[]" type="checkbox"> FLUJO DE CAJA</label>

			                 </div>

			                  <div class="checkbox">

			                        <label> <input value="5" id="" name="permisos[]" type="checkbox"> SEGURIDAD</label>

			                 </div>

		           		</div>
			           	
              	</div>

				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

						<button type="submit" class="btn btn-primary btn-md">Agregar Odontólogo</button>
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