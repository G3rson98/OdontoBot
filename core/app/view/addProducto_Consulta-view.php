<!-- Main content -->

<?php 
$array=$_GET;
$id_his=$array['id_his'];
$id_cons=$array['id_cons'];
$id_pac=$array['id_pac'];
$id_ficha=$array['id_ficha'];
// echo '<pre>'; print_r($array); echo '</pre>';
 ?>
<section class="content">
	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Asignar Producto</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">
			<?php 
			echo "<form  name='formulario' class='form-horizontal' method='POST' action='index.php?view=addProducto_Consulta2&id_his=$id_his&id_cons=$id_cons&id_pac=$id_pac&id_ficha=$id_ficha'>";
			 ?>

				<?php 
					$array=ConsultaProducto::mostrarProdActivosNoUsados($id_his,$id_cons);
				    // echo '<pre>'; print_r($array); echo '</pre>';
				 ?>


				<div class="form-group">

					<label class="control-label col-sm-2" for="ci">Escoja el/los productos correspondiente:  </label>

					<div class="col-sm-10">

 						<?php 
 							foreach ($array as $key => $value) {
						 			$id_prod=$value["id_prod"];
						 			$nombre_prod=$value['nombre_prod']	;		
						 			$Precio=" Precio:"	
						 				;
							
	 						echo "
							
							<div>
							<label >
							<input type='checkbox' name='prod[]' value='$id_prod'>$nombre_prod
							</label>
							
							</div>

	 						";
								
 							}

 						 ?>
					</div>

				</div>

				
				
				<!--=============================================
				=            Section comment block            =
				=============================================-->
					

				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

						<button type="submit" class="btn btn-primary btn-md">Guardar</button>
						<?php 
						echo "<a href='index.php?view=addconsulta&ci_per=$id_pac&id_ficha=$id_ficha&id_his=$id_his&id_cons=$id_cons' type='button' class='btn btn-default btn-md'>Cancelar</a>";
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