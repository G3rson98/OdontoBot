<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <h3 class="text-center"> Gestion de Horario </h3>

            
            <a href="index.php?view=addhorario" class="btn btn-primary btn-md" type="button" >Agregar Horario</a>
            <?php $ci = isset($_GET["ci"])? $_GET["ci"] : "null"; ?>
        </div>

        
        <div class="box-body">

            <form class="form-horizontal" method="POST" action="index.php?action=addodontohorario">
                   <input type="hidden" name="ciOdont" value="<?php echo $ci; ?>">
                    <table id="" class="table table-bordered table-striped" width="100%">
                                
                        <thead>

                            <tr>

                                <th style="width: 10px;">#</th>
                                <th>Día</th>
                                <th>Hora Inicio</th>
                                <th>Hora Final</th>
                                <th>Seleccione</th>
                                <!-- <th>Nro Consultorio</th> -->

                            </tr>

                        </thead>

                        <tbody>
                            <?php 

                                $horarios = Horario::mostrarHorarioNoAsignado($ci);
                                // echo '<pre>'; print_r($horarios); echo '</pre>';

                                foreach ($horarios as $key => $value) {
                                    # code...
                                    echo '<tr>
                                            <td>'.($key+1).'</td>
                                            <td>'.$value["dia"].'</td>
                                            <td>'.$value["hra_inicio"].'</td>
                                            <td>'.$value["hra_fin"].'</td>
                                            <td><input value="'.$value["id_hor"].'" name="horarios[]" type="checkbox"></td>';
                                            // <td><input value="" min="1" maxlength="2" max="100" name="Consultorio[]" type="number"></td>';
                                 
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
                                <th>Seleccione</th>
                                <!-- <th>Nro Consultorio</th> -->
                            </tr>

                        </tfoot>

                    </table>
                    <br><br>
                    <!-- BOTONES DE ACCIONES -->
                <div class="form-group"> 

                    <div class="col-sm-offset-2 col-sm-10">

                        <button type="submit" class="btn btn-primary btn-md">Guardar</button>
                        <a href="javascript:history.go(-1)" type="button" class="btn btn-default btn-md">Cancelar</a>
                    </div>
                </div>
            </form>                        

        </div>

    </div>
          
</section>
