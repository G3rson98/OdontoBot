<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Lista de Nota de Compras </h3>
            
            <a href="index.php?view=addnotacompra" class="btn btn-primary btn-md" type="button" >Nueva nota compra</a>

        </div>

        <div class="box-body">

                   
            <table class="table table-bordered table-striped tablas" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>Nit</th>
                        <th>Nombre Empresa</th>
                        <th>Fecha</th>
                        <th>Operaciones</th>

                    </tr>

                </thead>

                <tbody>
                <?php
                    $notaCompras = NotaCompra::mostrarNotaCompas();
                    // echo '<pre>'; print_r($notaCompras); echo '</pre>';


                    foreach ($notaCompras as $key => $value) {
                        echo 
                        "<tr>
                            <td>" .($key + 1)."</td>
                            <td>".($value["nit"])."</td>
                            <td>".($value["nombre_emp"])."</td>
                            <td>".($value["fecha_cnot"])."</td>";
                          $idNota = $value["id_cnot"];
                        echo"
                            <td>
                                <a href='index.php?view=vernotacompra&id=$idNota' class='btn btn-info btn-sm'><i class='fa fa-eye'></i></a>
                            </td>
                        </tr>";
                    }

                  ?>
                </tbody>

                <tfoot>
                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>Nit</th>
                        <th>Nombre Empresa</th>
                        <th>Fecha</th>
                        <th>Operaciones</th>

                    </tr>

                </tfoot>

            </table>
                                    

        </div>

    </div>
          
</section>
