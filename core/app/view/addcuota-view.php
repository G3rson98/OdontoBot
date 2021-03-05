<!-- Main content -->
<section class="content">
    <div class="box">
        <!-- CABEZA DE LA CAJA -->
        <div class="box-header with-border">

            <h3 class="text-center">Agregar Cuota</h3>

        </div>
        <!-- CUERPO DE LA CAJA -->
        <div class="box-body">

            <form class="form-horizontal" method="post" action="index.php?action=addcuota">
                <?php 

                    $idNota = $_GET["idnota"];
                    $notaVenta = NotaVenta::mostrarNotaVentaById($idNota);
                    // echo '<pre>'; print_r($notaVenta); echo '</pre>';


                 ?>
                <!-- CAMPO Monto -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="email">Monto Total: </label>

                    <div class="col-sm-4">

                        <input type="text" class="form-control" value="<?php echo $notaVenta["monto"];  ?>"  readonly>

                    </div>

                </div>

            

                <!-- CAMPO Saldo -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="email">Saldo: </label>

                    <div class="col-sm-4">

                        <input type="text" class="form-control" value="<?php echo $notaVenta["saldo"];  ?>"  readonly>

                    </div>

                </div>

                <!-- CAMPO Monto a Pagar -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="email">Monto a Pagar: </label>

                    <div class="col-sm-4">

                        <input type="number" name ="montoAPagar" class="form-control" required >

                        <input type="hidden" name="idNota" value="<?php echo $notaVenta["id_notaventa"];  ?>">
                        <input type="hidden" name="ciPaciente" value="<?php echo $notaVenta["ci_paciente"];  ?>">



                    </div>

                </div>
                
               

                <div class="form-group"> 

                    <div class="col-sm-offset-2 col-sm-10">

                        <button type="submit" class="btn btn-primary btn-md">Agregar</button>
                        <a href="javascript:history.go(-1)" type="button" class="btn btn-default btn-md">Cancelar</a>
                    </div>
                </div>

            </form>
        </div>
        <!-- /.box-body -->
        
    </div>
    <!-- /.box -->

</section>
<!-- Caja-box-->