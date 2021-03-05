<!-- Main content -->
<section class="content">

	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Editar usuario</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">
			<?php 
				$id = isset($_GET["id"])? $_GET["id"] : "null";

				$usuario = Usuario::getUsuarioByID($id);

				$permisos = Usuario::getPermisos($id);


			 ?>

			<form class="form-horizontal" method="POST" action="index.php?action=editusuario">

				<!-- CAMPO Nombre de usuario -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="nombreUsu">Nombre de usuario: </label>
					<div class="col-sm-7"> 

						<input type="text" class="form-control" value="<?php echo $usuario['nombre_usuario']; ?>" name="nombreUsu">
						<input type="hidden" class="form-control" value="<?php echo $usuario['ci_persona']; ?>" name="ciPersona">

					</div>

				</div>

				<!-- CAMPO PASSWORD -->
				<div class="form-group">
					 
					<label class="control-label col-sm-2" for="password">Password</label>

					<div class="col-sm-7">

						<input type="password" class="form-control" id="password" name="newPassword" placeholder="ingrese nuevo password">
						<input type="hidden" value="<?php echo $usuario['contrasena']; ?>" class="form-control" id="password" name="oldPassword">

					</div>

				</div>

				<!-- SELECCION ROL -->
				<div class="form-group">
              
	                <label class="control-label col-sm-2" for="rol">Rol: </label>
	                <div class="col-sm-7"> 

	                <input type="text" class="form-control" id="rol" name="nombreRol" value="<?php echo $usuario['nombre_rol']; ?>" readonly>
	                <input type="hidden" class="form-control" id="rol" name="idRol" value="<?php echo $usuario['id_rol']; ?>" >
	                </div>
	                
            	</div>
				
				<!--=============================================
				=            Section PERMISOS DEL SISTEMA           =
				=============================================-->
				<div class="form-group">

              		<label class="control-label col-sm-2" for="">Permiso: </label>

		                <div class="col-xs-3">

		                    <div class="checkbox">
		                    	<?php 
									if(Usuario::existePermiso($permisos,"ADM Personal")){
										echo "<label> <input value='1' name='permisos[]'  type='checkbox' checked>ADM Personal</label>";
									}else{
										echo "<label> <input value='1' name='permisos[]'  type='checkbox' >ADM Personal</label>";


									}
						 		?>

		                   </div>

		                    <div class="checkbox">
		                    	<?php 
		                    		if(Usuario::existePermiso($permisos,"ADM Reservas")){
		                    			echo "<label> <input value='2' name='permisos[]' type='checkbox' checked>ADM Reservas</label>";

		                    		}else{
		                    			echo"<label> <input value='2' name='permisos[]' type='checkbox'>ADM Reservas</label>";
		                    		}
		                    	 ?>
		                          

		                   </div>

		                  <div class="checkbox">
		                  		<?php 
		                    		if(Usuario::existePermiso($permisos,"ADM Consultas")){
		                    			echo "<label> <input value='3' name='permisos[]' type='checkbox' checked>ADM Consultas</label>";

		                    		}else{
		                    			echo"<label> <input value='3' name='permisos[]' type='checkbox'>ADM Consultas</label>";
		                    		}
		                    	 ?>

		                   </div>

		                </div>

		              <div class="col-xs-3">

			                <div class="checkbox">
			                	<?php 
		                    		if(Usuario::existePermiso($permisos,"ADM INVENTARIO")){
		                    			echo "<label> <input value='4' name='permisos[]' type='checkbox' checked>ADM INVENTARIO</label>";

		                    		}else{
		                    			echo"<label> <input value='4' name='permisos[]' type='checkbox'>ADM INVENTARIO</label>";
		                    		}
		                    	 ?>

			                </div>

			                  <div class="checkbox">
			                  		<?php 
		                    		if(Usuario::existePermiso($permisos,"SEGURIDAD")){
		                    			echo "<label> <input value='5' name='permisos[]' type='checkbox' checked>SEGURIDAD</label>";

		                    		}else{
		                    			echo"<label> <input value='5' name='permisos[]' type='checkbox'>SEGURIDAD</label>";
		                    		}
		                    	 ?>

			                 </div>

			                 <div class="checkbox">
			                  		<?php 
		                    		if(Usuario::existePermiso($permisos,"FLUJO DE CAJA")){
		                    			echo "<label> <input value='6' name='permisos[]' type='checkbox' checked>FLUJO DE CAJA</label>";

		                    		}else{
		                    			echo"<label> <input value='6' name='permisos[]' type='checkbox'>FLUJO DE CAJA</label>";
		                    		}
		                    	 ?>

			                 </div>

		           		</div>
			           	
              	</div>

				
				
				<!-- /*=====  End of Section comment block  ======*/ -->
				
				
				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

						<button type="submit" class="btn btn-primary btn-md">Editar usuario</button>
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
<!-- Caja-box -->