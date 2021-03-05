<!-- Main content -->
<section class="content">

	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Asignar Materiales</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">


			<form class="form-horizontal" method="POST" action="index.php?action=asignarMaterial">
			<?php 
					$id=$_GET["id"];
					$array_Servicio=Servicio::getservicio($id);
				//echo '<pre>'; print_r($arrya_Servicio); echo '</pre>';
				
			 ?>	
				<!-- CAMPO Nombre de usuario -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="nombreUsu">Nombre del Servicio: </label>
					<div class="col-sm-7"> 

						<input type="text" class="form-control" value="<?php echo $array_Servicio['nombre_ser']; ?>" name="nombreUsu" readonly>
						<input type="hidden" class="from-control" value="<?php echo $array_Servicio['id_ser'] ?>" name="id_ser">
						
						
					</div>
					
				</div>
				<!--=============================================
				=            Section PERMISOS DEL SISTEMA           =
				=============================================-->
				<div class="form-group">

			<label class="control-label col-sm-2" for="">
				Materiales: </label>
				<table id="" class="table table-bordered table-striped" width="100%">
				<thead>
					<tr>
						
						<th>Nº</th>
						<th>Nombre del Material</th>
						<th>Cantidad de Uso en el servicio</th>
					</tr>

                </thead>
					<tbody>
						<?php
								$Materiales=MateriaPrima::mostrarMateriaPrima();
								//echo '<pre>'; print_r($Materiales); echo '</pre>';
								$editMat=servMat::get_SerxMat($id);
								//echo '<pre>'; print_r($editMat); echo '</pre>';
								foreach ($Materiales as $key => $value) {
									
									echo 	"<tr>
												<td>".($key+1)."</td>
												<td>".$value["nombre_mat"]."</td>
												
												";
									if (servMat::existeMat_en_serv($value["id_mat"],$editMat)) {
											//echo '<pre>'; print_r($editMat); echo '</pre>';
										foreach ($editMat as $key => $value1) {

												if ($value["id_mat"]==$value1["id_mat_pri"]) {
													$Ant_cant_usada=$value1["cant_usos_serv"];
												}
											}
											//echo $Ant_cant_usada;	
										echo "<td><input type='text' size='10'
										value='".$Ant_cant_usada."' maxlength='2'name='cantUsada[]' >
											</td>";
									}else{
										echo	"<td><input type='text' size='10' maxlegth='2'name='cantUsada[]'>";
									}			
									
												echo "	<td>	
												<input type='hidden' value='".$value["id_mat"]."' name='idmat[]'>
												</td>
												<td>
												
												</td>
											</tr>";


											
											
								}
								

							?>
					</tbody>
					<tfoot>
							<tr>
								
								<th>Nº</th>
								<th>Nombre del Material</th>
								<th>Cantidad de Uso en el servicio</th>
							</tr>
					</tfoot>
				
					  </table>
					  
						
							
				</div>
				<!-- /*=====  End of Section comment block  ======*/ -->
				
				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

					<button type="submit" class="btn btn-primary btn-md">Guardar</button>
					<a href="index.php?view=servicio" type="button" class="btn btn-default btn-md">Cancelar</a>
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
<!-- Caja-box-->