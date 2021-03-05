<!-- Main content -->
<section  class="content">

    <!-- CAJA DE INSERTAR UN INGRESO --> <!-- style="display: none;" -->
   <div class="box" >

        <div class="box-header with-border" style="background:#ffffff;">

             <h3 class="text-center">Registrando nota venta</h3>

        </div>

                <div class="box-body box-primary">
                    <div class="row">

                        <div class="col-md-12">
                            
                            <form class="form-horizontal" method="post" action="index.php?action=addnotaventa">
                              <?php 
                                $idHist=$_GET["id_his"];
                                $idCons=$_GET["id_cons"];

                                $datosCliente = NotaVenta::mostrarDatosDePaciente($idHist,$idCons);
                                // echo '<pre>'; print_r($datosCliente); echo '</pre>';
                               ?>

                                <div class="form-group">

                                    <!-- CAMPO NIT -->
                                    <label class="control-label col-sm-2" for="email">Nit: </label>

                                    <div class="col-sm-5">

                                        <input type="text" class="form-control" name="ci" value="<?php echo $datosCliente['ci']; ?>"  readonly>
                                        <!-- <input type="hidden" value="<?php echo $datosCliente['ci']; ?>"  readonly> -->

                                    </div>

                                </div>


                                <div class="form-group">
                                    <!-- CAMPO NOMBRE Cliente -->
                                    <label class="control-label col-sm-2" for="email">Nombre Paciente: </label>

                                    <div class="col-sm-6">

                                        <input type="text" class="form-control" value="<?php echo $datosCliente['nombre_paciente']; ?>" readonly>

                                    </div>

                                </div>

                                <div class="form-group">
                                    <!-- CAMPO Lugar Nacimiento -->
                                    <label class="control-label col-sm-2" for="email">Lugar Nacimiento: </label>

                                    <div class="col-sm-6">

                                        <input type="text" class="form-control" value="<?php echo $datosCliente['lugar_nacimiento']; ?>" readonly>

                                    </div>

                                </div>
                                
                              
                             <br>               
                            
                            <br>

                                <h3 class="text-center">Lista Servicios y Productos</h3>

                                <table class="table table-striped table-bordered table-hover dt-responsive tablaIngreso">
                                   <thead>
                                      <tr>
                                         <th style="width: 10px;">#</th>
                                         <th>Tipo</th>
                                         <th>Nombre</th>
                                         <th>Cantidad</th>
                                         <th>Precio</th>
                                         <th>SubTotal</th>
                                      </tr>
                                   </thead>

                                   <tbody >
                                      <tr>
                                        <td></td>
                                      </tr>
                                    <?php 
                                      $servicios = NotaVenta::mostrarServiciosRealizados($idHist,$idCons);
                                      $contador=0;
                                      $montoTotal=0;
                                      foreach ($servicios as $key => $value) {
                                        $contador++;
                                        $montoTotal +=$value["precio"];
                                        echo "<tr>
                                                <td>".($contador)."</td>
                                                <td>Servicio</td>
                                                <td>".$value["nombre_servicio"]."</td>
                                                <td>1</td>
                                                <td>".$value["precio"]."</td>
                                                <td>".$value["precio"]."</td>
                                              </tr>";
                                      }

                                      $productos = NotaVenta::mostrarProductosOcupados($idHist,$idCons);
                                      if(is_array($productos)){

                                        foreach ($productos as $key => $value) {
                                          $contador++;
                                          $subTotal = $value["precio"]*$value["cantidad"];
                                          $montoTotal += $subTotal;
                                          echo "<tr>
                                                <td>".($contador)."</td>
                                                <td>Producto</td>
                                                <td>".$value["nombre_producto"]."</td>
                                                <td>".$value["cantidad"]."</td>
                                                <td>".$value["precio"]."</td>
                                                <td>".$subTotal."</td>
                                              </tr>";
                                        }
                                      }
                                      echo "<tr>
                                                <td></td>
                                                <td>Total a pagar:</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>".$montoTotal." Bs" ."</td>
                                              </tr>";

                                     ?>
                                       
                                   </tbody>
                                   
                                </table>
                                
                                <div class="form-group">

                                    <!-- Monto a Pagar -->
                                    <label class="control-label col-sm-2" for="email">Monto a Pagar: </label>

                                    <div class="col-sm-5">

                                      <?php 
                                        
                                        if(NotaVenta::existeNotaVenta($idHist,$idCons)){
                                          // ya existe factura

                                          $factura = NotaVenta::mostrarNotaVenta($idHist,$idCons);
                                          // echo '<pre>'; print_r($factura); echo '</pre>';
                                          $monto = $factura["monto"]-$factura["saldo"];

                                          echo "<input type ='number' class='form-control' name='montoPago' value='$monto' required>
                                                <input type='hidden' name='idHist' value='$idHist'>
                                                <input type='hidden' name='idCons' value='$idCons'>
                                                <input type='hidden' name='montoTotal' value='$montoTotal'>
                                                ";

                                        }else{

                                          echo"<input type='number' class='form-control' name='montoPago' required>
                                              <input type='hidden' name='idHist' value='$idHist'>
                                        <input type='hidden' name='idCons' value='$idCons'>
                                        <input type='hidden' name='montoTotal' value='$montoTotal'>";

                                        }

                                       ?>

                                    </div>

                                </div>
                                <?php 
                                    if(NotaVenta::existeNotaVenta($idHist,$idCons)){

                                      echo"<button type='submit' class='btn btn-success btn-sm' disabled>Registrar </button>";

                                    }else{

                                      echo"<button type='submit' class='btn btn-success btn-sm'>Registrar </button>";

                                    }
                                 ?>
                                
                                <a href="javascript:history.go(-1)" class="btn btn-primary btn-sm">Cancelar</a>                 
                            </form>
                        </div>
                        <!-- end col-md-12 -->       
                    </div>
                      
                </div>
            
   </div>
   <!-- end of div.box  -->

</section>