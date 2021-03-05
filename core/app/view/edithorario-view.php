<!-- Main content -->
<section class="content">
    <div class="box">
        <!-- CABEZA DE LA CAJA -->
        <div class="box-header with-border">

            <h3 class="text-center">Editar Horario</h3>

        </div>
        <!-- CUERPO DE LA CAJA -->
        <div class="box-body">

            <form class="form-horizontal" method="post" action="index.php?action=edithorario">
                <?php 
                $id = isset($_GET["id"])? $_GET["id"] : "null";
                // echo '<pre>'; print_r($id); echo '</pre>';

                 $horario = Horario::getHorarioById($id);
                 // echo '<pre>'; print_r($horario); echo '</pre>';
                 ?>

                <!-- CAMPO DIA -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="email">Día: </label>

                    <div class="col-sm-6">

                        <!-- <select  class="form-control selectEmpleado" name="nombre_rol" required>
                            <option value="">Selecione Dia</option>
                            <option>Lunes</option>
                            <option>Martes</option>
                            <option>Miercoles</option>
                            <option>Jueves</option>
                            <option>Viernes</option>
                            <option>Sabados</option>
                        </select> -->
                        <input value="<?php echo $horario['dia']; ?>" type="text" class="form-control" name="dia" readonly>
                        <input value="<?php echo $horario['id_hor']; ?>"  type="hidden" name="idHorario">


                    </div>

                </div>
                
                <!-- CAMPO HORA Inicio -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Hora inicio: </label>
                    <div class="col-sm-2"> 

                        <input value="<?php echo $horario['hra_inicio']; ?>" type="time" name="horaInicio" class="form-control" min="1" maxlength="2" max="24">

                    </div>
                    

                </div>

                <!-- CAMPO Hora Final -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Hora final: </label>
                    <div class="col-sm-2"> 

                        <input value="<?php echo $horario['hra_fin']; ?>" type="time" name="horaFinal" class="form-control" min="1" maxlength="2" max="24">

                    </div>

                </div>

                
                <div class="form-group"> 

                    <div class="col-sm-offset-2 col-sm-10">

                        <button type="submit" class="btn btn-primary btn-md">Editar</button>
                        <a href="index.php?view=horario" type="button" class="btn btn-default btn-md">Cancelar</a>
                    </div>
                </div>

            </form>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>