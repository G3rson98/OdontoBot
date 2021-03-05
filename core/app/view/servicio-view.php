<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Gestion de Servicio </h3>
            
            <a href="index.php?view=addservicio" class="btn btn-primary btn-md" type="button" >Agregar Servicio</a>



        </div>

        
        <div class="box-body">

                   
            <table id="" class="table table-bordered table-striped tablas" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Duracion</th>
                        <th>Estado</th>
                        
                        <th>Operaciones</th>
                        <th>Materiales</th>
                    </tr>

                </thead>

                <tbody>
               <?php
                    $array_patologia = Servicio::mostrarServicio();
                   //  echo '<pre>'; print_r($array_patologia); echo '</pre>';


                    foreach ($array_patologia as $key => $value) {
                        echo 
                        "<tr>
                            <td>" .($key + 1)."</td>
                            <td>".($value["nombre_ser"])."</td>
                            <td>".($value["descripcion_ser"])."</td>
                            <td>".($value["t_duracion"])."</td>
                        ";
                        if ($value["estado_ser"]=="a"){
                            echo"    
                            <td><button class='btn btn-success btn-sm'>Activo</button></td>";
                        }else{
                             echo"    
                                <td><button class='btn btn-danger btn-sm'>Inactivo</button></td>";

                        }
                        $id=$value["id_ser"];
                        echo "
                            <td>
                            <a href='index.php?view=editservicio&id=$id' class='btn btn-info btn-sm'><i class='fa fa-edit'></i></a>
                            <a href='index.php?action=delservicio&id=$id'class='btn btn-warning btn-sm'><i class='fa fa-eraser'></i></a>
                        </td>
                    ";
                        echo "<td><a href='index.php?view=asignarServMat&id=$id' class='btn btn-info btn-sm'>Materiales</a></td>
                        </tr>";
                    }

                  ?> 
                </tbody>

                <tfoot>

                <th style="width: 10px;">#</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Duracion</th>
                        <th>Estado</th>
                    
                        <th>Operaciones</th>
                        <th>Materiales</th>

                </tfoot>

            </table>
                                    

        </div>

    </div>
          
</section>