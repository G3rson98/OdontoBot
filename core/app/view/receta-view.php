<!-- Main content -->
<section class="content">
    <div class="box">
        <!-- CABEZA DE LA CAJA -->
        <div class="box-header with-border">

            <h3 class="text-center">Receta</h3>                        

        </div>
        <div class="box-body">
        
        
        
        </div>
        <!-- CUERPO DE LA CAJA -->
        <div class="box-body">
            
            <form class="form-horizontal" method="post" action="index.php?action=addreceta">
                         
                <!-- CAMPO Descripcion-->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Descripcion  : </label>
                    <div class="col-sm-8"> 
                        <?php 
                            $ficha=$_GET["id"];
                            $id_historial=$_GET["id_his"];
                            $id_consulta=$_GET["id_cons"];

                            $arrays=Receta::getReceta($id_historial,$id_consulta);
                            
                            if (count($arrays)>0){
                                $array=$arrays[0];
                                echo "<input type='text'  name='descripcion' class='form-control' value='".$array["descripcion_rece"]."' placeholder='ingresar descripcion'  maxlength='500'>";
                            }else{
                                echo "<input type='text'  name='descripcion' class='form-control' value='' placeholder='ingresar descripcion'  maxlength='500'>";
                            }
                        
                       ?>

                        

                        <?php
                            $id_historial=$_GET["id_his"];
                            $id_consulta=$_GET["id_cons"];
                            $id_pac=$_GET["id_pac"];
                            $id_ficha=$_GET["id_ficha"];
                        ?>
                        <input type="hidden" class="form-control" value="<?php echo $_GET["id"]?>" name="id" >
                        <input type="hidden" class="form-control" value="<?php echo $_GET["id_cons"]?>" name="id_cons" >
                        <input type="hidden" class="form-control" value="<?php echo $_GET["id_his"]?>" name="id_his" >
                        <input type="hidden" class="form-control" value="<?php echo $_GET["id_pac"]?>" name="ci_per" >
                        <input type="hidden" class="form-control" value="<?php echo $_GET["id_ficha"]?>" name="id_ficha" >
                    </div>

                </div>

               
                <div class="form-group"> 

                    <div class="col-sm-offset-2 col-sm-10">

                        <button type="submit" class="btn btn-primary btn-md">Guardar Receta</button>
                        <a href="index.php?view=consulta" type="button" class="btn btn-default btn-md">Cancelar</a>
                    </div>
                </div>

            </form>
        </div>
        <!-- /.box-body -->
        
        
    </div>
    <!-- /.box -->

</section>
<!-- Caja-box-->