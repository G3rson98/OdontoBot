<!-- Main content -->
<section class="content">
	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Editar Producto</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">
			<?php 
				$id = isset($_GET["id"])? $_GET["id"] : "null";

				$producto = Producto::getProductoById($id);
				  echo '<pre>'; print_r($producto); echo '</pre>';
				 ?>

			<form class="form-horizontal" method="POST" action="index.php?action=editproducto">

				<!-- CAMPO NOMBRE -->
				<div class="form-group">
			
					<label class="control-label col-sm-2" for="nombre_prod">Nombre Producto:  </label>

					<div class="col-sm-10">

						<input value="<?php echo $producto['nombre_prod']; ?>" type="text" class="form-control" name="nombre_prod" id="nombre_prod" maxlength="80" required >
						<input value="<?php echo $producto['id_prod']; ?>" type="hidden" class="form-control" name="id_prod" id="id_prod" >

					</div>

				<!-- CAMPO NOMBRE -->

				</div>

				
				
				<!--=============================================
				=            Section comment block            =
				=============================================-->
					

				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

						<button type="submit" class="btn btn-primary btn-md">Guardar Cambios</button>
						<a href="index.php?view=producto" type="button" class="btn btn-default btn-md">Cancelar</a>
					</div>
				</div>

			</form>
		</div>
		<!-- /.box-body -->
		
	</div>
	<!-- /.box -->

</section>
<!-- Caja-box-->