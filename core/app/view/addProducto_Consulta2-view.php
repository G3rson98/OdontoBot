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

			<h3 class="text-center">Asignar Precio a los productos: </h3>
			<?php 

				$array=$_POST;
				// echo '<pre>'; print_r($array); echo '</pre>';
			 ?>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">
			<?php  
			echo "<form  name='formulario' class='form-horizontal' method='POST' action='index.php?action=addProducto_Consulta&id_his=$id_his&id_cons=$id_cons&id_pac=$id_pac&id_ficha=$id_ficha'>";
			?>

				

			<div class="form-group">
			    <table  class="table table-bordered table-striped" width="100%">
	                        
	                <thead>

	                    <tr>

	                        <th style="width: 10px;">#</th>
	                        <th>Nombre producto</th>
	                        <th>Precio</th>
	                        <th>Cantidad</th>
	  
	                        

	                    </tr>

	                </thead>

	                <tbody>
	                  <?php
	                    $i=0;
	                    foreach ($array as $key => $value) {
	                    	$cont=count($value);
	                    	// echo '<pre>'; print_r($cont); echo '</pre>';
	                    	while ($i<$cont) {
	                    		$num=$i+1;
	                    		$id_prod=$value[$i];
	                    		$prod=Producto::getProductoById($id_prod);
	                    		// echo '<pre>'; print_r($prod); echo '</pre>';
	                    		echo "
									<tr>
									<td>$num</td>
									<td>".$prod['nombre_prod']."</td>
									<td><input name='precio[]' type='text' required></td>
									<td><input name='cantidad[]' type='text' required></td>
									<td><input type='hidden' name='idProd[]' value='$id_prod'></td>
									</tr>
	                    		";
	                    		$i=$i+1; 
	                    	}

	                    	
	                    	
	                    }
	                  ?>        
	                </tbody>
	                <!-- <i class="fa fa-eraser"></i> -->

	                <tfoot>

	                    <tr>
	                        <th style="width: 10px;">#</th>
	                        <th>Nombre producto</th>
	                        <th>Precio</th>
	                        <th>Cantidad</th>

	                    </tr>

	                </tfoot>

	            </table>
						

			</div>

				

				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

						<button type="submit" class="btn btn-primary btn-md">Guardar</button>
						<?php 
						echo "
						<a href='index.php?view=addProducto_Consulta&id_his=$id_his&id_cons=$id_cons&id_pac=$id_pac&id_ficha=$id_ficha' type='button' class='btn btn-default btn-md'>Cancelar</a>
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
<!-- Caja-box-->