 <!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Gestion de Especialidades</h3>
            
            <a href="index.php?view=addespecialidad" class="btn btn-primary btn-md" type="button" >Agregar Especialidad</a>

        </div>

        <div class="box-body">
                   
            <table id="" class="table table-bordered table-striped tablas" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Operaciones</th>

                    </tr>

                </thead>

                <tbody>
                  <?php
                    $array_especialidad = Especialidad::mostrarEspecialidad();
                    // echo '<pre>'; print_r($array_especialidad); echo '</pre>';
                    foreach ($array_especialidad as $key => $value) {
                        echo 
                        "<tr>
                            <td>" .($key + 1). "</td>
                            <td>" .$value["nombre_esp"]. "</td>";

                         if ($value["estado_espe"]=="a"){
                                echo"    
                                <td><button class='btn btn-success btn-sm'>Activo</button></td>";
                           }else{
                                 echo"    
                                   <td><button class='btn btn-danger btn-sm'>Desactivo</button></td>";
                            }

                         $id=$value["id_esp"];

                        echo "
                            <td>
                            <a href='index.php?view=editespecialidad&id=$id' class='btn btn-info btn-sm'><i class='fa fa-edit'></i></a>
                            <a href='index.php?action=deleteespecialidad&id=$id' class='btn btn-warning btn-sm'><i class='fa fa-eraser'></i></a></td>
                        </td>
                    </tr>";
                    }

                  ?>
            
                </tbody>

                <tfoot>

                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>Nombre</th>
                        <th>Estado</th>
                        <th>Operaciones</th>

                    </tr>

                </tfoot>

            </table>
                                    

        </div>

    </div>
          
</section>