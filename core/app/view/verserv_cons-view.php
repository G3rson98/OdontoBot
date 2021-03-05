<!-- Main content -->
<section class="content">

	<div class="box">
		<!-- CABEZA DE LA CAJA -->
		<div class="box-header with-border">
			<h3 class="text-center">Asignar Servicio a la Consulta</h3>
		</div>
		<!-- CUERPO DE LA CAJA -->
		<div class="box-body">

			<form class="form-horizontal" method="POST" action="index.php?action=asignarservicio_consulta">
			<?php 
					$id=$_GET["id"];
					$sql = "SELECT * FROM  persona p WHERE p.ci=:id ;";
					$con = Database::getConexion();
					$stmt = $con->prepare($sql);
					$stmt->bindValue(":id",$id,PDO::PARAM_INT);
					$stmt->execute();
					$usuario= $stmt->fetch();
				// echo '<pre>'; print_r($_GET); echo '</pre>';
			 ?>	
				<!-- CAMPO Nombre de usuario -->
				
				<!--=============================================
				=            Section PERMISOS DEL SISTEMA           =
				=============================================-->
				<div class="form-group">
				<input type="hidden" class="form-control" value="<?php echo $_GET["id"]?>" name="id" >
                      <label class="control-label col-sm-2" for="">Servicios: </label>
                                       
										<?php 	$odontologo=$_SESSION["idPersona"];
												$servicio=Odont_servicio::mostrarservicio($odontologo);																								
												$consulta=Consulta::getconsultabyficha($_GET["id"]);
												$id_con=$consulta["id_con"];
												$id_hist=$consulta["id_historial"];
												 $serv_dado=consulta_servicio::mostrarservicio($id_con,$id_hist);												  
												 $array_serv;
										foreach($serv_dado as $key => $value){
											$sub_serv_dado=$serv_dado["$key"];
											$array_serv["$key"]=$sub_serv_dado["id_serv"];
										}
										
										if(isset($array_serv)){
										foreach ($servicio as $key => $value) {
												
												$id2_servicio=$value["id_serv"];
												$nombre_servicio=Servicio::getservicio($id2_servicio);
												  //echo '<pre>'; print_r($value); echo '</pre>';
												if(in_array($value['id_serv'],$array_serv)){
													$id_servicio=$value['id_serv'];
													$precio_ser=consulta_servicio::getprecio($id_con,$id_hist,$id_servicio);
													// echo '<pre>'; print_r($precio_ser); echo '</pre>';
													echo
													"<div class='col-sm-offset-3'>
													<div class='checkbox'>
                                                    <label> <input value='".$value['id_serv']."'  type='checkbox' name='servicios[]' checked readonly>".$nombre_servicio["nombre_ser"]."</label>                                                
													<input value='".$precio_ser['precio_serv']."' name='precio[]' class='form-control' id='precio'  placeholder='ingresar descripcion'readonly>
													</div>
                                                    <div >
                                                    </div>
                                                    </div>";
												}
											}	
										}else{
                                            echo" No hay Servicios";
											// foreach ($servicio as $key => $value) {
											// 	$id2_servicio=$value["id_serv"];
											// 	$nombre_servicio=Servicio::getservicio($id2_servicio);
											// 	echo
											// 		"<div class='col-sm-offset-3'>
											// 		<div class='checkbox'>
                                            //         <label> <input class='$key' value='".$value['id_serv']."' id='micheck' type='checkbox' name='servicios[]' onClick='on(this.class)'>".$nombre_servicio["nombre_ser"]."</label>
                                                   
                                            //         </div>
                                            //         <div class='precio' id='$key' style='none'>
											// 		<input type='text' name='precio[]' class='form-control' id='precio'  placeholder='ingresar descripcion' >
                                            //         </div >
                                            //         </div>";
										
											// 	}	
										}		
										
											?>
											<input type="hidden" class="form-control" value="<?php echo $_GET["id"]?>" name="id" >
                        <input type="hidden" class="form-control" value="<?php echo $_GET["id_cons"]?>" name="id_cons" >
                        <input type="hidden" class="form-control" value="<?php echo $_GET["id_his"]?>" name="id_his" >
                        <input type="hidden" class="form-control" value="<?php echo $_GET["id_pac"]?>" name="ci_per" >
                        <input type="hidden" class="form-control" value="<?php echo $_GET["id_ficha"]?>" name="id_ficha" >
											
        </div>
				<!-- /*=====  End of Section comment block  ======*/ -->
				<div class="form-group"> 
					<div class="col-sm-offset-2 col-sm-10">					
					<?php
					$id_per=$_GET["id_pac"];
					$id_historial=$_GET["id_his"];
					$id_consulta=$_GET["id_cons"];
					$id_pac=$_GET["id_pac"];
					$id_ficha=$_GET["id_ficha"];			
					// echo '<pre>'; print_r($_GET); echo '</pre>';		
					echo
					"<a href='index.php?view=verconsulta&id_his=$id_hist&id_cons=$id_con&ci_per=$id_per&id_ficha=$id&id=$id' type='button' class='btn btn-default btn-md'>Cancelar</a>";
					?>
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


