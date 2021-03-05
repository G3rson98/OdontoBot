<!-- Main content -->
<section class="content">
	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">FORMULARIO DE VIDA</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">
			 <?php 
			 $id_historial=$_GET["id_his"];
              $id_consulta=$_GET["id_cons"];
              $id_pac=$_GET['id_pac'];
              $id_ficha=$_GET['id_ficha'];
              $arrayform=FormularioVida::getFormularioByCons($id_consulta,$id_historial); 
              // echo '<pre>'; print_r($arrayform); echo '</pre>';
              
              
			echo "<form class='form-horizontal' method='post' action='index.php?action=editFormularioVida&id_his=$id_historial&id_cons=$id_consulta&ci_per=$id_pac&id_ficha=$id_ficha'>"	;	  
			?>

				<!-- CAMPO ALTURA -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="altura">Altura: </label>

					<div class="col-sm-7">
						
						<input type="text" value="<?php echo $arrayform["altura"] ?>" class="form-control" size="6" name="altura" id="altura" readonly>
						<input type="hidden" value="<?php echo $arrayform["id_for"] ?>" class="form-control" size="6" name="id_for" id="id_for">

					</div>
					<label for="m">m. </label>

				</div>

				<!-- CAMPO PESO -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="peso">Peso: </label>

					<div class="col-sm-7">

						<input type="text" value="<?php echo $arrayform["peso"] ?>" class="form-control"name="peso" id="peso" readonly >

					</div>
					<label for="m">Kg. </label>
				</div>
				
				<!-- CAMPO TEMPERATURA-->
				<div class="form-group">

					<label class="control-label col-sm-2" for="temperatura">Temperatura: </label>
					<div class="col-sm-7"> 

						<input type="text" value="<?php echo $arrayform["temperatura"] ?>" class="form-control" name="temperatura" id="temperatura" readonly>

					</div>
					<label for="m">C. </label>
				</div>

				
				<div class="form-group">
					<!-- CAMPO FREC CARDIACA -->
					<label class="control-label col-sm-2" for="frecuencia_cardiaca">Frecuencia Cardiaca: </label>

					<div class="col-sm-3"> 

						<input type="text" value="<?php echo $arrayform["frecuencia_cardiaca"] ?>" class="form-control" name="frec_cardiaca" id="frec_cardiaca" readonly>

					</div>

					<!-- CAMPO PRESION ARTERIAL -->
					<label class="control-label col-sm-1" for="telefono">Presion Arterial:</label>

					<div class="col-sm-3">

						<input type="text" value="<?php echo $arrayform["precion_arterial"] ?>" class="form-control" name ="prec_arterial" id="prec_arterial" maxlength="6" readonly>

					</div>

				</div>

				

				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">						
						<?php 
						echo "<a href='index.php?view=verconsulta&ci_per=$id_pac&id_ficha=$id_ficha&id_his=$id_historial&id_cons=$id_consulta' type='button' class='btn btn-default btn-md'>Cancelar</a>";
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