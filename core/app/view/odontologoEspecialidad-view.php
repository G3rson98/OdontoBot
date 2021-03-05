     <!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">
                    <?php 
                $id = isset($_GET["id"])? $_GET["id"] : "null";

                $odontologo = Odontologo::getOdontologoByCI($id);
                 // echo '<pre>'; print_r($odontologo); echo '</pre>';
             ?>

        <div class="box-header with-border">

            <h3 class="text-center">Dr. <?php echo $odontologo["nombre_per"]." ". $odontologo["paterno"]." " .$odontologo["materno"];?></h3> 
            <h4>Especialidades: </h4>
            
           

        </div>

        <div class="box-body">
            <?php 

                $array_odontologoEspecialidad = OdontologoEspecialidad::mostrarOdontologoEspecialidad($id);
                if (count($array_odontologoEspecialidad)<1) {
                    echo "No tiene especialidad";
                }else{
                    


                    echo "
                   
                    <table id='' class='table table-bordered table-striped' width='100%'>
                                
                        <thead>

                            <tr>

                                <th style='width: 10px;'>Nro</th>
                                <th>Nombre especialidad</th>

                            </tr>

                        </thead>

                        <tbody>";
                           
                        
                         foreach ($array_odontologoEspecialidad as $key => $value) {
                            echo 
                            "<tr>
                                <td>" .($key + 1). "</td>
                                <td>" .$value["nombre_esp"]. "</td>
                             </tr>";
                         }
            
                         

                         
            
                    echo" 
                        </tbody>

                        <tfoot>
                
                        </tfoot>

                     </table>";
                    
                }

             ?>

                <div>

                    <?php

                      echo "

               <a href='index.php?view=addodontologoEspecialidad&id=$id' class='btn btn-primary btn-md' type='button' >Agregar Especialidad</a>
                      ";             
                     ?>
                    <a href="index.php?view=odontologo" class="btn btn-primary btn-md" type="button" >Salir</a>
                </div>
        </div>

    </div>
          
</section>