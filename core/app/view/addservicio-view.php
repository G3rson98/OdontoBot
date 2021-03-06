<!-- Main content -->
<section class="content">
    <div class="box">
        <!-- CABEZA DE LA CAJA -->
        <div class="box-header with-border">

            <h3 class="text-center">Agregar Servicio</h3>

        </div>
        <!-- CUERPO DE LA CAJA -->
        <div class="box-body">

            <form class="form-horizontal" method="post" action="index.php?action=addservicio">

                <!-- CAMPO NOMBRE -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="email">Nombre: </label>

                    <div class="col-sm-8">

                        <input type="text"  name="nombre" class="form-control"  id="nombre" placeholder="ingrese nombre" required maxlength="70" >

                    </div>  

                </div>
                
                <!-- CAMPO Descripcion-->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Descricpcion: </label>
                    <div class="col-sm-8"> 

                        <input type="text" name="descripcion" class="form-control" id="apellidoPaterno" placeholder="ingresar descripcion"  maxlength="200">

                    </div>

                </div>

                <!-- CAMPO APELLIDO MATERNO -->
                <div class="form-group">
                     
                    <label class="control-label col-sm-2" for="apellidoMaterno">Duracion: </label>

                    <div class="col-sm-1">

                        <input type="number"  name="duracion" class="form-control" min="1" max="240" name="duracion" id="apellidoMaterno" placeholder="" required>
                    </div>

                </div>

                
                <div class="form-group"> 

                    <div class="col-sm-offset-2 col-sm-10">

                        <button type="submit" class="btn btn-primary btn-md">Agregar Servicio</button>
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