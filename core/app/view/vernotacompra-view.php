<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h2 class="text-center"> Detalle de la Nota de Compras </h2>
            
            <?php 
              $idNota = $_GET["id"];
              $notaCompra=NotaCompra::getNotaCompra($idNota);

             ?>
        </div>

        <div class="box-body">
        	<div class="row">
        		<div class="col-md-12">
        			
        			<form class="form-horizontal">
			        	<div class="form-group">

				            <!-- CAMPO NIT -->
				            <label class="control-label col-sm-2" for="email">Nit: </label>

				            <div class="col-sm-4">

				                <input type="text" class="form-control" value="<?php echo $notaCompra["nit"] ?>" readonly>

				            </div>

				        </div>


				        <div class="form-group">
				            <!-- CAMPO NOMBRE EMPRESA -->
				            <label class="control-label col-sm-2" for="email">Nombre Emp.: </label>

				            <div class="col-sm-4">

				                <input type="text" class="form-control" value="<?php echo $notaCompra["nombre_emp"] ?>" readonly>

				            </div>

				        </div>

				        <div class="form-group">
				            <!-- CAMPO Fecha -->
				            <label class="control-label col-sm-2" for="email">Fecha : </label>

				            <div class="col-sm-2">

				                <input type="text" class="form-control" value="<?php echo $notaCompra["fecha_cnot"] ?>" readonly>

				            </div>

				        </div>
				        <div class="form-group">
				            <!-- CAMPO Fecha -->
				            <label class="control-label col-sm-2" for="email">Monto Total : </label>

				            <div class="col-sm-2">

				                <input type="text" class="form-control" value="<?php echo $notaCompra["monto_cnot"] ?>" readonly>

				            </div>

				        </div>
				        <br>

	                        <h3 class="text-center">Lista de Materia Prima</h3>

			            <table class="table table-bordered table-striped" width="100%">
			                        
			                <thead>

			                    <tr>

			                        <th style="width: 10px;">#</th>
			                        <th>Nombre</th>
			                        <th>Descripcion</th>
			                        <th>Precio</th>
			                        <th>Cantidad</th>
			                        <th>Monto</th>
			                        <th>Fecha venc.</th>

			                    </tr>

			                </thead>

			                <tbody>
			                <?php

			                	$detalleNota = NotaCompra::getDetalleNotaCompra($idNota);

			                    foreach ($detalleNota as $key => $value) {
			                        echo 
			                        "<tr>
			                            <td>" .($key + 1)."</td>
			                            <td>".($value["nombre_mat"])."</td>
			                            <td>".($value["descripcion_mat"])."</td>
			                            <td>".($value["precio"])."</td>
			                            <td>".($value["cantidad"])."</td>
			                            <td>".($value["cantidad"]* $value["precio"])."</td>
			                            <td>".($value["fecha_venc"])."</td>";
			                          
			                    }


			                  ?>
			                </tbody>

			            </table>
			            <br><br>
			            <a href="javascript:history.go(-1)" class="btn btn-md btn-primary">Atras</a>

                    </form>                
        		</div>
        		<!-- col-md-12 -->
	        </div>
            <!-- div.row -->
        </div>

    </div>
          
</section>



