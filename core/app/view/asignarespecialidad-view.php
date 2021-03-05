 
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

			<form class="form-horizontal" method="POST" action="index.php?action=editespecialidad">

				<!-- CAMPO NOMBRE -->
				<div class="form-group">
			
					<label class="control-label col-sm-2" for="ci">Escoja la especialidad correspondiente:  </label>

					<div class="col-sm-10">

						 <?php 


						 $especialidad=Especialidad::mostrarEspecialidad();
						 $con=Database::getConexion();
						 $sql="SELECT * FROM odont_espe";
						 $stmt=$con->prepare($sql);
						 $stmt->execute();
						 $ecpodont=$stmt->fetchAll();
						 echo '<pre>'; print_r($ecpodont); echo '</pre>';

						 // foreach ($especialidad as $key => $value) { 

						 		// foreach ($ecpodont as $key2 => $value2) {
						 			
						 			// if ($value["id_esp"]=$value2["id_espe"]) {
						 				
						 	?>
						 			
										 							 
							<!-- 			 	<div class="checkbox">

						                        <label> <input value="" id="" name=""  type="checkbox" checked>
						                         <?php  echo $value["nombre_esp"] ?>
						                        </label>

						                   </div>		

						    <?php } ?>				
 -->



						  

					</div>

				<!-- CAMPO NOMBRE -->

				</div>

				
				
				<!--=============================================
				=            Section comment block            =
				=============================================-->
					

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
<!-- Caja-box