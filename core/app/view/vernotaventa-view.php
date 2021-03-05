<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h2 class="text-center"> Detalle de la Nota de Venta </h2>
            
            <?php 
              $idNota = $_GET["id"];
              $notaVenta = NotaVenta::mostrarNotaVentaById($idNota);

              // echo '<pre>'; print_r($notaVenta); echo '</pre>';
              $idHist= $notaVenta["ID_historial"];
              $idCons= $notaVenta["ID_consulta"];

             ?>
        </div>

        <div class="box-body">
          <div class="row">
            <div class="col-md-12">
              
              <form class="form-horizontal">
                <?php 
                  $datosCliente = NotaVenta::mostrarDatosDePaciente($idHist,$idCons);
                  // echo '<pre>'; print_r($datosCliente); echo '</pre>';
                 ?>
                <div class="form-group">

                    <!-- CAMPO CI -->
                    <label class="control-label col-sm-2" for="email">Nit: </label>

                    <div class="col-sm-4">

                        <input type="text" class="form-control" value="<?php echo $datosCliente ["ci"] ?>" readonly>

                    </div>

                </div>


                <div class="form-group">
                    <!-- CAMPO NOMBRE -->
                    <label class="control-label col-sm-2" for="email">Nombre: </label>

                    <div class="col-sm-4">

                        <input type="text" class="form-control" value="<?php echo $datosCliente["nombre_paciente"] ?>" readonly>

                    </div>

                </div>

                <div class="form-group">
                    <!-- CAMPO Lugar Nacimiento -->
                    <label class="control-label col-sm-2" for="email">Lugar Nac. : </label>

                    <div class="col-sm-4">

                        <input type="text" class="form-control" value="<?php echo $datosCliente["lugar_nacimiento"] ?>" readonly>

                    </div>

                </div>
                <div class="form-group">
                    <!-- CAMPO Fecha -->
                    <label class="control-label col-sm-2" for="email">Fecha nota venta: </label>

                    <div class="col-sm-2">

                        <input type="text" class="form-control" value="<?php echo $notaVenta["fecha"] ?>" readonly>
                    </div>

                </div>
                <div class="form-group">
                    <!-- CAMPO Monto De la Nota de compra -->
                    <label class="control-label col-sm-2" for="email">Monto Total: </label>

                    <div class="col-sm-2">

                        <input type="text" class="form-control" value="<?php echo $notaVenta["monto"] ?>" readonly>
                    </div>

                </div>
                <br>

                          <h3 class="text-center">Lista de Cuotas</h3>

                  <table class="table table-bordered table-striped" width="100%">
                              
                      <thead>

                          <tr>

                              <th style="width: 10px;">#</th>
                              <th>Nombre</th>
                              <th>fecha</th>
                              <th>monto</th>
                          </tr>

                      </thead>

                      <tbody>
                      <?php

                        $cuotas = Cuota::mostrarCuotas($idNota);
                        // echo '<pre>'; print_r($cuotas); echo '</pre>';
                        $montoPagadoTotal = 0;
                          foreach ($cuotas as $key => $value) {
                            $montoPagadoTotal += $value["monto"];
                              echo"<tr>
                                    <td>". ($key + 1)."</td>
                                    <td>Cuota".($key + 1)."</td>
                                    <td>".$value["fecha"]."</td>
                                    <td>".$value["monto"]."</td>
                                  </tr>";
                          }
                          echo"<tr>
                            <td></td>
                            <td></td>
                            <td>monto Total:</td>
                            <td>".$montoPagadoTotal."</td>
                          </tr>";
                        echo"<tr>
                            <td></td>
                            <td></td>
                            <td>Saldo:</td>
                            <td>".($notaVenta["monto"]-$montoPagadoTotal)."</td>
                          </tr>";

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
