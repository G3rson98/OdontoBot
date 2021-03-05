<!-- Main content -->
<section class="content">
	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Buscar Paciente</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">

			<form class="form-horizontal" method="POST" action="index.php?action=addfichaBuscar">

				<!-- CAMPO CI -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="ci">Ingrese CI:  </label>

					<div class="col-sm-10">

						<input type="text" class="form-control" name="ci_pac" id="ci_pac" placeholder="Ingrese ci" maxlength="20" required>

					</div>

				</div>

			

				
				
				<!--=============================================
				=            Section comment block            =
				=============================================-->
					

				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

						<button type="submit" class="btn btn-primary btn-md">Buscar</button>
						<a href="index.php?view=inicio" type="button" class="btn btn-default btn-md">Cancelar</a>

					</div>
				</div>

			</form>
		</div>
		<!-- /.box-body -->
		
	</div>
	<!-- /.box -->

</section>
<!-- Caja-box-->