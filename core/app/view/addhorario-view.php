<!-- Main content -->
<section class="content">
    <div class="box">
        <!-- CABEZA DE LA CAJA -->
        <div class="box-header with-border">

            <h3 class="text-center">Agregar Horario</h3>

        </div>
        <!-- CUERPO DE LA CAJA -->
        <div class="box-body">

            <form class="form-horizontal" method="post" action="index.php?action=addhorario">

                <!-- CAMPO DIA -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="email">Día: </label>

                    <div class="col-sm-6">

                        <select  class="form-control" name="dia" required>
                            <option value="">Selecione Dia</option>
                            <option>lunes</option>
                            <option>martes</option>
                            <option>miercoles</option>
                            <option>jueves</option>
                            <option>viernes</option>
                            <option>sabados</option>
                        </select>

                    </div>

                </div>
                
                <!-- CAMPO HORA Inicio -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Hora inicio: </label>
                    <div class="col-sm-2"> 

                        <input value="12:00" type="time" name="horaInicio" class="form-control" min="1" maxlength="2" max="24" required>

                    </div>
                    

                </div>

                <!-- CAMPO Hora Final -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Hora final: </label>
                    <div class="col-sm-2"> 

                        <input value="12:00" type="time" name="horaFinal" class="form-control" min="1" maxlength="2" max="24" required>

                    </div>

                </div>

                <div class="form-group"> 

                    <div class="col-sm-offset-2 col-sm-10">

                        <button type="submit" class="btn btn-primary btn-md">Agregar</button>
                        <a href="index.php?view=horario" type="button" class="btn btn-default btn-md">Cancelar</a>
                    </div>
                </div>

            </form>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>
<!-- Caja-box-->