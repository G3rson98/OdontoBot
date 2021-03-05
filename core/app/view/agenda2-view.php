<?php 

// echo '<pre>'; print_r($_POST); echo '</pre>';
$tiempo=$_POST["tiempo"];
$odontologo=$_POST["odont"];

$odont=Odontologo::getOdontologoByCI($odontologo);
// echo '<pre>'; print_r($odont); echo '</pre>';
?>

<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">

            <?php 
            echo "<h2 class='text-center'>Agenda: <small>".$odont["nombre_per"]." ".$odont["paterno"]." ".$odont["materno"]."</small></h2>";
             ?>

        </div>

        <div class="box-body">
                   
            <table id="agenda" class="table table-bordered table-striped tablas" width="100%">
                        
                <thead>

                    <tr>

                        <th style="width: 10px;">#</th>
                        <th>Nombre Paciente</th>
                        <th>Fecha</th>
                        <th>Hora</th>
						<th>Servicio</th>
                    </tr>

                </thead>

                <tbody>
                  <?php
                   
                  	if ($tiempo==1) {
                  		$fichas=Agenda::mostrarFichasDia($odontologo);
                  	}else if ($tiempo==2) {
                  		$fichas=Agenda::mostrarFichasMes($odontologo);
                  	}else{
                  		$fichas=Agenda::mostrarFichasAño($odontologo);
                  		
                  		
                  	}
                  		// echo '<pre>'; print_r($fichas); echo '</pre>';
                  	foreach ($fichas as $key => $value) {
                  		// echo '<pre>'; print_r($value); echo '</pre>';
                  		$paciente=Paciente::getPacienteByCI($value["ci_pac"]);
                  		$id_servicio=Agenda::getServicioDeFicha($value["id_fic"]);
                  		$servicio=Servicio::getservicio($id_servicio["id_serv"]);
                  		// echo '<pre>'; print_r($servicio); echo '</pre>';
                  		// echo '<pre>'; print_r($id_servicio); echo '</pre>';
                  		// echo '<pre>'; print_r($paciente); echo '</pre>';
                  		echo "
						<tr>
						<td>".($key + 1)."</td>
						<td>".$paciente["nombre_per"]." ".$paciente["paterno"]." ".$paciente["materno"]."</td>
						<td>".$value["fecha_fic"]."</td>
						<td>".$value["hora"]."</td>
						<td>".$servicio["nombre_ser"]."</td>

						</tr>



                  		";
                  	}


                  ?>
            
                </tbody>

                <tfoot>

                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>Nombre Paciente</th>
                        <th>Fecha</th>
                        <th>Hora</th>
						<th>Servicio</th>

                    </tr>

                </tfoot>

            </table>
                                    

        </div>

    </div>
          
</section>





 