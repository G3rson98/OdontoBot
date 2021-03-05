<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center">Productos Usados</h3>
            
            <!-- <a href="index.php?view=addproducto" class="btn btn-primary btn-md" type="button" >Agregar Producto</a> -->

        </div>

        <div class="box-body">
                   
            <table id="" class="table table-bordered table-striped" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>Nombre Producto</th>
                        <th>Estado</th>
                        <!-- <th>Operaciones</th> -->

                    </tr>

                </thead>

                <tbody>
                  <?php
                    $id_consulta=$_GET["id_cons"];
                    $id_historial=$_GET["id_his"];                                         
                     $sql ="SELECT producto.nombre_prod,prod_con.precio_prod from prod_con,producto,consulta where producto.id_prod=prod_con.id_prod and prod_con.id_consulta=consulta.id_con and prod_con.id_historial=consulta.id_historial and consulta.id_con=:llavecon and consulta.id_historial=:llavehis;";
                     $con = Database::getConexion();
                     $stmt = $con->prepare($sql);   
                     $stmt->bindValue(":llavecon", $id_consulta,PDO::PARAM_INT);
                     $stmt->bindValue(":llavehis", $id_historial,PDO::PARAM_INT);
                     $stmt->execute();
                     $array_producto=$stmt->fetchall();
                    // echo '<pre>'; print_r($array_producto); echo '</pre>';
                    // echo '<pre>'; print_r($id_consulta); echo '</pre>';
                    // echo '<pre>'; print_r($id_historial); echo '</pre>';
                    foreach ($array_producto as $key => $value) {
                        echo 
                        "<tr>
                            <td>" .($key + 1). "</td>
                            <td>" .$value["nombre_prod"]. "</td>
                            <td>" .$value["precio_prod"]. "</td>";
                        //  if ($value["estado_prod"]=="a"){
                        //         echo"    
                        //         <td><button class='btn btn-success btn-sm'>Activo</button></td>";
                        //    }else{
                        //          echo"    
                        //            <td><button class='btn btn-danger btn-sm'>Inactivo</button></td>";
                        //     }

                         
// index.php?view=editespecialidad&id=$id
                         // index.php?action=deleteespecialidad&id=$id
                        echo "                            
                    </tr>";
                    }

                  ?>
            
                </tbody>

                <tfoot>

                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>Nombre Producto</th>
                        <th>Estado</th>
                        <!-- <th>Operaciones</th> -->

                    </tr>

                </tfoot>

            </table>
                       
            <a href="javascript:history.go(-1)" class="btn btn-primary btn-sm">atras</a>     
        </div>
          
    </div>
          
</section>