<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Gestion de Productos Terminados</h3>
            
            <a href="index.php?view=addproducto" class="btn btn-primary btn-md" type="button" >Agregar Producto</a>

        </div>

        <div class="box-body">
                   
            <table id="" class="table table-bordered table-striped tablas" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>Nombre Producto</th>
                        <th>Estado</th>
                        <th>Operaciones</th>

                    </tr>

                </thead>

                <tbody>
                  <?php
                    $array_producto = Producto::mostrarProducto();
                    // echo '<pre>'; print_r($array_producto); echo '</pre>';
                    foreach ($array_producto as $key => $value) {
                        echo 
                        "<tr>
                            <td>" .($key + 1). "</td>
                            <td>" .$value["nombre_prod"]. "</td>";

                         if ($value["estado_prod"]=="a"){
                                echo"    
                                <td><button class='btn btn-success btn-sm'>Activo</button></td>";
                           }else{
                                 echo"    
                                   <td><button class='btn btn-danger btn-sm'>Inactivo</button></td>";
                            }

                         $id=$value["id_prod"];
// index.php?view=editespecialidad&id=$id
                         // index.php?action=deleteespecialidad&id=$id
                        echo "
                            <td>
                            <a href=' index.php?view=editproducto&id=$id' class='btn btn-info btn-sm'><i class='fa fa-edit'></i></a>
                            <a href='index.php?action=deleteproducto&id=$id' class='btn btn-warning btn-sm'><i class='fa fa-eraser'></i></a></td>
                        </td>
                    </tr>";
                    }

                  ?>
            
                </tbody>

                <tfoot>

                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>Nombre Producto</th>
                        <th>Estado</th>
                        <th>Operaciones</th>

                    </tr>

                </tfoot>

            </table>
                                    

        </div>

    </div>
          
</section>