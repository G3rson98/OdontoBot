<!-- Main content -->
<section class="content">
    <div class="box">
        <!-- CABEZA DE LA CAJA -->
        <div class="box-header with-border">

            <h3 class="text-center">Editar Servicio</h3>

        </div>
        <!-- CUERPO DE LA CAJA -->
        <div class="box-body">

            <form class="form-horizontal" method="post" action="index.php?action=editserv">
                    <?php  $servicio= Servicio::getservicio($_GET["id"]) ;
                        ?>
                <!-- CAMPO NOMBRE -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="email">Nombre: </label>

                    <div class="col-sm-8">
                        
                        <input value="<?php echo $servicio["nombre_ser"];?>" name="nombre" type="text" class="form-control" id="nombre" placeholder="" required maxlength="70">
                        <input value="<?php echo $servicio["id_ser"];?>" name="id" type="hidden" class="form-control" id="nombre" placeholder="">
                        <input value="a" name="estado" type="hidden" class="form-control" id="nombre" placeholder="">
                    </div>

                </div>
                
                <!-- CAMPO APELLIDO PATERNO -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Descricpcion: </label>
                    <div class="col-sm-8"> 

                        <input value="<?php echo $servicio["descripcion_ser"];?>" name="descripcion" type="text" class="form-control" id="apellidoPaterno" placeholder="" maxlength="200">

                    </div>

                </div>

                <!-- CAMPO APELLIDO MATERNO -->
                <div class="form-group">
                     
                    <label class="control-label col-sm-2" for="apellidoMaterno">Duracion: </label>

                    <div class="col-sm-1">

                        <input value="<?php echo $servicio["t_duracion"];?>" name="duracion"type="number" class="form-control" id="apellidoMaterno" placeholder="" required>
                    </div>

                </div>

                
                <div class="form-group"> 

                    <div class="col-sm-offset-2 col-sm-10">

                        <button type="submit" class="btn btn-primary btn-md">Editar Servicio</button>
                        <a href="index.php?view=servicio" type="button" class="btn btn-default btn-md">Cancelar</a>
                    </div>
                </div>

            </form>
        </div>
        <!-- /.box-body -->
    </div>
    <!-- /.box -->

</section>
<!-- Caja-box-->