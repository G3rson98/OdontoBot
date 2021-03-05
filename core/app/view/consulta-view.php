<!-- Main content -->
<section class="content">

    <!-- Default box -->
    <div class="box">

        <div class="box-header with-border">
            <h3 class="text-center">Fichas del día:</h3>
        </div>
        <div class="box-body">
            <table id="" class="table table-bordered table-striped tablas" width="100%">
                <thead>
                    <tr>
                        <th style="width: 10px;">#</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Comenzar consulta</th>

                    </tr>

                </thead>
                <tbody>
                    <?php
                    $ci=$_SESSION["idPersona"];
                    $array_fichas_de_hoy= ficha::getFichadehoy($ci);
                    $va=0;
                        
                     //echo '<pre>'; print_r($array_fichas_de_hoy); echo '</pre>';
                    foreach ($array_fichas_de_hoy as $key => $value) {
                        // if (Consulta::FichaYaTieneConsulta($value["id_fic"])=="false") {
                           
                        $paciente=Paciente::getPacienteByCI($value["ci_pac"]);
                        $va=$va+1;
                        echo
                            "<tr>
                            <td>" . ($key + 1) . "</td>
                            <td>" . $paciente["nombre_per"]." ".$paciente["paterno"]." ".$paciente["materno"]. "</td>
                            <td>" . $value["fecha_fic"]."</td>
                            <td>" . $value["hora"] . "</td>";                
                        echo "
                            <td>
                            <a href='index.php?action=addconsulta&id=".$value["ci_pac"]."&ficha=".$value["id_fic"] ."' class='btn btn-info btn-sm'><i class='fa fa-edit'></i></a>
                             </td>
                    </tr>";
                        // }
                    }
                    if ($va==0) {
                        echo "<p style='text-align:center'>No hay fichas reservadas para hoy.</p>";
                    }

                    ?>
                </tbody>
                <tfoot>
                    <!-- <tr>
                        <th style="width: 10px;">#</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Hora</th>
                        <th>Comenzar consulta</th>
                    </tr> -->
                </tfoot>
            </table>
        </div>
    </div>
</section>