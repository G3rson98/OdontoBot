
<section class="content">

    
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Gestion de Paciente </h3>
            
            <a href="index.php?view=addpaciente" class="btn btn-primary btn-md" type="button" >Agregar Paciente</a>

        </div>        
        <div class="box-body">

            <table id="" class="table table-bordered table-striped" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>CI</th>
                        <th>Nombre</th>
                        <th>Género</th>
                        <th>Telef - Cel</th>
                        <th>Fecha Nac</th>
                        <th>Direccion</th>
                        <th>Lugar Nac</th>
                        <th>Estado</th>
                        <th>Operaciones</th>
                        <th>Patologias</th>
                     
                    </tr>

                </thead>

                <tbody>
                  <?php
                    
                    $arrayPacientes = Paciente::mostrarPacientes(); 
                    // echo '<pre>'; print_r($arrayPacientes); echo '</pre>';

                    foreach ($arrayPacientes as $key => $value) {
                        echo"<tr>
                                <td>".($key+1)."</td>
                                <td>".$value["ci"]."</td>
                                <td>".$value["nombre_per"]." ".$value["paterno"]."</td>";
                            
                            echo "<td>".$value["sexo"]."</td>";

                              
                        // Telefono - celular
                        $telf = $value["telefono"];
                        $cell = $value["celular"];
                            echo"
                                <td>".$telf." - ".$cell."</td>
                                <td>".$value["fecha_nac"]."</td>
                                <td>".$value["direccion"]."</td>
                                <td>".$value["lugar_nac"]."</td>";
                            if($value["estado_pac"]== "a"){
                                echo"<td><button class='btn btn-success btn-sm'>Activo</button></td>";

                            }else{

                                echo"<td><button class='btn btn-danger btn-sm'>Inactivo</button></td>";

                            }
                            $ci = $value["ci"];
                            echo"
                                <td>
                                    <a href='index.php?view=editpaciente&id=$ci' class='btn btn-info btn-sm'><i class='fa fa-edit'></i></a>
                                    <button class='btn btn-warning btn-sm'><i class='fa fa-eraser'></i></button>
                                </td>";
                                
                             echo"<td><a href='index.php?view=asignarpatologia&id=$ci' class='btn btn-info btn-sm'>Patologias</a></td>
                            
                    </tr>";
                        
                    }

                 

                  ?>
                

                   
                </tbody>

                <tfoot>

                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>CI</th>
                        <th>Nombre</th>
                        <th>Genero</th>
                        <th>Telef - Cel</th>
                        <th>Fecha Nac</th>
                        <th>Direccion</th>
                        <th>Lugar Nac</th>
                        <th>Estado</th>
                        <th>Operaciones</th>
                        <th>Patologias</th>
                    </tr>

                </tfoot>

            </table>
                                    

        </div>

    </div>
          
</section>