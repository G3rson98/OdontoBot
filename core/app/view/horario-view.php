<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Gestion de Horario </h3>
            
            <a href="index.php?view=addhorario" class="btn btn-primary btn-md" type="button" >Agregar Horario</a>

        </div>

        
        <div class="box-body">

                   
            <table id="" class="table table-bordered table-striped tablas" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>Día</th>
                        <th>Hora Inicio</th>
                        <th>Hora Final</th>
                        <th>Estado</th>
                        <th>Operaciones</th>

                    </tr>

                </thead>

                <tbody>
                    <?php 

                        $horarios = Horario::mostrarHorarios();
                        // echo '<pre>'; print_r($horarios); echo '</pre>';

                        foreach ($horarios as $key => $value) {
                            # code...
                            echo '<tr>
                                    <td>'.($key+1).'</td>
                                    <td>'.$value["dia"].'</td>
                                    <td>'.$value["hra_inicio"].'</td>
                                    <td>'.$value["hra_fin"].'</td>
                                    <td><button class="btn btn-success btn-sm">Activo</button></td>';
                            $idHor= $value["id_hor"];

                            echo"   <td>
                                        <a href='index.php?view=edithorario&id=$idHor' class='btn btn-info btn-sm'><i class='fa fa-pencil-square-o'></i></a>
                                    </td>
                                </tr>";
                        }

                     ?>
                    
                                    
                    <!--    $fecha1 = new dateTime($value['ultimaCompra']);
                            $fecha2 = new dateTime($value['fechaInsertado']);

                            $fechamostrar1=$fecha1->format("d-m-Y H:i:s");
                            $fechamostrar2=$fecha2->format("d-m-Y"); -->
                   
                </tbody>

                <tfoot>

                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>Dia</th>
                        <th>Hora Inicio</th>
                        <th>Hora Final</th>
                        <th>Estado</th>
                        <th>Operaciones</th>
                    </tr>

                </tfoot>

            </table>
                                    

        </div>

    </div>
          
</section>
