<!-- Main content -->
<section class="content">

	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Asignar Patologias</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">


			<form class="form-horizontal" method="POST" action="index.php?action=asignarpatologia">
			<?php 
					$id=$_GET["id"];
					$sql = "SELECT * FROM  persona p WHERE p.ci=:id ;";
					$con = Database::getConexion();
					$stmt = $con->prepare($sql);
					$stmt->bindValue(":id",$id,PDO::PARAM_INT);
					$stmt->execute();
					$usuario= $stmt->fetch();
				// echo '<pre>'; print_r($usuario); echo '</pre>';
			 ?>	
				<!-- CAMPO Nombre de usuario -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="nombreUsu">Nombre del Paciente: </label>
					<div class="col-sm-7"> 

						<input type="text" class="form-control" value="<?php echo $usuario['nombre_per'];echo" ";echo$usuario["paterno"];echo" ";echo$usuario["materno"]; ?>" name="nombreUsu" readonly>
						<input type="hidden" class="form-control" value="<?php echo $usuario['ci'] ?>" name="ci" >
					</div>
					
				</div>
				<!--=============================================
				=            Section PERMISOS DEL SISTEMA           =
				=============================================-->
				<div class="form-group">

              		<label class="control-label col-sm-2" for="">Patologias: </label>
                                        <?php $servicio=Patologia::mostrarPatologia();
                                        // echo '<pre>'; print_r($servicio); echo '</pre>';
                                               
                                                $serv_dado=pas_pat::mostrarpatologia($id);
                                                // echo '<pre>'; print_r($serv_dado); echo '</pre>';
                                                
												$array_serv;
												$array_descripcion;
										
										foreach($serv_dado as $key => $value){
											$sub_serv_dado=$serv_dado["$key"];
											$array_serv["$key"]=$sub_serv_dado["id_pat"];
											$array_descripcion["$key"]=$sub_serv_dado["descripcion"];
										}
										
										
									// echo '<pre>'; print_r($array_descripcion); echo '</pre>';
									
									// echo '<pre>'; print_r($array_serv); echo '</pre>';
									$con=0;
										if(isset($array_serv)){
										foreach ($servicio as $key => $value) {
											// echo '<pre>'; print_r($value); echo '</pre>';
												
												if(in_array($value['id_pat'],$array_serv)){
													
													echo
													"<div class='col-sm-offset-3'>
													<div class='checkbox'>
													<label> <input value='".$value['id_pat']."'  type='checkbox' name='servicios[]' checked>".$value['nombre_pat']."</label>
													<input type='text' name='descripcion[]' class='form-control' value='$array_descripcion[$con]'  >
													</div>
													</div>";
													$con+=1;
												}else{
													echo
													"<div class='col-sm-offset-3'>
													<div class='checkbox'>
													<label> <input value='".$value['id_pat']."'  type='checkbox' name='servicios[]'>".$value['nombre_pat']."</label>
													<input type='text' name='descripcion[]' class='form-control'  placeholder='ingresar descripcion'>
													</div></div>";
												}
											}	
										}else{
											foreach ($servicio as $key => $value) {
												echo
													"<div class='col-sm-offset-3'>
													<div class='checkbox'>
													<label> <input value='".$value['id_pat']."'  type='checkbox' name='servicios[]'>".$value['nombre_pat']."</label><input type='text' name='descripcion[]' class='form-control'  placeholder='ingresar descripcion'></div></div>";
										
												}
										}		
											?>        	
        </div>
				<!-- /*=====  End of Section comment block  ======*/ -->
				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

					<button type="submit" class="btn btn-primary btn-md">Guardar</button>
					<a href="index.php?view=paciente" type="button" class="btn btn-default btn-md">Cancelar</a>
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


