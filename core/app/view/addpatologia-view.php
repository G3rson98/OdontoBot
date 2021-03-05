<!-- Main content -->
<section class="content">
    <div class="box">
        <!-- CABEZA DE LA CAJA -->
        <div class="box-header with-border">

            <h3 class="text-center">Agregar Patologia</h3>

        </div>
        <!-- CUERPO DE LA CAJA -->
        <div class="box-body">

            <form class="form-horizontal" method="post" action="index.php?action=addpatologia">

                <!-- CAMPO NOMBRE -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="email">Nombre: </label>

                    <div class="col-sm-8">

                        <input type="text" name ="nombre" class="form-control" id="nombre" placeholder="ingrese nombre de la patologia" required maxlength="50">

                    </div>

                </div>
                
               

                <div class="form-group"> 

                    <div class="col-sm-offset-2 col-sm-10">

                        <button type="submit" class="btn btn-primary btn-md">Agregar patologia</button>
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