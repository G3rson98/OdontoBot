<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Trabajadores</h3>
            
            <!-- <a href="index.php?view=addodontologo" class="btn btn-primary btn-md" type="button" >Agregar Odontologo</a>
            <a href="index.php?view=addpaciente" class="btn btn-primary btn-md" type="button" >Agregar Recepcionista</a>
             --><a href="index.php?view=odontologo" class="btn btn-primary btn-md" type="button" >Listar Odontologo</a>
            <a href="index.php?view=recepcionista" class="btn btn-primary btn-md" type="button" >Listar Rrecepcionistaa</a>

        </div>

        

        <div class="box-body">

                  <?php

                  $sql="select * from persona where persona.ci not in(select paciente.ci_pac from paciente)";
                  $con = Database::getConexion();
                  $stmt = $con->prepare($sql);
                  $stmt->execute(); 
                  $resp=$stmt->fetchAll();
                  // echo '<pre>'; print_r($resp); echo '</pre>';

                  ?>
                   
            <table id="" class="table table-bordered table-striped tablas" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>CI</th>
                        <th>Nombre</th>
                        <th>Genero</th>
                        <th>Telef - Cel</th>
                        <th>Direccion</th>
                        <th>Fecha Nac</th>
                        

                    </tr>

                </thead>

                <tbody>
                    <?php 

                    foreach ($resp as $key => $value) {
                        echo"<tr>
                            <td>".($key+1)."</td>
                            <td>".$value["ci"]."</td>";
                            
                         $nombreCompleto = $value["nombre_per"] ." ". $value["paterno"] ." ". $value["materno"];

                        echo"
                            <td>".$nombreCompleto."</td>";
                        echo"
                            <td>".$value["sexo"]."</td>
                            <td>".$value["telefono"]. "-" .$value["celular"]."</td>
                            <td>".$value["direccion"]."</td>";
                            $originalDate =$value["fecha_nac"] ;
                            $newDate = date("d/m/Y", strtotime($originalDate));
                        echo"<td>".$newDate."</td>";

                            // if ($value["estado_"]=="a"){
                            //     echo"    
                            //     <td><button class='btn btn-success btn-sm'>Activo</button></td>";
                            // }else{
                            //      echo"    
                            //         <td><button class='btn btn-danger btn-sm'>Desactivo</button></td>
                            //         <td>";

                            // }
                         
                   echo "</tr>";
                        
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
                        <th>Direccion</th>
                        <th>Fecha Nac</th>
                        
                    </tr>

                </tfoot>

            </table>
                                    

        </div>

    </div>
          
</section>