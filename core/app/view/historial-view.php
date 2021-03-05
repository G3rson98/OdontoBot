<section class="content">


    <div class="box">

        <div class="box-header with-border">

            <h1 class="text-center"> Historial </h1>
        </div>

        <!-- Main content -->
        <div class="box">

            <div class="box-body">

                <h3 class="text-center">Datos Personales </h3>


                <?php
                $ci = isset($_GET["id"]) ? $_GET["id"] : "null";

                $paciente = Paciente::getPacienteByCI($ci);
                $ci_para_report=$paciente["ci_pac"];
                //echo '<pre>'; print_r($paciente); echo '</pre>';
                ?>

                <form class="form-horizontal" method="post" action="index.php?action=editpaciente">
                    <div class="form-group">

                        <label class="control-label col-sm-2" for="email">Nombre: </label>

                        <div class="col-sm-7">

                            <input value="<?php echo $paciente['nombre_per'];
                                            echo "  ";
                                            echo $paciente['paterno'];
                                            echo "  ";
                                            echo $paciente['materno']; ?>" type="text" class="form-control" name="nombre_pac" id="nombre_pac" maxlegth="30" readonly>

                        </div>
                        <input class='btn btn-info btn-sm' type="button" value="Generar Reporte de Historial" onclick="javascript:window.open('index.php?action=reportHistorial&ci=<?php echo $ci_para_report?>','','width=1000, height=1000, left=100, top=400');" />
                        

                    </div>

                    <!-- CAMPO CI  y fecha de nacimiento-->
                    <div class="form-group">

                        <label class="control-label col-sm-2" for="email">CI: </label>

                        <div class="col-sm-2">

                            <input value="<?php echo $paciente['ci']; ?>" type="text" class="form-control" name="ci_pac" id="ci_pac" readonly>

                        </div>

                        <label class="control-label col-sm-2" for="fecha_nac">Fecha Naciento: </label>

                        <div class="col-sm-3">

                            <input value="<?php echo $paciente['fecha_nac']; ?>" type="date" class="form-control" name="fecha_nac" id="fecha_nac" readonly>
                        </div>

                    </div>
                    <!-- CAMPO SEXO -->
                    <div class="form-group ">

                        <label class="control-label col-sm-2" for="sexo">Sexo: </label>

                        <div class="col-sm-1">

                            <label class="control-label radio-inline">
                                <?php if ($paciente['sexo'] == "M") { ?>

                                    <input value="<?php echo $paciente['sexo']; ?>" type="radio" name="sexo" checked readonly>
                                <?php } else { ?>
                                    <input value="M" type="radio" name="sexo">
                                <?php } ?>
                                M</label>

                        </div>
                        <div class="col-sm-1">
                            <label class="control-label radio-inline">
                                <?php if ($paciente['sexo'] == "F") { ?>

                                    <input value="<?php echo $paciente['sexo']; ?>" type="radio" name="sexo" checked readonly>
                                <?php } else { ?>
                                    <input value="M" type="radio" name="sexo">
                                <?php } ?>
                                F</label>
                        </div>
                        <div class="col-sm-1">
                            <label class="control-label radio-inline">
                                <?php if ($paciente['sexo'] == "O") { ?>

                                    <input value="<?php echo $paciente['sexo']; ?>" type="radio" name="sexo" checked readonly>
                                <?php } else { ?>
                                    <input value="O" type="radio" name="sexo">
                                <?php } ?>
                                Otros
                            </label>
                        </div>

                        <label class="control-label col-sm-2" for="pwd">Celular: </label>

                        <div class="col-sm-2">

                            <input value="<?php echo $paciente['celular']; ?>" type="text" class="form-control" id="celular" name="celular" readonly>

                        </div>

                    </div>


                    <div class="form-group">
                        <!-- CAMPO CELULAR -->
                        <label class="control-label col-sm-2" for="pwd">Celular: </label>

                        <div class="col-sm-3">

                            <input value="<?php echo $paciente['celular']; ?>" type="text" class="form-control" id="celular" name="celular" readonly>

                        </div>

                        <!-- CAMPO TELEFONO -->
                        <label class="control-label col-sm-1" for="email">Telefono:</label>

                        <div class="col-sm-3">

                            <input value="<?php echo $paciente['telefono']; ?>" type="text" class="form-control" id="telefono" name="telefono" readonly>

                        </div>

                    </div>
                    <!-- CAMPO DIRECCION -->
                    <div class="form-group">

                        <label class="control-label col-sm-2" for="direccion">Direccion: </label>

                        <div class="col-sm-7">

                            <input value="<?php echo $paciente['direccion']; ?>" type="text" class="form-control" id="direccion" name="direccion" readonly>

                        </div>

                    </div>

                    <!-- CAMPO LUGAR DE NACIMIENTO -->
                    <div class="form-group">

                        <label class="control-label col-sm-2" for="pwd">Lugar Nacimiento: </label>

                        <div class="col-sm-7">

                            <input value="<?php echo $paciente['lugar_nac']; ?>" type="text" class="form-control" id="lugar_nac" name="lugar_nac" readonly>

                        </div>

                    </div>

                    <!-- BOTONES DE ACCIONES -->


                </form>
            </div>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->

        <!-- campo de patologias -->
        <div class="box">
            <div class="box-body">
                <h3 class="text-center">Patologias</h3>

                <table id="" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr>

                            <th style="width: 10px;">#</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $ci = $_GET["id"];
                        $patologia_paciente = pas_pat::mostrarpatologia($ci);
                        // echo '<pre>'; print_r($arrayPacientes); echo '</pre>';

                        foreach ($patologia_paciente as $key => $value) {
                            $id_patologia = $value["id_pat"];
                            $nombre_pato = Patologia::getpatologia($id_patologia);
                            $descripcion_pat = $value["descripcion"];

                            echo "<tr>
                            <td>" . ($key + 1) . "</td>
                            <td>" . $nombre_pato["1"] . "</td>
                            <td>" . $descripcion_pat . "</td>
        
                            
                        </tr>";
                        }
                        ?>
                    </tbody>

                    <tfoot>
                        <tr>
                            <th style="width: 10px;">#</th>
                            <th>Nombre</th>
                            <th>Descripcion</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- fin de campo de patologias -->

        <!-- inicio del campo de consultas -->
        <div class="box">
            <h3 class="text-center">Consultas </h3>
            <div class="box-body">

                <table id="" class="table table-bordered table-striped" width="100%">

                    <thead>

                        <tr>

                            <th style="width: 10px;">#</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Odontologo</th>
                            <th>Motivo</th>
                            <th>Diagnostico</th>                            
                            <th>Fecha de Retorno</th>                                            
                            <th>Ver</th>

                        </tr>

                    </thead>

                    <tbody>
                        <?php
                        $ci = $_GET["id"];
                        $arrayPacientes = Historial::getHistorial($ci);
                       
                        
                        foreach ($arrayPacientes as $key => $value) {
                            $id_ficha=$value["id_ficha"];
                            $fecha_ficha=Ficha::getfichabyid($id_ficha);
                            // echo '<pre>';
                            // print_r($value);
                            // echo '</pre>';
                            $odont_agenda=Odontologo::getOdontobyAgenda($fecha_ficha["id_agen"]);
                            $id_historial = $value["id_historial"];
                            $id_consulta = $value["id_con"];
                            $receta = Receta::getReceta($id_historial, $id_consulta);
                            echo "<tr>
                                
                                <td>" . ($key + 1) . "</td>
                                <td> ".$fecha_ficha["fecha_fic"]."</td>
                                <td> ".$fecha_ficha["hora"]."</td>
                                <td>".$odont_agenda["nombre_per"]." ".$odont_agenda["paterno"]." ".$odont_agenda["materno"]." </td>
                                <td>" . $value["motivo"] . "</td>
                                <td>" . $value["diagnostico"] . "</td>";

                            
                            // Telefono - celular
                            //$telf = $value["telefono"];
                            // $cell = $value["celular"];
                            echo "                               
                                <td>" . $value["fecha_retorno"]."</td>";
                                $id_historial=$value["id_his"];
                                $id_consulta=$value["id_con"];                            
                                $id_pac=$value["ci_paciente"];
                                $id_ficha=$value["id_ficha"];
                            echo "
                                <td>
                                <a href=' index.php?view=verconsulta&id_his=$id_historial&id_cons=$id_consulta&ci_per=$id_pac&id_ficha=$id_ficha' class='btn btn-info btn-sm'><i class='fa fa-edit'></i></a>
                                
                                </td>
                    </tr>";
                        }
                        ?>
                    </tbody>

                    <tfoot>

                        <tr>
                            <th style="width: 10px;">#</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Odontologo</th>
                            <th>Motivo</th>
                            <th>Diagnostico</th>                        
                            <th>Fecha de Retorno</th>                                                                                
                            <th>Ver</th>
                        </tr>

                    </tfoot>

                </table>


            </div>
        </div>

    </div>

</section>