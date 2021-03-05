<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Gestion de patologia </h3>
            
            <a href="index.php?view=addpatologia" class="btn btn-primary btn-md" type="button" >Agregar Patologia</a>

        </div>

        

        <div class="box-body">

                   
            <table id="" class="table table-bordered table-striped tablas" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>Nombre</th>
                        <th>Operacion</th>

                    </tr>

                </thead>

                <tbody>
                <?php
                    $array_patologia = Patologia::mostrarPatologia();
                    // echo '<pre>'; print_r($array_odontologo); echo '</pre>';


                    foreach ($array_patologia as $key => $value) {
                        echo 
                        "<tr>
                            <td>" .($key + 1)."</td>
                            <td>".($value["nombre_pat"])."</td>
                        ";
                        $id=$value["id_pat"];
                        echo "
                            <td>
                            <a href='index.php?view=editpatologia&id=$id' class='btn btn-info btn-sm'><i class='fa fa-edit'></i></a>
                            
                        </td>
                    </tr>";
                    }

                  ?>
                </tbody>

                <tfoot>

                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>Nombre</th>
                        <th>Operacion</th>
                    </tr>

                </tfoot>

            </table>
                                    

        </div>

    </div>
          
</section>
