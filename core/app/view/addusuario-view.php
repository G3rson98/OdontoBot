<!-- Main content -->
<section class="content">

	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Agregar usuario</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">

			<form class="form-horizontal" action="/action_page.php">

				<!-- SELECCIONAR EMPLEADO (ODONTOLOGO O RECEPCIONISTA) -->

				<div class="form-group">
            	              
	                <label class="control-label col-sm-2" for="pwd">Empleado: </label>
	                <div class="col-sm-10"> 

	                <select  class="form-control selectEmpleado" name="nuevoPerfil" required>
	                
	                  <option value="">Selecionar Empleado</option>
	        
	                      <option value="">Juan - Odomtologo</option>
	                      <option value="">Carlos - Odomtologo</option>
	                      <option value="">Javier - Odomtologo</option>
	                  	  <option value="">Juan - Recepconista</option>
	                  
	                    </select>
	                </div>
	                
            	</div>
           
				<!-- CAMPO Nombre de usuario -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="pwd">Nombre de usuario: </label>
					<div class="col-sm-10"> 

						<input type="text" class="form-control" id="apellidoPaterno" placeholder="ingresar nombre de usuario">

					</div>

				</div>

				<!-- CAMPO PASSWORD -->
				<div class="form-group">
					 
					<label class="control-label col-sm-2" for="apellidoMaterno">Password</label>

					<div class="col-sm-10">

						<input type="password" class="form-control" id="apellidoMaterno" placeholder="ingrese password">

					</div>

				</div>

				<!-- SELECCION ROL -->
				<div class="form-group">
              
	                <label class="control-label col-sm-2" for="pwd">Empleado: </label>
	                <div class="col-sm-10"> 

	                <select  class="form-control selectEmpleado" name="nuevoPerfil" required>
	                
	                  <option value="">Selecionar Rol</option>
	        
	                      <option value="">ADMINISTRADOR</option>
	                      <option value="">ODONTOLOGO</option>
	                      <option value="">RECEPCIONISTA</option>
	                  
	                    </select>
	                </div>
	                
            	</div>
				
				<!--=============================================
				=            Section comment block            =
				=============================================-->
				<div class="form-group">

              		<label class="control-label col-sm-2" for="">Permiso: </label>

		                <div class="col-xs-5">

		                    <div class="checkbox">

		                        <label> <input value="" id="" name=""  type="checkbox">Usuario</label>

		                   </div>

		                    <div class="checkbox">

		                          <label> <input value="" id="chexboxConsVent" name="" type="checkbox">Empleado</label>

		                   </div>

		                  <div class="checkbox">

		                          <label> <input value="" id="chexboxAlm" name="" type="checkbox"> Paciente  </label>

		                   </div>

		                   <div class="checkbox">

		                          <label> <input value="" id="chexboxSeg" name="" type="checkbox"> SEGURIDAD </label>

		                   </div>
		                </div>

		              <div class="col-xs-5">

			                <div class="checkbox">

			                    <label> <input value="" id="chexboxComp" name="" type="checkbox"> INGRESOS </label>

			                </div>

			                  <div class="checkbox">

			                        <label> <input value="" id="chexboxConsComp" name="" type="checkbox"> Compras</label>

			                 </div>

			                <div class="checkbox">

			                        <label> <input value="ESTADISTICAS" id="chexboxEstad" name="" type="checkbox">ESTADISTICAS</label>

			                 </div>

			                 <div class="checkbox">

			                        <label> <input value="MANTENIMIENTO" id="chexboxMant" name="" type="checkbox">MANTENIMIENTO</label>

			                 </div>
		           		</div>
			           	
              	</div>

				
				
				<!-- /*=====  End of Section comment block  ======*/ -->
				
				
				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

						<button type="submit" class="btn btn-primary btn-md">Agregar usuario</button>
						<a href="index.php?view=usuario" type="button" class="btn btn-default btn-md">Cancelar</a>
					</div>
				</div>

			</form>
		</div>
		<!-- /.box-body -->
		<!-- <div class="box-footer">
			Footer
		</div> -->
		<!-- /.box-footer-->
	</div>
	<!-- /.box -->

</section>
<!-- Caja-box