<!-- Main content -->
<section class="content">
    <div class="box">
        <!-- CABEZA DE LA CAJA -->
        <div class="box-header with-border">

            <h3 class="text-center">Editar Patologia</h3>

        </div>
        <!-- CUERPO DE LA CAJA -->
        <div class="box-body">

            <form class="form-horizontal" method="post" action="index.php?action=editpatologia">

                <!-- CAMPO NOMBRE -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="email">Nombre: </label>

                    <div class="col-sm-8">
                        <?php  $patologia= Patologia::getPatologia($_GET["id"]) ;
                        ?>
                        <input value="<?php echo $patologia["nombre_pat"];?>" name="nombre" type="text" class="form-control" id="nombre" placeholder="" required maxlength="50">
                        <input value="<?php echo $patologia["id_pat"];?>" name="id" type="hidden" class="form-control" id="nombre" placeholder="">
                    </div>

                </div>
                
               

                <div class="form-group"> 

                    <div class="col-sm-offset-2 col-sm-10">

                        <button type="submit" class="btn btn-primary btn-md">Editar patologia</button>
                        <a href="index.php?view=patologia" type="button" class="btn btn-default btn-md">Cancelar</a>
                    </div>
                </div>

            </form>
        </div>
        <!-- /.box-body -->
        
    </div>
    <!-- /.box -->

</section>
<!-- Caja-box-->