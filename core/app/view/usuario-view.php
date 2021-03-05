
      <!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Gestion de Usuario </h3>
            
            <!-- <a href="index.php?view=addusuario" class="btn btn-primary btn-md" type="button" >Agregar Usuario</a> -->

        </div>

        

        <div class="box-body">
                   
            <table id="" class="table table-bordered table-striped tablas" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th>User name</th>                        
                        <th>Estado</th>
                        <th>Operaciones</th>

                    </tr>

                </thead>

                <tbody>
                  <?php
                     $arrayUsuario = Usuario::mostrarUsuario();
                     // echo '<pre>'; print_r($arrayUsuario); echo '</pre>';
                    foreach ($arrayUsuario as $key => $value) {
                        echo"<tr>
                            <td>".($key+1)."</td>";
                         $nombreCompleto = $value["nombre_per"] ." ". $value["paterno"] ." ". $value["materno"];

                        echo"
                            <td>".$nombreCompleto."</td>";
                        echo"
                            <td>".$value["nombre_rol"]."</td>
                            <td>".$value["nombre_usuario"]."</td>";


                            if ($value["estado_usu"]=="a"){
                                echo"    
                                <td><button class='btn btn-success btn-sm'>Activo</button></td>";
                            }else{
                                 echo"    
                                    <td><button class='btn btn-danger btn-sm'>Desactivo</button></td>
                                    <td>";

                            }

                            $idUsuario = $value["id_usu"];
                            echo "
                            <td>
                            <a href='index.php?view=editusuario&id=$idUsuario' class='btn btn-info btn-sm'>Edit</a>
                            <button class='btn btn-warning btn-sm'>Delete</button>
                        </td>
                    </tr>";
                        
                    }
                    

                  ?>
                    <!-- <tr>
                        <td>1</td>
                        <td>Julian</td>
                        <td>admin</td>
                        <td>julian</td>
                        <td>05-04-2019 10:09</td>
                        <td><button class="btn btn-success btn-sm">Activo</button></td>
                        <td>
                            <a href="index.php?view=editusuario" class="btn btn-info btn-sm">Edit</a>
                            <button class="btn btn-warning btn-sm">Delete</button>
                        </td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Julian</td>
                        <td>admin</td>
                        <td>julian</td>
                        <td>05-04-2019 10:09</td>
                        <td><button class="btn btn-success btn-sm">Activo</button></td>
                        <td>
                            <a href="index.php?view=editusuario" class="btn btn-info btn-sm">Edit</a>
                            <button class="btn btn-warning btn-sm">Delete</button>
                        </td>
                    </tr> -->
                    


                    <!-- <?php
                            
                        foreach ($respuesta as $key => $value) {
                
                                
                            echo "<tr>
                                    <td style='width: 10px;' >".($key+1)."</td>
                                    <td>".$value['ci']."</td>
                                    <td class='text-capitalize'>".$value['nombre']."</td>
                                    <td>".$value['correo']."</td>
                                    <td>".$value['telefono']."</td>";

                            if($value['estado'] == 1){

                                echo"<td> 
                                        <div class='btn-group'>
                                            <button idEstadoCliente='".$value['idpersona']."' estado='0' class='btn btn-warning btn-sm btnEstado'>Desactivo</buton>
                                        </div>

                                    </td>";

                            }else{

                                echo"<td>
                                        <button idEstadoCliente='".$value['idpersona']."' estado='1' class='btn btn-success btn-sm btnEstado'>Activo</buton>
                                    </td>";


                            }

                            echo "<td> 
                                        <div class='btn-group'>
                                            <button ciCliente='".$value['ci']."' class='btn btn-info btn-md btnEditarCliente' data-toggle='modal' data-target='#modalEditarCliente'><i class='fa fa-pencil'></i></buton>

                                            <button idCliente='".$value['idpersona']."' class='btn btn-danger btn-md btnEliminarCliente'><i class='fa fa-trash'></i></buton>

                                        </div>
                                </td>";

                                    
                            $fecha1 = new dateTime($value['ultimaCompra']);
                            $fecha2 = new dateTime($value['fechaInsertado']);

                            $fechamostrar1=$fecha1->format("d-m-Y H:i:s");
                            $fechamostrar2=$fecha2->format("d-m-Y");

                            echo "<td>".$fechamostrar1."</td>
                                  <td>".$fechamostrar2."</td>

                            </tr>";
                             
                        }//end foreach

                    ?> -->
                </tbody>

                <tfoot>

                    <tr>
                        
                        <th style="width: 10px;">#</th>
                        <th>Nombre</th>
                        <th>Rol</th>
                        <th>User name</th>
                        <th>Estado</th>
                        <th>Operaciones</th>
                    </tr>

                </tfoot>

            </table>
                                    

        </div>

    </div>
          
</section>