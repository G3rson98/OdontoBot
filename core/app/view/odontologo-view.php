      <!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Gestion de Odontólogo </h3>
            
            <a href="index.php?view=addodontologo" class="btn btn-primary btn-md" type="button" >Agregar Odontologo</a>

        </div>

        <div class="box-body">
                   
            <table id="" class="table table-bordered table-striped tablas" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>CI</th>
                        <th>Nombre</th>
                        <th>Género</th>
                        <th>Telefono-Celular</th>
                        <!-- <th>Especialidad</th> -->
                        <th>Estado</th>
                        <th>Operaciones</th>
                        <th>Especialidad</th> 
                        <th>Servicio</th>
                        <th>Horario</th>
                        

                    </tr>

                </thead>

                <tbody>
                  <?php
                    $array_odontologo = Odontologo::mostrarOdontologo();
                    // echo '<pre>'; print_r($array_odontologo); echo '</pre>';


                    foreach ($array_odontologo as $key => $value) {
                        echo 
                        "<tr>
                            <td>" .($key + 1). "</td>
                            <td>" .$value["ci"]. "</td>
                            <td>" .$value["nombre_per"]. " " .$value["paterno"]. " ". $value["materno"] ."</td>
                            <td>" .$value["sexo"]. "</td>
                            <td>" .$value["telefono"]. " - " . $value["celular"] . "</td>";

                         if ($value["estado_odon"]=="a"){
                                echo"    
                                <td><button class='btn btn-success btn-sm'>Activo</button></td>";
                            }else{
                                 echo"    
                                    <td><button class='btn btn-danger btn-sm'>Desactivo</button></td>";

                            }
                        $id=$value["ci"];
                        echo "
                            <td>
                            <a href='index.php?view=editodontologo&id=".$id."' class='btn btn-info btn-sm'><i class='fa fa-edit'></i></a>
                            <a href='index.php?action=deleteodontologo'class='btn btn-warning btn-sm'><i class='fa fa-eraser'></i></a>
                           
                        </td>";
                        echo"<td><a href='index.php?view=odontologoEspecialidad&id=$id' class='btn btn-info btn-sm'>Especialidad</a></td>";
                        echo"<td><a href='index.php?view=asignarservicio&id=$id' class='btn btn-info btn-sm'>Servicio</a></td>
                            <td><a href='index.php?view=odontologo-horario&ci=$id' class='btn btn-info btn-sm'><i class='fa fa-hourglass-start'></i></a></td>
                    </tr>";
                    }

                  ?>        
                </tbody>
                <!-- <i class="fa fa-eraser"></i> -->

                <tfoot>

                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>CI</th>
                        <th>Nombre</th>
                        <th>Género</th>
                        <th>Telefono-Celular</th>
                        <!-- <th>Especialidad</th> -->
                        <th>Estado</th>
                        <th>Operaciones</th>
                        <th>Especialidad</th> 
                        <th>Servicio</th>
                        <th>Horario</th>

                    </tr>

                </tfoot>

            </table>
                                    

        </div>

    </div>
          
</section>