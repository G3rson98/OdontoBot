<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Gestion de Recepcionista </h3>
            
            <a href="index.php?view=addrecepcionista" class="btn btn-primary btn-md" type="button" >Agregar Recepcionista</a>

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

                    </tr>

                </thead>

                <tbody>
                  <?php
                    $array_odontologo = Recepcionista::mostrarRecepcionista();
                    // echo '<pre>'; print_r($array_odontologo); echo '</pre>';


                    foreach ($array_odontologo as $key => $value) {
                        echo 
                        "<tr>
                            <td>" .($key + 1). "</td>
                            <td>" .$value["ci"]. "</td>
                            <td>" .$value["nombre_per"]. " " .$value["paterno"]. " ". $value["materno"] ."</td>
                            <td>" .$value["sexo"]. "</td>
                            <td>" .$value["telefono"]. " - " . $value["celular"] . "</td>";

                         if ($value["estado_rec"]=="a"){
                                echo"    
                                <td><button class='btn btn-success btn-sm'>Activo</button></td>";
                            }else{
                                 echo"    
                                    <td><button class='btn btn-danger btn-sm'>Desactivo</button></td>";

                            }

                        echo "
                            <td>
                            <a href='index.php?view=editrecepcionista&id=".$value["ci"]."' class='btn btn-info btn-sm'><i class='fa fa-edit'></i></a>
                            <a href='index.php?action=deleterecepcionista&id=".$value["ci"]."'class='btn btn-warning btn-sm'><i class='fa fa-eraser'></i></a>
                        </td>
                    </tr>";
                    }

                  ?>
            


                    <!-- <?php
                                                    
                            $fecha1 = new dateTime($value['ultimaCompra']);
                            $fecha2 = new dateTime($value['fechaInsertado']);

                            $fechamostrar1=$fecha1->format("d-m-Y H:i:s");
                            $fechamostrar2=$fecha2->format("d-m-Y");         

                    ?> -->
                </tbody>

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
                    </tr>

                </tfoot>

            </table>
                                    

        </div>

    </div>
          
</section>