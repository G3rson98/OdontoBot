<!-- Main content -->
<section class="content">
    <div class="box">
        <!-- CABEZA DE LA CAJA -->
        <div class="box-header with-border">

            <h3 class="text-center">Agregar MateriaPrima</h3>

        </div>
        <!-- CUERPO DE LA CAJA -->
        <div class="box-body">
            <?php
                $id = isset($_GET["id"])? $_GET["id"] : "null"; 
                $MateriaPrima = MateriaPrima::getMateriaPrima($id);
             
             ?>

            <form class="form-horizontal" method="post" action="index.php?action=editMatPrima">

                <!-- CAMPO NOMBRE -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="email">Nombre: </label>

                    <div class="col-sm-8">

                        <input type="text" value="<?php echo $MateriaPrima['nombre_mat']; ?>" name="nombre_mat" class="form-control"  id="nombre_mat"  required maxlength="70" >
                        <input value="<?php echo $MateriaPrima['id_mat']; ?>" type="hidden" class="form-control" name="id_mat" id="id_mat" >

                    </div>  

                </div>
                
                <!-- CAMPO Descripcion-->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Descripción: </label>
                    <div class="col-sm-8"> 

                        <input type="text" name="descripcion_mat" class="form-control" id="descripcion_mat" value="<?php echo $MateriaPrima['descripcion_mat']; ?>"  maxlength="200" required>

                    </div>

                </div>

                <!-- CAMPO Utilidad -->
                 <div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Tot de Usos: </label>
                    <div class="col-sm-8"> 

                        <input type="text" name="tot_usos" class="form-control" id="tot_usos" value="<?php echo $MateriaPrima['tot_usos']; ?>"  required maxlength="3">

                    </div>

                </div> 
                <!-- CAMPO Stock-->
                <!--<div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Stock: </label>
                    <div class="col-sm-8"> 

                        <input type="text" name="stock" class="form-control" id="stock" placeholder="ingresar unidades"  maxlength="200">

                    </div>

                </div>-->

                
                <div class="form-group"> 

                    <div class="col-sm-offset-2 col-sm-10">

                        <button type="submit" class="btn btn-primary btn-md">Actualizar MateriaPrima</button>
                        <a href="index.php?view=MateriaPrima" type="button" class="btn btn-default btn-md">Cancelar</a>
                    </div>
                </div>

            </form>
        </div>
        <!-- /.box-body -->
        
        
    </div>
    <!-- /.box -->

</section>
<!-- Caja-box-->