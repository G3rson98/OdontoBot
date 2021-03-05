<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Gestion de Materia Prima </h3>
            
            <a href="index.php?view=addMateriaPrima" class="btn btn-primary btn-md" type="button" >Agregar Materia Prima</a>
            <form class="form-horizontal" method="POST" action="index.php?action=ReporteMateriales">
    
        </div>

        
        <div class="box-body">

                   
            <table id="" class="table table-bordered table-striped" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Cantidad Usada</th>
                        <th>Total Usos</th>
                        <th>Cant Inventario</th>
                        <th>Opciones</th>
                    </tr>

                </thead>

                <tbody>
               <?php
                    $array_MateriaPrima = MateriaPrima::mostrarMateriaPrima();
                   // echo"<pre>";print_r ($array_MateriaPrima);echo"<pre>";
                    

                    foreach ($array_MateriaPrima as $key => $value) {
                        echo 
                        "<tr>
                            <td>" .($key + 1)."</td>
                            <td>".($value["nombre_mat"])."</td>
                            <td>".($value["descripcion_mat"])."</td>
                        ";

                        if ($value["estado_mat"]=='a'){
                            echo"    
                            <td><button class='btn btn-success btn-sm'>Activo</button></td>";
                        }else{
                             echo"    
                                <td><button class='btn btn-danger btn-sm'>Inactivo</button></td>";

                        }
                        $id=$value["id_mat"];
                        echo "<td>".($value["cant_usos"])."</td>
                              <td>".($value["tot_usos"])."</td>
                              <td>".($value["stock"])."</td
                              
                       
                       </tr>";
                       echo "<td><a href='index.php?view=editMatPrima&id=$id' class='btn btn-info btn-sm'>Edit</a>
                       <a href='index.php?action=deleteMateriaPrima&id=$id'class='btn btn-warning btn-sm'>Delete</a>
                       </td>";
                             


                        
                    }
                   

                  ?> 

                </tbody>
                <!-- <button type="submit" class="btn btn-primary btn-md">Generar Reporte</button> -->
                </form>

               <!-- <tfoot>

                <th style="width: 10px;">#</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Duracion</th>
                        <th>Estado</th>
                        <th>Operaciones</th>

                </tfoot>
            -->


            </table>
                                    

        </div>

    </div>
          
</section>