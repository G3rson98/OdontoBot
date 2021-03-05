<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">
            <?php 
                $ci = isset($_GET["ci"])? $_GET["ci"] : "null";

                $odontologo = Odontologo::getOdontologoByCI($ci);
                // echo '<pre>'; print_r($odontologo); echo '</pre>';
             ?>
            <h3 class="text-center">Horario de odontologo <?php echo $odontologo["nombre_per"]; ?> </h3>
            <a href="javascript:history.go(-1)" class="btn btn-default btn-md" type="button" >atras</a>
            <?php echo"<a href='index.php?view=addodont-horario&ci=$ci' class='btn btn-primary btn-md' type='button' >agregar horario</a>"; ?>

        </div>

        
        <div class="box-body">

                   
            <table id="" class="table table-bordered table-striped" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>Día</th>
                        <th>Hora Inicio</th>
                        <th>Hora Final</th>

                    </tr>

                </thead>

                <tbody>
                    <?php 

                        $odontoHorario = OdontoHorario::getHorioDeOdontologo($ci);
                        // echo '<pre>'; print_r($odontoHorario); echo '</pre>';

                        if(count($odontoHorario)){

                           foreach ($odontoHorario as $key => $value) {
                            # code...
                            echo '<tr>
                                    <td>'.($key+1).'</td>
                                    <td>'.$value["dia"].'</td>
                                    <td>'.$value["hra_inicio"].'</td>
                                    <td>'.$value["hra_fin"].'</td>';
                            
                        }

                        }else{

                            echo '<pre>'; print_r("tabla vacia"); echo '</pre>';
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
                    </tr>

                </tfoot>

            </table>

                                    

        </div>

    </div>
          
</section>
