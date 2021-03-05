<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center">Lista de Nota de Ventas</h3>
            
            <!-- <a href="index.php?view=addnotacompra" class="btn btn-primary btn-md" type="button" >Nueva nota compra</a> -->

        </div>

        <div class="box-body">

                   
            <table class="table table-bordered table-striped tablas" width="100%">
                        
                <thead>

                    <tr>

                        <!-- <th style="width: 10px;">#</th> -->
                        <th style="width: 80px;">Nro Nota</th>
                        <th>CI</th>
                        <th>Nombre Cliente</th>
                        <th>Fecha</th>
                        <th>Monto Total</th>
                        <th>Estado</th>
                        <th>Operaciones</th>

                    </tr>

                </thead>

                <tbody>
                <?php
                    $notaVentas = NotaVenta::mostrarNotaVentas();
                    // echo '<pre>'; print_r($notaVentas); echo '</pre>';

                    foreach ($notaVentas as $key => $value) {
                        $idNota = $value["id_notaventa"];
                        echo 
                        "<tr>
                            <td>".$idNota."</td>
                            <td>".$value["ci"]."</td>
                            <td>".$value["nombre_paciente"]."</td>
                            <td>".$value["fecha"]."</td>
                            <td>".$value["monto"]."</td>";
                        if($value["saldo"] > 0){
                            echo"
                            <td>
                                <a href='#' class='btn btn-danger btn-sm'>Debe</a>
                            </td>
                            <td>
                                <a href='index.php?view=addcuota&idnota=$idNota' class='btn btn-warning btn-sm'><i class='fa fa-money'></i></a>
                            </td>";
                        }else{

                            echo"
                            <td>
                                <a href='#' class='btn btn-success btn-sm'>Pagado</a>
                            </td>
                            <td>
                                <a href='index.php?view=vernotaventa&id=$idNota' class='btn btn-info btn-sm'><i class='fa fa-eye'></i></a>
                            </td>";

                        }
                        
                    }

                  ?>
                </tbody>


                    

            </table>
                                    

        </div>

    </div>
          
</section>
