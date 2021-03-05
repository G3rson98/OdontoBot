
<section class="content">

    
<div class="box">

    <div class="box-header with-border">

        <h3 class="text-center"> Historial </h3>
    </div>        
    <div class="box-body">

        <table id="" class="table table-bordered table-striped tablas" width="100%">
                    
            <thead>

                <tr>

                    <th style="width: 10px;">#</th>
                    <th>CI</th>
                    <th>Nombre</th>
                   
                    <th>Telef - Cel</th>
                   
                    <th>Direccion</th>
                    
                    <th>Estado</th>                    
                    <th>Historial</th>
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
                    // Telefono - celular
                    $telf = $value["telefono"];
                    $cell = $value["celular"];
                        echo"
                            <td>".$telf." - ".$cell."</td>
                            
                            <td>".$value["direccion"]."</td>";
                        if($value["estado_pac"]== "a"){
                            echo"<td><button class='btn btn-success btn-sm'>Activo</button></td>";

                        }else{

                            echo"<td><button class='btn btn-danger btn-sm'>Inactivo</button></td>";

                        }
                        $ci = $value["ci"];
                        
                            
                         echo"<td><a href='index.php?view=historial&id=$ci' class='btn btn-info btn-sm'>Historial</a></td>
                </tr>";
                    
                }

             

              ?>
            

               
            </tbody>

            <tfoot>

                <tr>
                    <th style="width: 10px;">#</th>
                    <th>CI</th>
                    <th>Nombre</th>
                    
                    <th>Telef - Cel</th>
                    
                    <th>Direccion</th>
                    
                    <th>Estado</th>                    
                    <th>Historial</th>
                    
                </tr>

            </tfoot>

        </table>
                                

    </div>

</div>
      
</section>