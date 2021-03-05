<?php 

echo '<pre>'; print_r($_GET); echo '</pre>';
echo '<pre>'; print_r($_POST); echo '</pre>';

 ?>
<!-- Main content -->
<section class="content">
	<?php 
	 $ci=$_GET["ci"];
	 echo '<pre>'; print_r($ci); echo '</pre>';
	 ?>
	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Reservar Ficha</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">

			<?php 
			 echo "<form class='form-horizontal' method='POST' action='index.php?action=addficha&ci=$ci'>";
			 ?>

				<!-- CAMPO Nombre -->
		<!-- 		<div class="form-group">
					
					<label class="control-label col-sm-2" for="nombre_pac">Para el paciente:  </label>

					<div class="col-sm-10">
						<?php 
						echo "<input type='text' class='form-control' name='nombre_pac' id='ci_pac' value='".$array["nombre_per"]." ".$array["paterno"]." ".$array["materno"]."' readonly>";

						 ?>

					</div>

				</div> -->

				<!-- CAMPO Fecha -->
				<div class="form-group">
					 
					<!-- <label class="control-label col-sm-2" for="fechaFicha">Fecha: </label> -->

					<div class="col-sm-10">
						<?php 
						$fecha=$_POST["fechaFicha"];
						echo "
						<input type='hidden' class='form-control' name='fechaFicha' id='fechaFicha' value='$fecha'>
						";
						 ?>
					</div>

				</div>
				
				<!-- CAMPO Hora -->
				<div class="form-group">
					 
					<!-- <label class="control-label col-sm-2" for="horaFicha">Hora: </label> -->

					<div class="col-sm-10">
						<?php 
						$hora=$_POST["horaFicha"];
						echo "
						<input type='hidden' class='form-control' name='horaFicha' id='horaFicha' value='$hora'>
						";
						 ?>	
					</div>

				</div>

				<div class="form-group">
              	
	                <!-- <label class="control-label col-sm-2" for="odontologo">Odontologo: </label> -->
	                <div class="col-sm-10"> 
						<!-- echo "<option value='".$value["ci"]."' name='setOdontologo' >". $value["nombre_per"]. " ".$value["paterno"]." ".$value["materno"]."</option>";
						 -->
						
						<?php 
						 $ci_odont=$_POST["setOdontologo"];
						 echo "<input type='hidden' name='setOdontologo' value='$ci_odont'>";
						 ?>
	                </div>
            	</div>

			
				<div class="form-group">
              		<?php 
              		$array=Servicio::mostrarServicioOdont($ci_odont);
	                // echo '<pre>'; print_r($array); echo '</pre>';
              		?>
	                <label class="control-label col-sm-2" for="Servicio">Servicio: </label>
	                <div class="col-sm-10"> 

	                <select  class="form-control selectEmpleado" name="setServicio" required>
	                
	                  <option value="">Selecionar Servicio</option>

	                  	<?php 
							foreach ($array as $key => $value) {
								echo "<option value='".$value["id_ser"]."' name='setServicio' >". $value["nombre_ser"]. "</option>";
							}

	                  	 ?>     
	                    </select>
	                </div>
	                
            	</div> 

				
				
				<!--=============================================
				=            Section comment block            =
				=============================================-->
					

				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

						<button type="submit" class="btn btn-primary btn-md">Guardar</button>
						<?php 
						 echo "<a href='index.php?view=addFicha&ci=$ci' type='button' class='btn btn-default btn-md'>Cancelar</a>";
						 ?>

					</div>
				</div>

			</form>
		</div>
		<!-- /.box-body -->
		
	</div>
	<!-- /.box -->

</section>
<!-- Caja-box-->