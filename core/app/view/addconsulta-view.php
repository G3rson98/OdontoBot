<!-- Main content -->
<?php //echo '<pre>'; print_r($_GET); echo '</pre>'; ?>
<section class="content">
    <div class="box">
        <!-- CABEZA DE LA CAJA -->
        <div class="box-header with-border">

            <h3 class="text-center">Consulta</h3>
            <?php 
                // echo '<pre>'; print_r($_GET); echo '</pre>';
                $id_historial=$_GET["id_his"];
                $id_consulta=$_GET["id_cons"];
                $id_pac=$_GET["ci_per"];
                $id_ficha=$_GET["id_ficha"];
                if (FormularioVida::ConsultaTieneFV($id_consulta,$id_historial)=="true") {
                    echo "<a href='index.php?view=editFormularioVida&id_his=$id_historial&id_cons=$id_consulta&id_pac=$id_pac&id_ficha=$id_ficha' type='button' class='btn btn-primary btn-md'>Formulario de vida</a>";
                }else{


                echo "<a href='index.php?view=addFormularioVida&id_his=$id_historial&id_cons=$id_consulta&id_pac=$id_pac&id_ficha=$id_ficha' type='button' class='btn btn-primary btn-md'>Formulario de vida</a> ";
                }
                $idficha = $_GET["id_ficha"];
                echo "<a href='index.php?view=receta&id_his=$id_historial&id_cons=$id_consulta&id_pac=$id_pac&id_ficha=$id_ficha&id=$idficha' type='button' class='btn btn-primary btn-md'>Receta</a>   ";
                
        
            if(NotaVenta::existeNotaVenta($id_historial,$id_consulta)){
                echo "<a href='index.php?view=addProducto_Consulta&id_his=$id_historial&id_cons=$id_consulta&id_pac=$id_pac&id_ficha=$id_ficha' type='button' class='btn btn-primary btn-md' disabled>Productos Consulta</a>   ";
                echo "<a href='index.php?view=servicio_consulta&id=$idficha&id_his=$id_historial&id_cons=$id_consulta&id_pac=$id_pac&id_ficha=$id_ficha' type='button' class='btn btn-primary btn-md' disabled>Servicios</a>  ";
            }else{
                echo "<a href='index.php?view=addProducto_Consulta&id_his=$id_historial&id_cons=$id_consulta&id_pac=$id_pac&id_ficha=$id_ficha' type='button' class='btn btn-primary btn-md'>Productos Consulta</a>   ";

                echo "<a href='index.php?view=servicio_consulta&id=$idficha&id_his=$id_historial&id_cons=$id_consulta&id_pac=$id_pac&id_ficha=$id_ficha' type='button' class='btn btn-primary btn-md'>Servicios</a>  ";
            }
            
            echo "<a href='index.php?view=odontograma&id_his=$id_historial&id_cons=$id_consulta' type='button' class='btn btn-primary btn-md'>Odontograma</a>   ";
                
            echo "<a href='index.php?view=addnotaventa&id_his=$id_historial&id_cons=$id_consulta' type='button' class='btn btn-primary btn-md'>Nota venta</a>   ";
            
            ?>
        <input class='btn btn-info btn-sm' type="button" value="Generar Reporte de la Receta" onclick="javascript:window.open('index.php?action=reportReceta&id_historial=<?php echo $id_historial?>&id_consulta=<?php echo $id_consulta?>','','width=1000, height=1000, left=100, top=400');" />
        <input class='btn btn-info btn-sm' type="button" value="Generar Reporte de la Nota Venta" onclick="javascript:window.open('index.php?action=reportNotaVenta&id_historial=<?php echo $id_historial?>&id_consulta=<?php echo $id_consulta?>','','width=1000, height=1000, left=100, top=400');" />
        </div>

        <div class="box-body">



        </div>
        <!-- CUERPO DE LA CAJA -->
        <div class="box-body">

            <form class="form-horizontal" method="post" action="index.php?action=editconsulta">


                <!-- CAMPO NOMBRE -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="email">Motivo: </label>

                    <div class="col-sm-8">
                        <?php 
                            $consulta=Consulta::getconsultabyficha($idficha);
                            $id_historial=$consulta["id_historial"];
                            $id_consulta=$consulta["id_con"];
                            $get_consulta=Consulta::getSolaconsulta($idficha,$id_consulta,$id_historial);
                            // echo '<pre>'; print_r($get_consulta); echo '</pre>';
                            $bandera_consulta=Consulta::getconsultabyficha($id_ficha);
                            if ($bandera_consulta["0"]!= 0 ) {
                                echo"<input value='".$get_consulta["motivo"]."' type='text' name='motivo' class='form-control' id='motivo' placeholder='ingrese nombre' required>";                                
                            }else{
                                 echo"<input type='text' name='motivo' class='form-control' id='motivo' placeholder='ingrese nombre' required>";
                            }

                         ?>
                        <?php
                            $idficha = $_GET["id_ficha"];
                            echo "<input type='hidden' name='ficha'value=".$idficha." class='form-control' id='ficha' placeholder='ingrese nombre'>";
                        ?>

                    </div>

                </div>

                <!-- CAMPO Descripcion-->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Diagnostico : </label>
                    <div class="col-sm-8">
                        <?php 
                        if ($bandera_consulta["0"]!= 0 ) {
                                echo"<input value='".$get_consulta["diagnostico"]."' type='text' name='diagnostico' class='form-control' id='diagnostico' placeholder='ingrese nombre' required>";                                
                            }else{
                                 echo"<input type='text' name='diagnostico' class='form-control' id='diagnostico' placeholder='ingrese nombre' required>";
                            }



                         ?>
                        

                    </div>

                </div>

                <!-- CAMPO APELLIDO MATERNO -->
                <div class="form-group">

                    <label class="control-label col-sm-2" for="pwd">Tratamiento: </label>
                    <div class="col-sm-8">
                        <?php 
                            if ($bandera_consulta["0"]!= 0 ) {
                                echo"<input value='".$get_consulta["tratamiento"]."' type='text' name='tratamiento' class='form-control' id='tratamiento' placeholder='ingrese nombre' required>";                                
                            }else{
                                 echo"<input type='text' name='diagnostico' class='form-control' id='diagnostico' placeholder='ingrese nombre' required>";
                            }




                         ?>

                       
                    </div>

                </div>
                <div class="form-group">

                    <label class="control-label col-sm-2" for="fechaFicha">Fecha de retorno : </label>

                    <div class="col-sm-3">
                        <?php 
                        if ($bandera_consulta["0"]!= 0 ) {
                                echo"<input value='".$get_consulta["fecha_retorno"]."' type='date' name='fechaFicha' class='form-control' id='fechaFicha' placeholder='ingrese nombre' required>";                                
                            }else{
                                 echo"<input type='date' name='fechaFicha' class='form-control' id='fechaFicha'  required>";
                            }

                         ?>

                        
                    </div>

                </div>
                <div class="form-group">

                    <div class="col-sm-offset-2 col-sm-10">

                        <button type="submit" class="btn btn-primary btn-md">Agregar Consulta</button>
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