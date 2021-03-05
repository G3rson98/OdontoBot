<!-- Main content -->
<section class="content">

	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">

			<h3 class="text-center">Asignar Servicio</h3>

		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">


			<form class="form-horizontal" method="POST" action="index.php?action=asignarservicio">
			<?php 
					$id=$_GET["id"];
					$sql = "SELECT * FROM  persona p WHERE p.ci=:id ;";
					$con = Database::getConexion();
					$stmt = $con->prepare($sql);
					$stmt->bindValue(":id",$id,PDO::PARAM_INT);
					$stmt->execute();
					$usuario= $stmt->fetch();
			//	echo '<pre>'; print_r($usuario); echo '</pre>';
			 ?>	
				<!-- CAMPO Nombre de usuario -->
				<div class="form-group">

					<label class="control-label col-sm-2" for="nombreUsu">Nombre del Odontologo: </label>
					<div class="col-sm-7"> 

						<input type="text" class="form-control" value="<?php echo $usuario['nombre_per'];echo" ";echo$usuario["paterno"];echo" ";echo$usuario["materno"]; ?>" name="nombreUsu" readonly>
						<input type="hidden" class="form-control" value="<?php echo $usuario['ci'] ?>" name="ci" >
					</div>
					
				</div>
				<!--=============================================
				=            Section PERMISOS DEL SISTEMA           =
				=============================================-->
				<div class="form-group">

              		<label class="control-label col-sm-2" for="">Servicio: </label>
										<?php $servicio=Servicio::mostrarServicio();
												$serv_dado=Odont_servicio::mostrarservicio($id);
												$array_serv;
										foreach($serv_dado as $key => $value){
											$sub_serv_dado=$serv_dado["$key"];
											$array_serv["$key"]=$sub_serv_dado["id_serv"];
										}
										if(isset($array_serv)){
										foreach ($servicio as $key => $value) {
											
												if(in_array($value['id_ser'],$array_serv)){
													echo
													"<div class='col-sm-offset-3'>
													<div class='checkbox'>
													<label> <input value='".$value['id_ser']."'  type='checkbox' name='servicios[]' checked>".$value['nombre_ser']."</label></div></div>";
												}else{
													echo
													"<div class='col-sm-offset-3'>
													<div class='checkbox'>
													<label> <input value='".$value['id_ser']."'  type='checkbox' name='servicios[]'>".$value['nombre_ser']."</label></div></div>";
												}
											}	
										}else{
											foreach ($servicio as $key => $value) {
												echo
													"<div class='col-sm-offset-3'>
													<div class='checkbox'>
													<label> <input value='".$value['id_ser']."'  type='checkbox' name='servicios[]'>".$value['nombre_ser']."</label></div></div>";
										
												}
										}		
											?>        	
        </div>
				<!-- /*=====  End of Section comment block  ======*/ -->
				<div class="form-group"> 

					<div class="col-sm-offset-2 col-sm-10">

					<button type="submit" class="btn btn-primary btn-md">Guardar</button>
					<a href="index.php?view=odontologo" type="button" class="btn btn-default btn-md">Cancelar</a>
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
<!-- Caja-box


