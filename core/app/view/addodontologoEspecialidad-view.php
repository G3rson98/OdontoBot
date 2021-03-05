<section class="content">
	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<?php 
				$id = isset($_GET["id"])? $_GET["id"] : "null";

				$odontologo = Odontologo::getOdontologoByCI($id);
				 // echo '<pre>'; print_r($odontologo); echo '</pre>';
		 ?>
		<div class="box-header with-border">
			
			<h3 class="text-center">Asignar Especialidad al Odontologo: <?php echo $odontologo["nombre_per"]." ". $odontologo["paterno"]." " .$odontologo["materno"];?></h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">

			<?php 
			echo "<form class='form-horizontal' method='POST' action='index.php?action=addOdontologoEspecialidad&id=$id'>"
			 ?>

				<!-- CAMPO NOMBRE -->
				<div class="form-group">
			
					<label class="control-label col-sm-2" for="ci">Escoja la especialidad correspondiente:  </label>

					<div class="col-sm-10">

						 <?php 
						 $odontologoEspecialidad=odontologoEspecialidad::mostrarEspecialidadesNoAsignadas($id);
						 // echo '<pre>'; print_r($id); echo '</pre>';
						  // echo '<pre>'; print_r($odontologoEspecialidad); echo '</pre>';

						 foreach ($odontologoEspecialidad as $key => $value) {
						 	echo "
						 		<div class='checkbox'>

						                        <label> <input id='' name='array[]' value='".$value["id_esp"]."' name='' type='checkbox' >".
						                        $value["nombre_esp"].
						                       	"	
						                        </label>

						        </div>		
						 	";
			
						 }

						 				
						 	?>
		
					</div>

				<!-- CAMPO NOMBRE -->

				</div>

				
				
				<!--=============================================
				=            Section comment block            =
				=============================================-->
					

				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

						<button type="submit" class="btn btn-primary btn-md">Guardar Cambios</button>
						<?php 
						echo "
						<a href='index.php?view=odontologoEspecialidad&id=$id' type='button' class='btn btn-default btn-md'>Cancelar</a>
						";
						 ?>
					</div>
				</div>

			</form>
		</div>
		<!-- /.box-body -->
		
	</div>
	<!-- /.box -->

</section>
<!-- Caja-box -->